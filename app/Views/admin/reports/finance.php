<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="flex items-start justify-between gap-3 mb-4">
    <div>
        <h1 class="text-xl font-bold">Laporan Keuangan</h1>
        <div class="text-sm text-gray-600">Omzet • Diskon • Jumlah Transaksi</div>
    </div>
</div>

<form method="get" class="bg-white border rounded-xl p-4 mb-4 space-y-3">
    <div class="flex flex-col sm:flex-row gap-2 sm:items-end">
        <div>
            <label class="text-sm text-gray-600">Mode</label>
            <select name="mode" class="border rounded-lg p-2 w-full sm:w-44">
                <option value="daily" <?= ($mode === 'daily') ? 'selected' : '' ?>>Harian</option>
                <option value="monthly" <?= ($mode === 'monthly') ? 'selected' : '' ?>>Bulanan</option>
            </select>
        </div>

        <div class="<?= ($mode === 'daily') ? '' : 'hidden' ?>">
            <label class="text-sm text-gray-600">Tanggal</label>
            <input type="date" name="date" value="<?= esc($date ?? '') ?>" class="border rounded-lg p-2">
        </div>

        <div class="<?= ($mode === 'monthly') ? '' : 'hidden' ?>">
            <label class="text-sm text-gray-600">Bulan</label>
            <input type="month" name="month" value="<?= esc($month ?? '') ?>" class="border rounded-lg p-2">
        </div>

        <button class="px-4 py-2 rounded-lg bg-black text-white">Tampilkan</button>
    </div>

    <div class="border-t pt-3">
        <div class="text-sm font-semibold mb-2">Status yang dihitung</div>
        <?php foreach (['paid', 'done', 'processing', 'pending', 'awaiting_payment', 'cancelled'] as $st): ?>
            <label class="inline-flex items-center gap-2 mr-4 mb-2">
                <input type="checkbox" name="status[]" value="<?= esc($st) ?>" <?= in_array($st, $statusList ?? [], true) ? 'checked' : '' ?>>
                <span class="text-sm">
                    <?= esc($st) ?>
                </span>
            </label>
        <?php endforeach; ?>
        <div class="text-xs text-gray-500 mt-1">Default: paid + done</div>
    </div>
</form>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-4">
    <div class="bg-white border rounded-xl p-4">
        <div class="text-sm text-gray-600">Omzet</div>
        <div class="text-2xl font-extrabold">Rp
            <?= number_format((int) ($summary['omzet'] ?? 0), 0, ',', '.') ?>
        </div>
    </div>
    <div class="bg-white border rounded-xl p-4">
        <div class="text-sm text-gray-600">Total Diskon</div>
        <div class="text-2xl font-extrabold">Rp
            <?= number_format((int) ($summary['total_discount'] ?? 0), 0, ',', '.') ?>
        </div>
    </div>
    <div class="bg-white border rounded-xl p-4">
        <div class="text-sm text-gray-600">Jumlah Transaksi</div>
        <div class="text-2xl font-extrabold">
            <?= (int) ($summary['trx_count'] ?? 0) ?>
        </div>
    </div>
</div>

<?php if ($mode === 'daily'): ?>
    <div class="bg-white border rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left p-3">Invoice</th>
                    <th class="text-left p-3">Customer</th>
                    <th class="text-left p-3">Diskon</th>
                    <th class="text-left p-3">Total</th>
                    <th class="text-left p-3">Status</th>
                    <th class="text-left p-3">Waktu</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($rows)): ?>
                    <tr>
                        <td class="p-3 text-gray-600" colspan="6">Tidak ada transaksi.</td>
                    </tr>
                <?php else:
                    foreach ($rows as $o): ?>
                        <tr class="border-t">
                            <td class="p-3 font-semibold">
                                <?= esc($o['invoice'] ?? '-') ?>
                            </td>
                            <td class="p-3">
                                <div class="font-medium">
                                    <?= esc($o['customer_name'] ?? '-') ?>
                                </div>
                                <div class="text-xs text-gray-500">
                                    <?= esc($o['customer_phone'] ?? '') ?>
                                </div>
                            </td>
                            <td class="p-3">Rp
                                <?= number_format((int) ($o['discount'] ?? 0), 0, ',', '.') ?>
                            </td>
                            <td class="p-3 font-bold">Rp
                                <?= number_format((int) ($o['total'] ?? 0), 0, ',', '.') ?>
                            </td>
                            <td class="p-3"><span class="px-2 py-1 rounded-lg border text-xs">
                                    <?= esc($o['status'] ?? '-') ?>
                                </span></td>
                            <td class="p-3 text-xs text-gray-600">
                                <?= esc($o['created_at'] ?? '-') ?>
                            </td>
                        </tr>
                    <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>

<?php else: ?>
    <div class="bg-white border rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left p-3">Tanggal</th>
                    <th class="text-left p-3">Transaksi</th>
                    <th class="text-left p-3">Diskon</th>
                    <th class="text-left p-3">Omzet</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($rows)): ?>
                    <tr>
                        <td class="p-3 text-gray-600" colspan="4">Tidak ada data.</td>
                    </tr>
                <?php else:
                    foreach ($rows as $r): ?>
                        <tr class="border-t">
                            <td class="p-3 font-semibold">
                                <?= esc($r['trx_day'] ?? '-') ?>
                            </td>
                            <td class="p-3">
                                <?= (int) ($r['trx_count'] ?? 0) ?>
                            </td>
                            <td class="p-3">Rp
                                <?= number_format((int) ($r['total_discount'] ?? 0), 0, ',', '.') ?>
                            </td>
                            <td class="p-3 font-bold">Rp
                                <?= number_format((int) ($r['omzet'] ?? 0), 0, ',', '.') ?>
                            </td>
                        </tr>
                    <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>