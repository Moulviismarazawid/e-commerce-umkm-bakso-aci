<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php
$omzetVal = (int)($omzet ?? 0);
$discountVal = (int)($totalDiscount ?? 0);
$trxVal = (int)($trxCount ?? 0);
$needVal = (int)($needAction ?? 0);

$qTotal = (int)($queueStats['total'] ?? 0);
$qWaiting = (int)($queueStats['waiting'] ?? 0);
$qCooking = (int)($queueStats['cooking'] ?? 0);
$qDone = (int)($queueStats['done'] ?? 0);

$progressDone = ($qTotal > 0) ? (int)round(($qDone / $qTotal) * 100) : 0;

function badgeStatus(string $status): array
{
    $status = strtolower($status);
    return match ($status) {
        'paid' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'label' => 'paid'],
        'done' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'label' => 'done'],
        'processing' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-200', 'label' => 'processing'],
        'awaiting_payment' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-200', 'label' => 'awaiting_payment'],
        'pending' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-200', 'label' => 'pending'],
        'cancelled' => ['bg' => 'bg-rose-50', 'text' => 'text-rose-700', 'border' => 'border-rose-200', 'label' => 'cancelled'],
        default => ['bg' => 'bg-gray-50', 'text' => 'text-gray-700', 'border' => 'border-gray-200', 'label' => $status ?: '-'],
    };
}
?>

<!-- Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
    <div>
        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border bg-white text-xs text-gray-600">
            <i data-lucide="calendar" class="w-4 h-4"></i>
            Ringkasan hari ini: <b><?= esc($today ?? '') ?></b>
        </div>
        <h1 class="text-2xl font-extrabold mt-2">Dashboard</h1>
        <div class="text-sm text-gray-600">Pantau omzet, order, promo, dan antrian dengan cepat.</div>
    </div>

    <div class="flex gap-2">
        <a href="<?= site_url('admin/orders') ?>"
            class="px-4 py-2 rounded-xl border bg-white hover:bg-gray-50 text-sm inline-flex items-center gap-2">
            <i data-lucide="shopping-bag" class="w-4 h-4"></i> Kelola Order
        </a>
        <a href="<?= site_url('admin/reports/finance') ?>"
            class="px-4 py-2 rounded-xl text-white text-sm font-semibold shadow-sm
                   bg-gradient-to-r from-indigo-600 to-fuchsia-600 hover:opacity-95 inline-flex items-center gap-2">
            <i data-lucide="bar-chart-3" class="w-4 h-4"></i> Lihat Laporan
        </a>
    </div>
</div>

<!-- Metric Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

    <!-- Omzet -->
    <div class="rounded-2xl p-4 border bg-gradient-to-br from-emerald-50 to-white">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs text-emerald-700 font-semibold">OMZET</div>
                <div class="text-sm text-gray-600 mt-1">paid + done</div>
                <div class="text-2xl font-extrabold mt-2">Rp<?= number_format($omzetVal, 0, ',', '.') ?></div>
            </div>
            <div class="w-11 h-11 rounded-2xl bg-emerald-600 text-white flex items-center justify-center shadow-sm">
                <i data-lucide="wallet" class="w-5 h-5"></i>
            </div>
        </div>
        <div class="mt-3 text-xs text-gray-500">Update otomatis dari order hari ini.</div>
    </div>

    <!-- Diskon -->
    <div class="rounded-2xl p-4 border bg-gradient-to-br from-amber-50 to-white">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs text-amber-700 font-semibold">DISKON</div>
                <div class="text-sm text-gray-600 mt-1">total diskon</div>
                <div class="text-2xl font-extrabold mt-2">Rp<?= number_format($discountVal, 0, ',', '.') ?></div>
            </div>
            <div class="w-11 h-11 rounded-2xl bg-amber-500 text-white flex items-center justify-center shadow-sm">
                <i data-lucide="badge-percent" class="w-5 h-5"></i>
            </div>
        </div>
        <div class="mt-3 text-xs text-gray-500">Promo aktif memengaruhi diskon.</div>
    </div>

    <!-- Transaksi -->
    <div class="rounded-2xl p-4 border bg-gradient-to-br from-sky-50 to-white">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs text-sky-700 font-semibold">TRANSAKSI</div>
                <div class="text-sm text-gray-600 mt-1">jumlah transaksi</div>
                <div class="text-2xl font-extrabold mt-2"><?= $trxVal ?></div>
            </div>
            <div class="w-11 h-11 rounded-2xl bg-sky-600 text-white flex items-center justify-center shadow-sm">
                <i data-lucide="receipt" class="w-5 h-5"></i>
            </div>
        </div>
        <div class="mt-3 text-xs text-gray-500">Hitung dari order status paid/done.</div>
    </div>

    <!-- Need Action -->
    <div class="rounded-2xl p-4 border bg-gradient-to-br from-rose-50 to-white">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs text-rose-700 font-semibold">BUTUH TINDAKAN</div>
                <div class="text-sm text-gray-600 mt-1">pending / awaiting_payment</div>
                <div class="text-2xl font-extrabold mt-2"><?= $needVal ?></div>
            </div>
            <div class="w-11 h-11 rounded-2xl bg-rose-600 text-white flex items-center justify-center shadow-sm">
                <i data-lucide="bell-ring" class="w-5 h-5"></i>
            </div>
        </div>
        <div class="mt-3 text-xs text-gray-500">Perlu konfirmasi / follow up.</div>
    </div>
</div>

<!-- Queue + Latest Orders -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">

    <!-- Queue Card -->
    <div class="lg:col-span-1 rounded-2xl border bg-white p-4">
        <div class="flex items-center justify-between">
            <div class="font-extrabold flex items-center gap-2">
                <i data-lucide="list-ordered" class="w-5 h-5"></i> Antrian Hari Ini
            </div>
            <a href="<?= site_url('admin/queue') ?>" class="text-sm px-3 py-2 rounded-xl border hover:bg-gray-50 inline-flex items-center gap-2">
                <i data-lucide="arrow-right" class="w-4 h-4"></i> Buka
            </a>
        </div>

        <div class="mt-4 grid grid-cols-2 gap-3 text-sm">
            <div class="rounded-2xl border bg-gray-50 p-3">
                <div class="text-xs text-gray-500">Total</div>
                <div class="text-xl font-extrabold"><?= $qTotal ?></div>
            </div>
            <div class="rounded-2xl border bg-emerald-50 p-3">
                <div class="text-xs text-emerald-700">Selesai</div>
                <div class="text-xl font-extrabold text-emerald-800"><?= $qDone ?></div>
            </div>
            <div class="rounded-2xl border bg-amber-50 p-3">
                <div class="text-xs text-amber-700">Waiting</div>
                <div class="text-xl font-extrabold text-amber-800"><?= $qWaiting ?></div>
            </div>
            <div class="rounded-2xl border bg-sky-50 p-3">
                <div class="text-xs text-sky-700">Cooking</div>
                <div class="text-xl font-extrabold text-sky-800"><?= $qCooking ?></div>
            </div>
        </div>

        <div class="mt-4">
            <div class="flex items-center justify-between text-xs text-gray-500 mb-2">
                <span>Progress selesai</span>
                <b class="text-gray-700"><?= $progressDone ?>%</b>
            </div>
            <div class="h-2 rounded-full bg-gray-100 overflow-hidden">
                <div class="h-2 rounded-full bg-gradient-to-r from-emerald-500 to-emerald-700"
                    style="width: <?= $progressDone ?>%"></div>
            </div>

            <?php if (!db_connect()->tableExists('queues')): ?>
                <div class="mt-3 text-xs text-gray-500">
                    Tabel <b>queues</b> belum ada, statistik antrian belum tampil.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Latest Orders Table -->
    <div class="lg:col-span-2 rounded-2xl border bg-white overflow-hidden">
        <div class="p-4 flex items-center justify-between">
            <div class="font-extrabold flex items-center gap-2">
                <i data-lucide="clock-3" class="w-5 h-5"></i> Order Terbaru
            </div>
            <a href="<?= site_url('admin/orders') ?>"
                class="text-sm px-3 py-2 rounded-xl border hover:bg-gray-50 inline-flex items-center gap-2">
                <i data-lucide="list" class="w-4 h-4"></i> Lihat semua
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="text-left p-3">Invoice</th>
                        <th class="text-left p-3">Customer</th>
                        <th class="text-left p-3">Total</th>
                        <th class="text-left p-3">Status</th>
                        <th class="text-left p-3"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($latestOrders)): ?>
                        <tr>
                            <td class="p-4 text-gray-600" colspan="5">Belum ada order.</td>
                        </tr>
                    <?php else: foreach ($latestOrders as $o): ?>
                        <?php $b = badgeStatus((string)($o['status'] ?? '')); ?>
                        <tr class="border-t hover:bg-gray-50/70">
                            <td class="p-3 font-semibold">
                                <?= esc($o['invoice'] ?? '-') ?>
                            </td>
                            <td class="p-3">
                                <div class="font-medium"><?= esc($o['customer_name'] ?? '-') ?></div>
                                <div class="text-xs text-gray-500"><?= esc($o['customer_phone'] ?? '') ?></div>
                            </td>
                            <td class="p-3 font-extrabold">
                                Rp<?= number_format((int)($o['total'] ?? 0), 0, ',', '.') ?>
                            </td>
                            <td class="p-3">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-xs border <?= $b['bg'] ?> <?= $b['text'] ?> <?= $b['border'] ?>">
                                    <?= esc($b['label']) ?>
                                </span>
                            </td>
                            <td class="p-3">
                                <a href="<?= site_url('admin/orders/' . $o['id']) ?>"
                                    class="px-3 py-2 rounded-xl border bg-white hover:bg-gray-50 text-xs inline-flex items-center gap-2">
                                    <i data-lucide="eye" class="w-4 h-4"></i> Detail
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Promo & Menu -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

    <!-- Promo -->
    <div class="rounded-2xl border bg-white p-4">
        <div class="flex items-center justify-between">
            <div class="font-extrabold flex items-center gap-2">
                <i data-lucide="ticket" class="w-5 h-5"></i> Promo Aktif
            </div>
            <a href="<?= site_url('admin/promo') ?>"
                class="text-sm px-3 py-2 rounded-xl border hover:bg-gray-50 inline-flex items-center gap-2">
                <i data-lucide="settings-2" class="w-4 h-4"></i> Kelola
            </a>
        </div>

        <div class="mt-4 space-y-2">
            <?php if (empty($activePromos)): ?>
                <div class="rounded-2xl border bg-gray-50 p-4 text-sm text-gray-600">
                    Belum ada promo aktif.
                </div>
            <?php else: foreach ($activePromos as $p): ?>
                <div class="flex items-center justify-between border rounded-2xl p-4 hover:bg-gray-50/70">
                    <div>
                        <div class="font-extrabold"><?= esc($p['code']) ?></div>
                        <div class="text-xs text-gray-500 mt-0.5">
                            <?= esc($p['type']) ?> • nilai <?= (int)($p['value'] ?? 0) ?> • min Rp<?= number_format((int)($p['min_subtotal'] ?? 0),0,',','.') ?>
                        </div>
                    </div>
                    <span class="text-xs px-2.5 py-1 rounded-xl border bg-amber-50 text-amber-800 border-amber-200">
                        used <?= (int)($p['used_count'] ?? 0) ?>
                    </span>
                </div>
            <?php endforeach; endif; ?>
        </div>
    </div>

    <!-- Menu -->
    <div class="rounded-2xl border bg-white p-4">
        <div class="flex items-center justify-between">
            <div class="font-extrabold flex items-center gap-2">
                <i data-lucide="utensils" class="w-5 h-5"></i> Menu Aktif
            </div>
            <a href="<?= site_url('admin/menus') ?>"
                class="text-sm px-3 py-2 rounded-xl border hover:bg-gray-50 inline-flex items-center gap-2">
                <i data-lucide="plus" class="w-4 h-4"></i> Tambah / Kelola
            </a>
        </div>

        <div class="mt-4 space-y-2">
            <?php if (empty($activeMenus)): ?>
                <div class="rounded-2xl border bg-gray-50 p-4 text-sm text-gray-600">
                    Belum ada menu aktif.
                </div>
            <?php else: foreach ($activeMenus as $m): ?>
                <div class="flex items-center justify-between border rounded-2xl p-4 hover:bg-gray-50/70">
                    <div class="min-w-0">
                        <div class="font-extrabold truncate"><?= esc($m['name'] ?? '-') ?></div>
                        <div class="text-xs text-gray-500 mt-0.5">
                            Rp<?= number_format((int)($m['price'] ?? 0), 0, ',', '.') ?>
                        </div>
                    </div>
                    <span class="text-xs px-2.5 py-1 rounded-xl border bg-emerald-50 text-emerald-800 border-emerald-200">
                        aktif
                    </span>
                </div>
            <?php endforeach; endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
