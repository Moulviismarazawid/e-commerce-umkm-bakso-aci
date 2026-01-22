<?= $this->extend('layouts/shop') ?>

<?= $this->extend('layouts/shop') ?>

<?= $this->section('hero') ?>
<?php if (!empty($banners)): ?>
    <div class="w-full">
        <?php foreach ($banners as $b): ?>
            <div class="relative w-full overflow-hidden border-b bg-black">
                <?php if (!empty($b['image'])): ?>
                    <img src="<?= base_url($b['image']) ?>"
                        class="w-full h-[240px] sm:h-[320px] md:h-[420px] object-cover opacity-90">
                <?php else: ?>
                    <div class="w-full h-[240px] sm:h-[320px] md:h-[420px] bg-gray-900"></div>
                <?php endif; ?>

                <!-- overlay gradient -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/25 to-transparent"></div>

                <!-- content -->
                <div class="absolute inset-0 flex items-end">
                    <div class="w-full">
                        <div class="max-w-5xl mx-auto px-4 pb-6 sm:pb-10">
                            <div class="max-w-2xl">
                                <div class="text-white text-2xl sm:text-3xl md:text-4xl font-extrabold leading-tight">
                                    <?= esc($b['title'] ?? 'Bakso Aci') ?>
                                </div>

                                <?php if (!empty($b['subtitle'])): ?>
                                    <div class="text-white/90 mt-2 text-sm sm:text-base">
                                        <?= esc($b['subtitle']) ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($b['store_address'])): ?>
                                    <div
                                        class="mt-3 inline-flex items-start gap-2 text-white/90 text-sm bg-black/30 border border-white/15 rounded-xl px-3 py-2">
                                        <i data-lucide="map-pin" class="w-4 h-4 mt-0.5"></i>
                                        <div>
                                            <div class="font-semibold text-white">Alamat Toko</div>
                                            <div>
                                                <?= esc($b['store_address']) ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php
                                $ctaUrl = $b['cta_url'] ?? '';
                                $ctaLabel = $b['cta_label'] ?? '';
                                // fallback: kalau cta kosong, arahkan ke WA admin dari env
                                $adminWa = preg_replace('/\D+/', '', getenv('ADMIN_WA_NUMBER') ?: '');
                                if ($ctaUrl === '' && $adminWa !== '') {
                                    $ctaUrl = "https://wa.me/{$adminWa}";
                                    if ($ctaLabel === '')
                                        $ctaLabel = "Chat WhatsApp";
                                }
                                ?>

                                <?php if (!empty($ctaUrl)): ?>
                                    <div class="mt-4">
                                        <a href="<?= esc($ctaUrl) ?>" target="_blank"
                                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white text-black font-semibold text-sm hover:opacity-90">
                                            <i data-lucide="message-circle" class="w-4 h-4"></i>
                                            <?= esc($ctaLabel ?: 'Lihat') ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>


<h1 class="text-xl font-bold mb-4 text-center">Menu Bakso Aci</h1>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    <?php foreach ($menus as $m): ?>
        <div class="bg-white border rounded-xl p-4">

            <?php if (!empty($m['image'])): ?>
                <img src="<?= base_url($m['image']) ?>" class="w-full h-40 object-cover rounded-lg border mb-3">
            <?php else: ?>
                <div class="w-full h-40 rounded-lg border bg-gray-100 mb-3"></div>
            <?php endif; ?>

            <div class="font-semibold"><?= esc($m['name']) ?></div>
            <div class="text-sm text-gray-600 mt-1"><?= esc($m['description'] ?? '') ?></div>
            <div class="mt-3 font-bold">Rp<?= number_format((int) $m['price'], 0, ',', '.') ?></div>

            <form method="post" action="<?= site_url('cart/add') ?>" class="mt-3 flex gap-2 items-center">
                <?= csrf_field() ?>
                <input type="hidden" name="menu_id" value="<?= (int) $m['id'] ?>">
                <input type="number" name="qty" value="1" min="1" class="w-20 border rounded-lg p-2">
                <button class="px-3 py-2 rounded-lg bg-black text-white text-sm">Tambah</button>
            </form>

        </div>
    <?php endforeach; ?>
</div>

<?= $this->endSection() ?>