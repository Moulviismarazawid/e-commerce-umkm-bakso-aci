<?= $this->extend('layouts/shop') ?>
<?= $this->section('content') ?>

<div class="flex items-start justify-between gap-3 mb-4">
    <div>
        <h1 class="text-xl font-bold">Invoice</h1>
        <div class="text-sm text-gray-600">
            <?= esc($order['invoice']) ?>
        </div>
    </div>

    <a href="<?= site_url('order/' . $order['invoice'] . '/wa') ?>"
        class="px-4 py-2 rounded-xl bg-green-600 text-white hover:opacity-90">
        Konfirmasi via WhatsApp
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-5 gap-4">
    <div class="lg:col-span-3 bg-white border rounded-xl p-5">
        <h2 class="font-semibold mb-3">Detail Pesanan</h2>

        <div class="text-sm space-y-1">
            <div><span class="text-gray-500">Nama:</span> <b>
                    <?= esc($order['customer_name']) ?>
                </b></div>
            <div><span class="text-gray-500">WhatsApp:</span>
                <?= esc($order['customer_phone']) ?>
            </div>
            <?php if (!empty($order['customer_address'])): ?>
                <div><span class="text-gray-500">Alamat:</span>
                    <?= esc($order['customer_address']) ?>
                </div>
            <?php endif; ?>
            <div><span class="text-gray-500">Status:</span> <b>
                    <?= esc($order['status']) ?>
                </b></div>
        </div>

        <?php if (!empty($order['notes'])): ?>
            <div class="mt-3 p-3 rounded-lg bg-gray-50 border text-sm">
                <div class="font-medium mb-1">Catatan</div>
                <div class="text-gray-700">
                    <?= esc($order['notes']) ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="mt-4">
            <h3 class="font-semibold mb-2">Item</h3>
            <div class="space-y-3">
                <?php foreach ($items as $it): ?>
                    <div class="flex items-start justify-between gap-3 border rounded-xl p-3">
                        <div>
                            <div class="font-medium">
                                <?= esc($it['menu_name']) ?>
                            </div>
                            <div class="text-xs text-gray-500">
                                <?= (int) $it['qty'] ?> x Rp
                                <?= number_format((int) $it['price'], 0, ',', '.') ?>
                            </div>
                        </div>
                        <div class="font-bold">
                            Rp
                            <?= number_format((int) $it['line_total'], 0, ',', '.') ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="lg:col-span-2 space-y-4">
        <div class="bg-white border rounded-xl p-5">
            <h2 class="font-semibold mb-3">Pembayaran</h2>

            <div class="flex items-center justify-between text-sm">
                <div class="text-gray-600">Subtotal</div>
                <div class="font-semibold">Rp
                    <?= number_format((int) $order['subtotal'], 0, ',', '.') ?>
                </div>
            </div>

            <div class="flex items-center justify-between text-sm mt-2">
                <div class="text-gray-600">Diskon</div>
                <div class="font-semibold">Rp
                    <?= number_format((int) $order['discount'], 0, ',', '.') ?>
                </div>
            </div>

            <div class="border-t mt-3 pt-3 flex items-center justify-between">
                <div class="text-gray-600">Total</div>
                <div class="text-2xl font-extrabold">Rp
                    <?= number_format((int) $order['total'], 0, ',', '.') ?>
                </div>
            </div>

            <a href="<?= site_url('order/' . $order['invoice'] . '/wa') ?>"
                class="mt-4 block text-center px-4 py-3 rounded-xl bg-green-600 text-white hover:opacity-90">
                Konfirmasi Pembayaran via WhatsApp
            </a>

            <p class="text-xs text-gray-500 mt-3">
                Klik tombol WhatsApp untuk mengirim pesan konfirmasi ke admin beserta nomor invoice.
            </p>
        </div>

        <a href="<?= site_url('/') ?>" class="block text-center px-4 py-3 rounded-xl border bg-white hover:bg-gray-50">
            Kembali ke Menu
        </a>
    </div>
</div>

<?= $this->endSection() ?>