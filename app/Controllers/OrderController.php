<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\WaTemplateModel;

class OrderController extends BaseController
{
    // ✅ RIWAYAT PESANAN (untuk user login)
    public function index()
    {
        // cek login (customerauth harusnya sudah handle, ini safety)
        $loggedIn = (bool) session()->get('customer_logged_in');
        if (!$loggedIn) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil nomor HP customer dari session
        $customerPhone = (string) (session()->get('customer_phone') ?? '');
        $customerPhone = preg_replace('/\D+/', '', $customerPhone);

        if ($customerPhone === '') {
            return redirect()->to('/')->with('error', 'Data akun tidak lengkap (nomor HP tidak ditemukan).');
        }

        // Ambil orders berdasarkan customer_phone (karena kolom customer_id tidak ada)
        $orders = (new OrderModel())
            ->where('customer_phone', $customerPhone)
            ->orderBy('id', 'DESC')
            ->findAll();

        return view('orders/index', [
            'title' => 'Riwayat Pembelian',
            'orders' => $orders,
        ]);
    }

    public function show(string $invoice)
    {
        $order = (new OrderModel())->where('invoice', $invoice)->first();
        if (!$order) {
            return redirect()->to('/')->with('error', 'Invoice tidak ditemukan.');
        }

        $items = (new OrderItemModel())->where('order_id', (int) $order['id'])->findAll();

        return view('shop/order', [
            'title' => 'Invoice ' . $invoice,
            'order' => $order,
            'items' => $items,
        ]);
    }

    public function whatsapp(string $invoice)
    {
        $order = (new OrderModel())->where('invoice', $invoice)->first();
        if (!$order) {
            return redirect()->to('/')->with('error', 'Invoice tidak ditemukan.');
        }

        // Normalisasi nomor WA: hanya digit
        $phone = preg_replace('/\D+/', '', (string) ($order['customer_phone'] ?? ''));
        if ($phone === '') {
            return redirect()->to("/order/{$invoice}")->with('error', 'Nomor WhatsApp tidak valid.');
        }

        // Format pesan (bisa kamu ganti nanti dari wa_templates)
        $template = (new WaTemplateModel())->getActiveByKey('payment_confirm');

        $items = (new OrderItemModel())->where('order_id', (int) $order['id'])->findAll();
        $itemsText = '';
        foreach ($items as $it) {
            $itemsText .= "- " . ($it['menu_name'] ?? '') . " x" . (int) $it['qty']
                . " = Rp" . number_format((int) $it['line_total'], 0, ',', '.') . "\n";
        }

        $queueNumber = '';
        $queueDate = '';
        $db = db_connect();
        if ($db->tableExists('queues')) {
            $q = $db->table('queues')->where('order_id', (int) $order['id'])->get()->getFirstRow('array');
            if ($q) {
                $queueNumber = (string) ($q['queue_number'] ?? '');
                $queueDate = (string) ($q['queue_date'] ?? '');
            }
        }

        $raw = $template['message'] ?? "Halo Admin,\nSaya konfirmasi pembayaran.\nInvoice: {invoice}\nTotal: Rp{total}\n\n{items}";

        $repl = [
            '{invoice}' => (string) ($order['invoice'] ?? ''),
            '{customer_name}' => (string) ($order['customer_name'] ?? ''),
            '{customer_phone}' => (string) ($order['customer_phone'] ?? ''),
            '{subtotal}' => number_format((int) ($order['subtotal'] ?? 0), 0, ',', '.'),
            '{discount}' => number_format((int) ($order['discount'] ?? 0), 0, ',', '.'),
            '{total}' => number_format((int) ($order['total'] ?? 0), 0, ',', '.'),
            '{queue_number}' => $queueNumber,
            '{queue_date}' => $queueDate,
            '{items}' => trim($itemsText),
        ];

        $message = strtr($raw, $repl);

        // WA butuh urlencode
        $message = rawurlencode($message);

        // Nomor tujuan admin WA (set di .env)
        // contoh: ADMIN_WA_NUMBER=62812xxxxxxx
        $adminWa = getenv('ADMIN_WA_NUMBER') ?: '';
        $adminWa = preg_replace('/\D+/', '', $adminWa);

        if ($adminWa === '') {
            return redirect()->to("/order/{$invoice}")
                ->with('error', 'Nomor WhatsApp admin belum diset. Set ADMIN_WA_NUMBER di .env');
        }

        $url = "https://wa.me/{$adminWa}?text={$message}";
        return redirect()->to($url);
    }
}
