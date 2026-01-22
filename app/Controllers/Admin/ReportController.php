<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;

class ReportController extends BaseController
{
    public function finance()
    {
        $mode = trim((string) $this->request->getGet('mode')); // daily|monthly
        if ($mode === '')
            $mode = 'daily';

        // status yang dihitung sebagai omzet
        // default: paid + done (lebih masuk akal daripada pending)
        $statusFilter = $this->request->getGet('status');
        $allowedStatus = ['paid', 'done', 'processing', 'pending', 'cancelled', 'awaiting_payment'];
        $statusList = [];

        if (is_array($statusFilter)) {
            foreach ($statusFilter as $st) {
                $st = trim((string) $st);
                if (in_array($st, $allowedStatus, true))
                    $statusList[] = $st;
            }
        }

        // default kalau tidak dipilih: paid + done
        if (empty($statusList))
            $statusList = ['paid', 'done'];

        $orderModel = new OrderModel();

        if ($mode === 'monthly') {
            $month = trim((string) $this->request->getGet('month')); // YYYY-MM
            if ($month === '')
                $month = date('Y-m');

            $start = $month . '-01';
            $end = date('Y-m-d', strtotime($start . ' +1 month'));

            $builder = $orderModel->builder();
            $rows = $builder
                ->select("DATE(created_at) as trx_day,
                          COUNT(*) as trx_count,
                          SUM(total) as omzet,
                          SUM(discount) as total_discount")
                ->where('created_at >=', $start . ' 00:00:00')
                ->where('created_at <', $end . ' 00:00:00')
                ->whereIn('status', $statusList)
                ->groupBy('trx_day')
                ->orderBy('trx_day', 'ASC')
                ->get()
                ->getResultArray();

            $summary = $orderModel->builder()
                ->select("COUNT(*) as trx_count,
                          SUM(total) as omzet,
                          SUM(discount) as total_discount")
                ->where('created_at >=', $start . ' 00:00:00')
                ->where('created_at <', $end . ' 00:00:00')
                ->whereIn('status', $statusList)
                ->get()
                ->getFirstRow('array') ?? ['trx_count' => 0, 'omzet' => 0, 'total_discount' => 0];

            return view('admin/reports/finance', [
                'title' => 'Laporan Keuangan',
                'mode' => 'monthly',
                'month' => $month,
                'date' => null,
                'rows' => $rows,
                'summary' => $summary,
                'statusList' => $statusList,
            ]);
        }

        // DAILY
        $date = trim((string) $this->request->getGet('date')); // YYYY-MM-DD
        if ($date === '')
            $date = date('Y-m-d');

        $start = $date . ' 00:00:00';
        $end = $date . ' 23:59:59';

        $orders = $orderModel->where('created_at >=', $start)
            ->where('created_at <=', $end)
            ->whereIn('status', $statusList)
            ->orderBy('id', 'DESC')
            ->findAll();

        $trxCount = 0;
        $omzet = 0;
        $totalDiscount = 0;

        foreach ($orders as $o) {
            $trxCount++;
            $omzet += (int) ($o['total'] ?? 0);
            $totalDiscount += (int) ($o['discount'] ?? 0);
        }

        return view('admin/reports/finance', [
            'title' => 'Laporan Keuangan',
            'mode' => 'daily',
            'month' => null,
            'date' => $date,
            'rows' => $orders, // list order detail
            'summary' => [
                'trx_count' => $trxCount,
                'omzet' => $omzet,
                'total_discount' => $totalDiscount,
            ],
            'statusList' => $statusList,
        ]);
    }
}
