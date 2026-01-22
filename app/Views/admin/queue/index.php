<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-4">
    <h1 class="text-xl font-bold">Antrian</h1>

    <form method="get" class="flex items-center gap-2">
        <input type="date" name="date" value="<?= esc($date) ?>" class="border rounded-lg p-2">
        <button class="px-3 py-2 rounded-lg bg-black text-white text-sm">Tampilkan</button>
    </form>
</div>

<div class="bg-white border rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left p-3">No</th>
                <th class="text-left p-3">Invoice</th>
                <th class="text-left p-3">Customer</th>
                <th class="text-left p-3">Total</th>
                <th class="text-left p-3">Status Antrian</th>
                <th class="text-left p-3">Status Order</th>
                <th class="text-left p-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($rows)): ?>
                <tr>
                    <td class="p-3 text-gray-600" colspan="7">Belum ada antrian untuk tanggal ini.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($rows as $r): ?>
                    <tr class="border-t">
                        <td class="p-3 font-bold text-lg">
                            <?= (int) $r['queue_number'] ?>
                        </td>
                        <td class="p-3 font-semibold">
                            <?= esc($r['invoice'] ?? '-') ?>
                        </td>
                        <td class="p-3">
                            <div class="font-medium">
                                <?= esc($r['customer_name'] ?? '-') ?>
                            </div>
                            <div class="text-xs text-gray-500">
                                <?= esc($r['customer_phone'] ?? '') ?>
                            </div>
                        </td>
                        <td class="p-3 font-bold">Rp
                            <?= number_format((int) ($r['total'] ?? 0), 0, ',', '.') ?>
                        </td>

                        <td class="p-3">
                            <span class="px-2 py-1 rounded-lg text-xs border bg-white">
                                <?= esc($r['status'] ?? '-') ?>
                            </span>
                        </td>

                        <td class="p-3">
                            <span class="px-2 py-1 rounded-lg text-xs border bg-white">
                                <?= esc($r['order_status'] ?? '-') ?>
                            </span>
                        </td>

                        <td class="p-3">
                            <form method="post" action="<?= site_url('admin/queue/' . $r['id'] . '/status') ?>" class="flex gap-2">
                                <?= csrf_field() ?>
                                <select name="status" class="border rounded-lg p-2">
                                    <?php foreach (['waiting', 'cooking', 'done', 'cancelled'] as $st): ?>
                                        <option value="<?= esc($st) ?>" <?= (($r['status'] ?? '') === $st) ? 'selected' : '' ?>>
                                            <?= esc($st) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <button class="px-3 py-2 rounded-lg bg-black text-white text-sm">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>