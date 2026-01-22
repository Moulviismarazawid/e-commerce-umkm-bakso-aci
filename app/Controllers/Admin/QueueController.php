<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\QueueModel;
use App\Models\OrderModel;

class QueueController extends BaseController
{
    public function index()
    {
        $date = trim((string) $this->request->getGet('date'));
        if ($date === '') {
            $date = date('Y-m-d');
        }

        $db = db_connect();

        // Join queues + orders agar admin lihat invoice/nama/total
        $rows = $db->table('queues q')
            ->select('q.*, o.invoice, o.customer_name, o.customer_phone, o.total, o.status as order_status')
            ->join('orders o', 'o.id = q.order_id', 'left')
            ->where('q.queue_date', $date)
            ->orderBy('q.queue_number', 'ASC')
            ->get()
            ->getResultArray();

        return view('admin/queue/index', [
            'title' => 'Antrian',
            'date' => $date,
            'rows' => $rows,
        ]);
    }

    public function updateStatus(int $id)
    {
        $status = trim((string) $this->request->getPost('status'));
        $allowed = ['waiting', 'cooking', 'done', 'cancelled'];

        if (!in_array($status, $allowed, true)) {
            return redirect()->back()->with('error', 'Status antrian tidak valid.');
        }

        $queueModel = new QueueModel();
        $queue = $queueModel->find($id);
        if (!$queue) {
            return redirect()->to('/admin/queue')->with('error', 'Data antrian tidak ditemukan.');
        }

        $queueModel->update($id, ['status' => $status]);

        // Opsional: sinkron status order mengikuti status antrian
        // waiting -> processing? (atau tetap pending)
        // cooking -> processing
        // done -> done
        // cancelled -> cancelled
        $orderStatusMap = [
            'waiting' => 'pending',
            'cooking' => 'processing',
            'done' => 'done',
            'cancelled' => 'cancelled',
        ];

        if (!empty($queue['order_id'])) {
            $mapped = $orderStatusMap[$status] ?? null;
            if ($mapped) {
                (new OrderModel())->update((int) $queue['order_id'], ['status' => $mapped]);
            }
        }

        return redirect()->back()->with('success', 'Status antrian berhasil diupdate.');
    }
}
