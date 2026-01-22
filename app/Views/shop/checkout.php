<?= $this->extend('layouts/shop') ?>
<?= $this->section('content') ?>

<h1 class="text-xl font-bold mb-4">Checkout</h1>

<?php if (empty($cart)): ?>
    <div class="bg-white border rounded-xl p-6 text-gray-600">Keranjang kosong.</div>
<?php else: ?>

    <?php
    $subtotal = 0;
    foreach ($cart as $it) {
        $subtotal += (int) $it['price'] * (int) $it['qty'];
    }
    ?>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-4">
        <!-- Left: Form -->
        <div class="lg:col-span-3 bg-white border rounded-xl p-5">
            <h2 class="font-semibold mb-3">Data Pemesan</h2>

            <form method="post" action="<?= site_url('checkout') ?>" class="space-y-3">
                <?= csrf_field() ?>

                <div>
                    <label class="text-sm text-gray-600">Nama</label>
                    <input name="customer_name" value="<?= esc(old('customer_name') ?? ($customerName ?? '')) ?>"
                        class="w-full border rounded-lg p-2" <?= session()->get('customer_logged_in') ? 'readonly' : '' ?>
                    required>
                </div>

                <div>
                    <label class="text-sm text-gray-600">No WhatsApp</label>
                    <input name="customer_phone" value="<?= esc(old('customer_phone') ?? ($customerPhone ?? '')) ?>"
                        class="w-full border rounded-lg p-2" placeholder="contoh: 62812xxxx"
                        <?= session()->get('customer_logged_in') ? 'readonly' : '' ?>
                    required>
                    <div class="text-xs text-gray-500 mt-1">Gunakan format 62xxxxxxxx.</div>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Alamat (opsional)</label>
                    <textarea name="customer_address" class="w-full border rounded-lg p-2" rows="3"
                        placeholder="Alamat pengantaran jika ada"><?= esc(old('customer_address') ?? '') ?></textarea>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Catatan (opsional)</label>
                    <textarea name="notes" class="w-full border rounded-lg p-2" rows="3"
                        placeholder="Contoh: pedas sedang, tanpa daun bawang"><?= esc(old('notes') ?? '') ?></textarea>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Kode Promo (opsional)</label>
                    <input name="promo_code" value="<?= esc(old('promo_code') ?? '') ?>"
                        class="w-full border rounded-lg p-2" placeholder="Masukkan kode promo">
                </div>

                <button class="w-full mt-2 px-4 py-3 rounded-xl bg-black text-white hover:opacity-90">
                    Buat Invoice & Checkout
                </button>

                <p class="text-xs text-gray-500">
                    Setelah order dibuat, kamu akan diarahkan ke halaman invoice dan bisa konfirmasi pembayaran via
                    WhatsApp.
                </p>
            </form>
        </div>

        <!-- Right: Summary -->
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white border rounded-xl p-5">
                <h2 class="font-semibold mb-3">Ringkasan Pesanan</h2>

                <div class="space-y-3">
                    <?php foreach ($cart as $it): ?>
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <div class="font-medium">
                                    <?= esc($it['name']) ?>
                                </div>
                                <div class="text-xs text-gray-500">
                                    <?= (int) $it['qty'] ?> x Rp
                                    <?= number_format((int) $it['price'], 0, ',', '.') ?>
                                </div>
                            </div>
                            <div class="font-semibold">
                                Rp
                                <?= number_format((int) $it['qty'] * (int) $it['price'], 0, ',', '.') ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="border-t mt-4 pt-4 flex items-center justify-between">
                    <div class="text-sm text-gray-600">Subtotal</div>
                    <div class="font-bold">Rp
                        <?= number_format($subtotal, 0, ',', '.') ?>
                    </div>
                </div>

                <div class="text-xs text-gray-500 mt-2">
                    Diskon promo akan dihitung setelah kamu submit checkout (sesuai validasi promo).
                </div>
            </div>

            <a href="<?= site_url('cart') ?>"
                class="block text-center px-4 py-3 rounded-xl border bg-white hover:bg-gray-50">
                Kembali ke Keranjang
            </a>
        </div>
    </div>

<?php endif; ?>

<?= $this->endSection() ?>