<?= $this->extend('layouts/shop') ?>

<?= $this->section('hero') ?>
<?php if (!empty($banners)): ?>
    <div class="w-full">
        <?php foreach ($banners as $b): ?>
            <div class="relative w-full overflow-hidden border-b bg-black">

                <?php if (!empty($b['image'])): ?>
                    <img src="<?= base_url($b['image']) ?>"
                        class="w-full h-[200px] sm:h-[260px] md:h-[320px] object-cover opacity-90">
                <?php endif; ?>

                <!-- overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>

                <!-- content -->
                <div class="absolute inset-0 flex items-end">
                    <div class="max-w-5xl mx-auto px-4 pb-6 text-white w-full">
                        <h1 class="text-2xl sm:text-3xl font-extrabold">
                            Kontak Kami
                        </h1>
                        <p class="text-white/90 text-sm sm:text-base mt-1">
                            Hubungi kami untuk pemesanan & informasi.
                        </p>

                        <!-- 🔥 LINK MARKETPLACE -->
                        <?php
                        $shopee = $settings['contact_shopee'] ?? '';
                        $tiktok = $settings['contact_tiktok'] ?? '';
                        ?>

                        <?php if ($shopee || $tiktok): ?>
                            <div class="mt-4 flex flex-wrap gap-2">
                                <?php if ($shopee): ?>
                                    <a href="<?= esc($shopee) ?>" target="_blank" rel="noopener" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl
                      bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold shadow">
                                        <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                                        Shopee
                                    </a>
                                <?php endif; ?>

                                <?php if ($tiktok): ?>
                                    <a href="<?= esc($tiktok) ?>" target="_blank" rel="noopener" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl
                      bg-black/80 hover:bg-black text-white text-sm font-semibold shadow">
                                        <i data-lucide="play" class="w-4 h-4"></i>
                                        TikTok
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <!-- /LINK -->
                    </div>
                </div>

            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>