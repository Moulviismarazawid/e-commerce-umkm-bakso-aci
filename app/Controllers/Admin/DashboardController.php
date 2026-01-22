<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\PromoCodeModel;
use App\Models\MenuModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $db = db_connect();

        $today = date('Y-m-d');
        $start = $today . ' 00:00:00';
        $end = $today . ' 23:59:59';

        // Status yang dihitung sebagai omzet
        $paidStatuses = ['paid', 'done'];

        // Ringkasan hari ini (orders)
        $summaryRow = $db->table('orders')
            ->select('COUNT(*) as trx_count, COALESCE(SUM(total),0) as omzet, COALESCE(SUM(discount),0) as total_discount')
            ->where('created_at >=', $start)
            ->where('created_at <=', $end)
            ->whereIn('status', $paidStatuses)
            ->get()
            ->getFirstRow('array');

        $trxCount = (int) ($summaryRow['trx_count'] ?? 0);
        $omzet = (int) ($summaryRow['omzet'] ?? 0);
        $totalDiscount = (int) ($summaryRow['total_discount'] ?? 0);

        // Order perlu perhatian (pending/awaiting_payment) hari ini
        $needAction = (int) $db->table('orders')
            ->where('created_at >=', $start)
            ->where('created_at <=', $end)
            ->whereIn('status', ['pending', 'awaiting_payment'])
            ->countAllResults();

        // Antrian hari ini (jika tabel ada)
        $queueStats = [
            'total' => 0,
            'waiting' => 0,
            'cooking' => 0,
            'done' => 0,
        ];

        if ($db->tableExists('queues')) {
            $queueStats['total'] = (int) $db->table('queues')->where('queue_date', $today)->countAllResults();

            $queueStats['waiting'] = (int) $db->table('queues')
                ->where('queue_date', $today)->where('status', 'waiting')->countAllResults();

            $queueStats['cooking'] = (int) $db->table('queues')
                ->where('queue_date', $today)->where('status', 'cooking')->countAllResults();

            $queueStats['done'] = (int) $db->table('queues')
                ->where('queue_date', $today)->where('status', 'done')->countAllResults();
        }

        // Order terbaru
        $latestOrders = (new OrderModel())
            ->orderBy('id', 'DESC')
            ->findAll(10);

        // Promo aktif (opsional, kalau tabel ada)
        $activePromos = [];
        if ($db->tableExists('promo_codes')) {
            $activePromos = (new PromoCodeModel())
                ->where('is_active', 1)
                ->orderBy('id', 'DESC')
                ->findAll(5);
        }

        // Menu aktif (opsional)
        $activeMenus = [];
        if ($db->tableExists('menus')) {
            $activeMenus = (new MenuModel())
                ->where('is_active', 1)
                ->orderBy('id', 'DESC')
                ->findAll(5);
        }

        return view('admin/dashboard', [
            'title' => 'Dashboard',
            'today' => $today,

            'trxCount' => $trxCount,
            'omzet' => $omzet,
            'totalDiscount' => $totalDiscount,
            'needAction' => $needAction,

            'queueStats' => $queueStats,

            'latestOrders' => $latestOrders,
            'activePromos' => $activePromos,
            'activeMenus' => $activeMenus,
        ]);
    }
}
