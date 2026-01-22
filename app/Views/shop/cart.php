<?= $this->extend('layouts/shop') ?>
<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-4">
    <h1 class="text-xl font-bold">Keranjang</h1>
    <a href="<?= site_url('/') ?>" class="text-sm px-3 py-2 rounded-lg border bg-white hover:bg-gray-50">
        Belanja lagi
    </a>
</div>

<?php if (empty($cart)): ?>
    <div class="bg-white border rounded-xl p-6 text-gray-600">
        Keranjang kamu masih kosong.
    </div>
<?php else: ?>

    <div class="bg-white border rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left p-3">Menu</th>
                    <th class="text-left p-3 w-40">Qty</th>
                    <th class="text-left p-3">Harga</th>
                    <th class="text-left p-3">Subtotal</th>
                    <th class="text-left p-3 w-28">Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php $grand = 0; ?>
                <?php foreach ($cart as $key => $it): ?>
                    <?php
                    $qty = (int) ($it['qty'] ?? 0);
                    $price = (int) ($it['price'] ?? 0);
                    $sub = $qty * $price;
                    $grand += $sub;
                    $name = $it['name'] ?? 'Item';
                    ?>
                    <tr class="border-t">
                        <td class="p-3">
                            <div class="font-medium">
                                <?= esc($name) ?>
                            </div>
                            <?php if (!empty($it['note'])): ?>
                                <div class="text-xs text-gray-500">
                                    <?= esc($it['note']) ?>
                                </div>
                            <?php endif; ?>
                        </td>

                        <td class="p-3">
                            <form method="post" action="<?= site_url('cart/update') ?>" class="flex items-center gap-2">
                                <?= csrf_field() ?>
                                <input type="hidden" name="key" value="<?= esc($key) ?>">
                                <input type="number" name="qty" value="<?= $qty ?>" min="1" class="w-24 border rounded-lg p-2">
                                <button class="px-3 py-2 rounded-lg bg-black text-white text-xs">
                                    Update
                                </button>
                            </form>
                        </td>

                        <td class="p-3">Rp
                            <?= number_format($price, 0, ',', '.') ?>
                        </td>
                        <td class="p-3 font-semibold">Rp
                            <?= number_format($sub, 0, ',', '.') ?>
                        </td>

                        <td class="p-3">
                            <form method="post" action="<?= site_url('cart/remove') ?>"
                                onsubmit="return confirm('Hapus item ini?')">
                                <?= csrf_field() ?>
                                <input type="hidden" name="key" value="<?= esc($key) ?>">
                                <button class="px-3 py-2 rounded-lg border text-xs hover:bg-gray-50">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4 flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
        <div class="bg-white border rounded-xl p-4">
            <div class="text-sm text-gray-600">Total</div>
            <div class="text-2xl font-extrabold">Rp
                <?= number_format($grand, 0, ',', '.') ?>
            </div>
        </div>

        <a href="<?= site_url('checkout') ?>" class="text-center px-5 py-3 rounded-xl bg-black text-white hover:opacity-90">
            Checkout
        </a>
    </div>

<?php endif; ?>

<?= $this->endSection() ?>