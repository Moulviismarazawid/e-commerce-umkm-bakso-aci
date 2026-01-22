<?= $this->extend('layouts/shop') ?>
<?= $this->section('content') ?>

<div class="bg-white rounded-xl border p-4">
    <div class="flex items-start justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold">Invoice
                <?= esc($order['invoice']) ?>
            </h1>
            <p class="text-sm text-gray-600">Status:
                <?= esc($order['status']) ?>
            </p>
            <p class="text-sm text-gray-600">Nomor antrian: <b>
                    <?= esc($queue['queue_number'] ?? '-') ?>
                </b></p>
        </div>

        <a href="/order/<?= esc($order['invoice']) ?>/wa"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-green-600 text-white">
            <i data-lucide="message-circle" class="w-4 h-4"></i>
            Konfirmasi via WhatsApp
        </a>
    </div>

    <div class="mt-4 border-t pt-4">
        <h2 class="font-semibold mb-2">Detail Pesanan</h2>
        <div class="space-y-2">
            <?php foreach ($items as $it): ?>
                <div class="flex justify-between text-sm">
                    <div>
                        <?= esc($it['menu_name']) ?> x
                        <?= esc($it['qty']) ?>
                    </div>
                    <div>Rp
                        <?= number_format((int) $it['line_total'], 0, ',', '.') ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="mt-4 border-t pt-3 text-sm space-y-1">
            <div class="flex justify-between"><span>Subtotal</span><span>Rp
                    <?= number_format((int) $order['subtotal'], 0, ',', '.') ?>
                </span></div>
            <div class="flex justify-between"><span>Diskon</span><span>- Rp
                    <?= number_format((int) $order['discount'], 0, ',', '.') ?>
                </span></div>
            <div class="flex justify-between font-bold"><span>Total</span><span>Rp
                    <?= number_format((int) $order['total'], 0, ',', '.') ?>
                </span></div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>