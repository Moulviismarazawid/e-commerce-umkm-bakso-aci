<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-4">
    <h1 class="text-xl font-bold">Manajemen Order</h1>
</div>

<form method="get" class="bg-white border rounded-xl p-4 mb-4 flex flex-col sm:flex-row gap-2">
    <input name="q" value="<?= esc($q ?? '') ?>" placeholder="Cari invoice / nama / WA..."
        class="w-full border rounded-lg p-2">

    <select name="status" class="w-full sm:w-56 border rounded-lg p-2">
        <option value="">Semua Status</option>
        <?php
        $opts = ['pending', 'awaiting_payment', 'paid', 'processing', 'done', 'cancelled'];
        foreach ($opts as $opt):
            ?>
            <option value="<?= esc($opt) ?>" <?= (($status ?? '') === $opt) ? 'selected' : '' ?>>
                <?= esc($opt) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button class="px-4 py-2 rounded-lg bg-black text-white">Filter</button>
</form>

<div class="bg-white border rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left p-3">Invoice</th>
                <th class="text-left p-3">Customer</th>
                <th class="text-left p-3">Total</th>
                <th class="text-left p-3">Status</th>
                <th class="text-left p-3">Tanggal</th>
                <th class="text-left p-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($orders)): ?>
                <tr>
                    <td class="p-3 text-gray-600" colspan="6">Belum ada order.</td>
                </tr>
            <?php else:
                foreach ($orders as $o): ?>
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
                        <td class="p-3 font-bold">Rp
                            <?= number_format((int) ($o['total'] ?? 0), 0, ',', '.') ?>
                        </td>
                        <td class="p-3">
                            <span class="px-2 py-1 rounded-lg text-xs border bg-white">
                                <?= esc($o['status'] ?? '-') ?>
                            </span>
                        </td>
                        <td class="p-3 text-gray-600 text-xs">
                            <?= esc($o['created_at'] ?? '-') ?>
                        </td>
                        <td class="p-3">
                            <a href="<?= site_url('admin/orders/' . $o['id']) ?>" class="px-3 py-2 rounded-lg border text-sm">
                                Detail
                            </a>
                        </td>
                    </tr>
                <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>