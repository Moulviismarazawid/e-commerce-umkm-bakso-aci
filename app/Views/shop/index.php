<?= $this->extend('layouts/shop') ?>

<?= $this->section('hero') ?>
<?php if (!empty($banners)): ?>
    <div class="w-full">
        <?php foreach ($banners as $b): ?>
            <div class="relative w-full overflow-hidden border-b bg-black">
                <?php if (!empty($b['image'])): ?>
                    <img src="<?= base_url($b['image']) ?>"
                        class="w-full h-[220px] sm:h-[320px] md:h-[420px] object-cover opacity-90">
                <?php else: ?>
                    <div class="w-full h-[220px] sm:h-[320px] md:h-[420px] bg-gray-900"></div>
                <?php endif; ?>

                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/25 to-transparent"></div>

                <div class="absolute inset-0 flex items-end">
                    <div class="w-full">
                        <div class="max-w-5xl mx-auto px-4 pb-6 sm:pb-10">
                            <div class="max-w-2xl">
                                <h1 class="text-white text-2xl sm:text-3xl md:text-4xl font-extrabold leading-tight">
                                    <?= esc($b['title'] ?? 'Bakso Mukbang Kemiling') ?>
                                </h1>

                                <?php if (!empty($b['subtitle'])): ?>
                                    <p class="text-white/90 mt-2 text-sm sm:text-base leading-relaxed">
                                        <?= esc($b['subtitle']) ?>
                                    </p>
                                <?php endif; ?>

                                <?php if (!empty($b['store_address'])): ?>
                                    <div class="mt-3 w-full sm:w-auto">
                                        <div class="inline-flex w-full sm:max-w-lg items-start gap-2 text-white/90 text-sm
                                            bg-black/30 border border-white/15 rounded-xl px-3 py-2">
                                            <i data-lucide="map-pin" class="w-4 h-4 mt-0.5 shrink-0"></i>
                                            <div class="min-w-0">
                                                <div class="font-semibold text-white">Alamat Toko</div>
                                                <div class="break-words">
                                                    <?= esc($b['store_address']) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php
                                $ctaUrl = $b['cta_url'] ?? '';
                                $ctaLabel = $b['cta_label'] ?? '';
                                $adminWa = preg_replace('/\D+/', '', getenv('ADMIN_WA_NUMBER') ?: '');

                                if ($ctaUrl === '' && $adminWa !== '') {
                                    $ctaUrl = "https://wa.me/{$adminWa}";
                                    if ($ctaLabel === '')
                                        $ctaLabel = "Chat WhatsApp";
                                }

                                $shopee = $settings['contact_shopee'] ?? '';
                                $tiktok = $settings['contact_tiktok'] ?? '';
                                ?>

                                <div class="mt-4 flex flex-wrap items-center gap-2">
                                    <?php if (!empty($ctaUrl)): ?>
                                        <a href="<?= esc($ctaUrl) ?>" target="_blank" rel="noopener"
                                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white text-black font-semibold text-sm hover:opacity-90">
                                            <i data-lucide="message-circle" class="w-4 h-4"></i>
                                            <?= esc($ctaLabel ?: 'Lihat') ?>
                                        </a>
                                    <?php endif; ?>

                                    <?php if ($shopee): ?>
                                        <a href="<?= esc($shopee) ?>" target="_blank" rel="noopener"
                                            class="inline-flex items-center gap-2 px-3 py-2 rounded-xl bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold shadow">
                                            <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                                            Shopee
                                        </a>
                                    <?php endif; ?>

                                    <?php if ($tiktok): ?>
                                        <a href="<?= esc($tiktok) ?>" target="_blank" rel="noopener"
                                            class="inline-flex items-center gap-2 px-3 py-2 rounded-xl bg-black hover:bg-gray-900 text-white text-sm font-semibold shadow">
                                            <i data-lucide="play" class="w-4 h-4"></i>
                                            TikTok
                                        </a>
                                    <?php endif; ?>
                                </div>

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

<h1 class="text-xl font-bold mb-4 text-center">Menu Bakso Mukbang Kemiling</h1>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    <?php foreach ($menus as $m): ?>
        <?php $detailUrl = site_url('menu/' . (int) $m['id']); ?>

        <div class="relative bg-white border rounded-xl overflow-hidden hover:shadow-lg transition">

            <!-- ✅ Link overlay (AKAN KENA KLIK) -->
            <a href="<?= $detailUrl ?>" class="absolute inset-0 z-10" aria-label="Lihat detail menu"></a>

            <!-- ✅ Semua konten dibuat tembus klik -->
            <div class="p-4 flex flex-col h-full pointer-events-none">

                <?php if (!empty($m['image'])): ?>
                    <img src="<?= base_url($m['image']) ?>" alt="<?= esc($m['name']) ?>"
                        class="w-full h-40 object-cover rounded-lg border mb-3">
                <?php else: ?>
                    <div class="w-full h-40 rounded-lg border bg-gray-100 mb-3"></div>
                <?php endif; ?>

                <div class="font-semibold text-lg">
                    <?= esc($m['name']) ?>
                </div>

                <div class="text-sm text-gray-600 mt-1 line-clamp-2">
                    <?= esc($m['description'] ?? '') ?>
                </div>

                <div class="mt-3 font-bold">
                    Rp<?= number_format((int) $m['price'], 0, ',', '.') ?>
                </div>

                <!-- ACTIONS -->
                <div class="mt-auto pt-3 flex items-center justify-between gap-3">

                    <!-- ✅ Form harus bisa diklik -->
                    <form method="post" action="<?= site_url('cart/add') ?>"
                        class="flex items-center gap-2 pointer-events-auto relative z-20">
                        <?= csrf_field() ?>
                        <input type="hidden" name="menu_id" value="<?= (int) $m['id'] ?>">
                        <input type="number" name="qty" value="1" min="1" class="w-16 border rounded-lg p-2">
                        <button type="submit" class="px-3 py-2 rounded-lg bg-black text-white text-sm">
                            Tambah
                        </button>
                    </form>

                    <!-- ✅ Link eksternal harus bisa diklik -->
                    <div class="flex gap-2 pointer-events-auto relative z-20">
                        <?php if (!empty($m['shopee_link'])): ?>
                            <a href="<?= esc($m['shopee_link']) ?>" target="_blank" rel="noopener"
                                class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-orange-500 hover:bg-orange-600 text-white"
                                title="Beli di Shopee">
                                <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($m['tiktok_link'])): ?>
                            <a href="<?= esc($m['tiktok_link']) ?>" target="_blank" rel="noopener"
                                class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-black hover:bg-gray-900 text-white"
                                title="Lihat di TikTok">
                                <i data-lucide="play" class="w-5 h-5"></i>
                            </a>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>


<?= $this->endSection() ?>