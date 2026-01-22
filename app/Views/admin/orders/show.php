<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="flex items-start justify-between gap-3 mb-4">
    <div>
        <h1 class="text-xl font-bold">Detail Order</h1>
        <div class="text-sm text-gray-600">
            <?= esc($order['invoice'] ?? '') ?>
        </div>
    </div>
    <a href="<?= site_url('admin/orders') ?>" class="px-3 py-2 rounded-lg border text-sm">Kembali</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-5 gap-4">

    <div class="lg:col-span-3 bg-white border rounded-xl p-5">
        <h2 class="font-semibold mb-3">Item Pesanan</h2>

        <?php if (empty($items)): ?>
            <div class="text-gray-600 text-sm">Tidak ada item.</div>
        <?php else: ?>
            <div class="space-y-3">
                <?php foreach ($items as $it): ?>
                    <div class="border rounded-xl p-3 flex items-start justify-between">
                        <div>
                            <div class="font-medium">
                                <?= esc($it['menu_name'] ?? '-') ?>
                            </div>
                            <div class="text-xs text-gray-500">
                                <?= (int) ($it['qty'] ?? 0) ?> x Rp
                                <?= number_format((int) ($it['price'] ?? 0), 0, ',', '.') ?>
                            </div>
                        </div>
                        <div class="font-bold">
                            Rp
                            <?= number_format((int) ($it['line_total'] ?? 0), 0, ',', '.') ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="lg:col-span-2 space-y-4">
        <div class="bg-white border rounded-xl p-5">
            <h2 class="font-semibold mb-3">Info Order</h2>

            <div class="text-sm space-y-1">
                <div><span class="text-gray-500">Nama:</span> <b>
                        <?= esc($order['customer_name'] ?? '-') ?>
                    </b></div>
                <div><span class="text-gray-500">WA:</span>
                    <?= esc($order['customer_phone'] ?? '-') ?>
                </div>
                <?php if (!empty($order['customer_address'])): ?>
                    <div><span class="text-gray-500">Alamat:</span>
                        <?= esc($order['customer_address']) ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($order['notes'])): ?>
                    <div><span class="text-gray-500">Catatan:</span>
                        <?= esc($order['notes']) ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="border-t mt-3 pt-3 text-sm space-y-2">
                <div class="flex justify-between"><span class="text-gray-600">Subtotal</span><b>Rp
                        <?= number_format((int) ($order['subtotal'] ?? 0), 0, ',', '.') ?>
                    </b></div>
                <div class="flex justify-between"><span class="text-gray-600">Diskon</span><b>Rp
                        <?= number_format((int) ($order['discount'] ?? 0), 0, ',', '.') ?>
                    </b></div>
                <div class="flex justify-between text-lg"><span class="text-gray-900">Total</span><b>Rp
                        <?= number_format((int) ($order['total'] ?? 0), 0, ',', '.') ?>
                    </b></div>
            </div>

            <?php if (!empty($queue)): ?>
                <div class="mt-3 p-3 rounded-xl border bg-gray-50 text-sm">
                    <div class="font-semibold mb-1">Antrian</div>
                    <div>No: <b>
                            <?= (int) ($queue['queue_number'] ?? 0) ?>
                        </b> (
                        <?= esc($queue['queue_date'] ?? '') ?>)
                    </div>
                    <div>Status: <b>
                            <?= esc($queue['status'] ?? '-') ?>
                        </b></div>
                </div>
            <?php endif; ?>
        </div>

        <div class="bg-white border rounded-xl p-5">
            <h2 class="font-semibold mb-3">Update Status</h2>

            <form method="post" action="<?= site_url('admin/orders/' . $order['id'] . '/status') ?>" class="flex gap-2">
                <?= csrf_field() ?>

                <select name="status" class="w-full border rounded-lg p-2">
                    <?php foreach (['pending', 'awaiting_payment', 'paid', 'processing', 'done', 'cancelled'] as $st): ?>
                        <option value="<?= esc($st) ?>" <?= (($order['status'] ?? '') === $st) ? 'selected' : '' ?>>
                            <?= esc($st) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button class="px-4 py-2 rounded-lg bg-black text-white">Simpan</button>
            </form>

            <div class="text-xs text-gray-500 mt-2">
                Jika status diubah ke <b>paid</b>, sistem akan mencatat pemasukan ke cash_ledger (jika tabel tersedia).
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>