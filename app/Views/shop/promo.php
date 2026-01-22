<?= $this->extend('layouts/shop') ?>

<?= $this->section('content') ?>
<h1 class="text-2xl font-extrabold mb-6">🔥 Promo Spesial</h1>

<?php if (empty($promos)): ?>
    <div class="bg-white border rounded-2xl p-6 text-gray-600">
        Belum ada promo aktif saat ini.
    </div>
<?php else: ?>
    <div class="grid sm:grid-cols-2 gap-4">
        <?php foreach ($promos as $p): ?>
            <div class="bg-gradient-to-br from-orange-50 to-rose-50 border rounded-2xl p-5">
                <div class="text-lg font-bold text-orange-700">
                    <?= esc($p['code']) ?>
                </div>
                <div class="text-sm text-gray-700 mt-1">
                    <?= esc($p['description'] ?? 'Diskon spesial') ?>
                </div>
                <div class="mt-3 text-sm">
                    <span class="font-semibold">Diskon:</span>
                    Rp
                    <?= number_format($p['discount_amount'] ?? 0, 0, ',', '.') ?>
                </div>
                <div class="mt-3 text-xs text-gray-500">
                    Berlaku sampai
                    <?= esc($p['expired_at'] ?? '-') ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>