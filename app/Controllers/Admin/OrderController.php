<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\OrderItemModel;

class OrderController extends BaseController
{
    public function index()
    {
        $q = trim((string) $this->request->getGet('q'));
        $status = trim((string) $this->request->getGet('status'));

        $model = new OrderModel();

        if ($q !== '') {
            $model = $model->groupStart()
                ->like('invoice', $q)
                ->orLike('customer_name', $q)
                ->orLike('customer_phone', $q)
                ->groupEnd();
        }

        if ($status !== '') {
            $model = $model->where('status', $status);
        }

        $orders = $model->orderBy('id', 'DESC')->findAll(200);

        return view('admin/orders/index', [
            'title' => 'Orders',
            'orders' => $orders,
            'q' => $q,
            'status' => $status,
        ]);
    }

    public function show(int $id)
    {
        $order = (new OrderModel())->find($id);
        if (!$order) {
            return redirect()->to('/admin/orders')->with('error', 'Order tidak ditemukan.');
        }

        $items = (new OrderItemModel())->where('order_id', $id)->findAll();

        // Queue optional (kalau tabel queues ada)
        $queue = null;
        $db = db_connect();
        if ($db->tableExists('queues')) {
            $queue = $db->table('queues')->where('order_id', $id)->get()->getFirstRow('array');
        }

        return view('admin/orders/show', [
            'title' => 'Detail Order',
            'order' => $order,
            'items' => $items,
            'queue' => $queue,
        ]);
    }

    public function updateStatus(int $id)
    {
        $status = trim((string) $this->request->getPost('status'));

        $allowed = ['pending', 'awaiting_payment', 'paid', 'processing', 'done', 'cancelled'];
        if (!in_array($status, $allowed, true)) {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }

        $orderModel = new OrderModel();
        $order = $orderModel->find($id);
        if (!$order) {
            return redirect()->to('/admin/orders')->with('error', 'Order tidak ditemukan.');
        }

        $orderModel->update($id, ['status' => $status]);

        // (opsional) jika status paid, catat ke cash_ledger kalau tabelnya ada & belum pernah dicatat
        $db = db_connect();
        if ($status === 'paid' && $db->tableExists('cash_ledger')) {
            $exists = $db->table('cash_ledger')->where('order_id', $id)->countAllResults();

            if ((int) $exists === 0) {
                $db->table('cash_ledger')->insert([
                    'order_id' => $id,
                    'trx_date' => date('Y-m-d'),
                    'type' => 'income',
                    'amount' => (int) ($order['total'] ?? 0),
                    'description' => 'Pembayaran order ' . ($order['invoice'] ?? ''),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Status order berhasil diupdate.');
    }
}
