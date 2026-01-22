<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\QueueModel;
use App\Models\PromoCodeModel;
use App\Models\CashLedgerModel;

class CheckoutController extends BaseController
{
    public function index()
    {
        $cart = session()->get('cart') ?? [];
        if (!$cart)
            return redirect()->to('/')->with('error', 'Keranjang kosong.');

        $customerName = session()->get('customer_name');
        $customerPhone = session()->get('customer_phone');

        return view('shop/checkout', [
            'cart' => $cart,
            'customerName' => $customerName,
            'customerPhone' => $customerPhone,
        ]);
    }


    public function placeOrder()
    {
        $cart = session()->get('cart') ?? [];
        if (!$cart)
            return redirect()->to('/')->with('error', 'Keranjang kosong.');

        $customerId = (int) session()->get('customer_id');
        $customerName = session()->get('customer_name') ?: trim((string) $this->request->getPost('customer_name'));
        $customerPhone = session()->get('customer_phone') ?: trim((string) $this->request->getPost('customer_phone'));

        $customerAddress = trim((string) $this->request->getPost('customer_address'));
        $notes = trim((string) $this->request->getPost('notes'));
        $promoCode = trim((string) $this->request->getPost('promo_code'));

        if ($customerName === '' || $customerPhone === '') {
            return redirect()->back()->withInput()->with('error', 'Nama & nomor WA wajib.');
        }

        $subtotal = 0;
        foreach ($cart as $c)
            $subtotal += ((int) $c['price'] * (int) $c['qty']);

        // Hitung diskon promo (opsional)
        $discount = 0;
        if ($promoCode !== '') {
            $promo = (new PromoCodeModel())->validatePromo($promoCode, $subtotal);
            if (!$promo['valid']) {
                return redirect()->back()->withInput()->with('error', $promo['message']);
            }
            $discount = (int) $promo['discount'];
        }

        $total = max(0, $subtotal - $discount);

        $db = db_connect();
        $db->transStart();

        $orderModel = new OrderModel();
        $invoice = $orderModel->generateInvoice();

        $orderId = $orderModel->insert([
            'invoice' => $invoice,
            'customer_name' => $customerName,
            'customer_phone' => $customerPhone,
            'customer_address' => $customerAddress,
            'notes' => $notes,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total,
            'promo_code' => $promoCode ?: null,
            'status' => 'pending',
        ], true);

        $itemModel = new OrderItemModel();
        foreach ($cart as $c) {
            $itemModel->insert([
                'order_id' => $orderId,
                'menu_id' => (int) $c['menu_id'],
                'menu_name' => $c['name'],
                'price' => (int) $c['price'],
                'qty' => (int) $c['qty'],
                'line_total' => (int) $c['price'] * (int) $c['qty'],
            ]);
        }

        // Queue harian
        $queueModel = new QueueModel();
        $today = date('Y-m-d');
        $queueNumber = $queueModel->nextQueueNumber($today);
        $queueModel->insert([
            'order_id' => $orderId,
            'queue_date' => $today,
            'queue_number' => $queueNumber,
            'status' => 'waiting'
        ]);

        // Promo: increment used (opsional)
        if ($promoCode !== '') {
            (new PromoCodeModel())->incrementUsed($promoCode);
        }

        // Ledger income *nanti* bisa dicatat saat admin konfirmasi pembayaran,
        // tapi kalau kamu mau catat saat order dibuat, uncomment:
        // (new CashLedgerModel())->insert([
        //   'order_id' => $orderId,
        //   'trx_date' => $today,
        //   'type' => 'income',
        //   'amount' => $total,
        //   'description' => "Order {$invoice}"
        // ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Gagal membuat order.');
        }

        session()->remove('cart');
        return redirect()->to("/order/{$invoice}");
    }
}
