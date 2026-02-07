<?= $this->extend('layouts/shop') ?>

<?= $this->section('content') ?>
<?php
// Variabel yang diharapkan dari controller:
// $menu (array) => data produk
// $related (array) => produk terkait (opsional)
// $settings (array) => setting kontak (opsional)

$menuName = $menu['name'] ?? '—';
$price = (int) ($menu['price'] ?? 0);
$desc = $menu['description'] ?? '';
$image = $menu['image'] ?? '';
$shopee = $menu['shopee_link'] ?? '';
$tiktok = $menu['tiktok_link'] ?? '';

$adminWa = preg_replace('/\D+/', '', getenv('ADMIN_WA_NUMBER') ?: '');
$waText = "Halo, saya mau pesan: {$menuName}";
$waUrl = $adminWa ? "https://wa.me/{$adminWa}?text=" . urlencode($waText) : '';
?>

<div class="max-w-6xl mx-auto px-4 py-6">

    <!-- Breadcrumb -->
    <nav class="text-sm text-slate-500 mb-4">
        <ol class="flex items-center gap-2 flex-wrap">
            <li>
                <a href="<?= site_url('/') ?>" class="hover:text-slate-700">Beranda</a>
            </li>
            <li class="text-slate-400">/</li>
            <li class="text-slate-700 font-medium"><?= esc($menuName) ?></li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Left: Image -->
        <div class="bg-white border rounded-2xl overflow-hidden">
            <?php if (!empty($image)): ?>
                <img src="<?= base_url($image) ?>" alt="<?= esc($menuName) ?>"
                    class="w-full h-[280px] sm:h-[360px] lg:h-[460px] object-cover">
            <?php else: ?>
                <div class="w-full h-[280px] sm:h-[360px] lg:h-[460px] bg-slate-100"></div>
            <?php endif; ?>
        </div>

        <!-- Right: Info -->
        <div class="bg-white border rounded-2xl p-5 sm:p-6 flex flex-col">

            <!-- Header -->
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 leading-tight">
                        <?= esc($menuName) ?>
                    </h1>
                    <div class="mt-2 text-xl font-bold text-slate-900">
                        Rp<?= number_format($price, 0, ',', '.') ?>
                    </div>
                </div>

                <!-- Shop links -->
                <div class="flex gap-2">
                    <?php if (!empty($shopee)): ?>
                        <a href="<?= esc($shopee) ?>" target="_blank" rel="noopener"
                            class="inline-flex items-center justify-center w-11 h-11 rounded-2xl bg-orange-500 hover:bg-orange-600 text-white"
                            title="Beli di Shopee">
                            <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($tiktok)): ?>
                        <a href="<?= esc($tiktok) ?>" target="_blank" rel="noopener"
                            class="inline-flex items-center justify-center w-11 h-11 rounded-2xl bg-black hover:bg-slate-900 text-white"
                            title="Lihat di TikTok">
                            <i data-lucide="play" class="w-5 h-5"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Description -->
            <?php if (!empty($desc)): ?>
                <div class="mt-4 text-slate-600 leading-relaxed">
                    <?= esc($desc) ?>
                </div>
            <?php else: ?>
                <div class="mt-4 text-slate-500 italic">
                    Deskripsi belum tersedia.
                </div>
            <?php endif; ?>

            <!-- Info box -->
            <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="border rounded-xl p-4">
                    <div class="text-xs text-slate-500">Estimasi</div>
                    <div class="font-semibold text-slate-900 mt-1">Siap saji cepat</div>
                </div>
                <div class="border rounded-xl p-4">
                    <div class="text-xs text-slate-500">Catatan</div>
                    <div class="font-semibold text-slate-900 mt-1">Bisa request level pedas</div>
                </div>
            </div>

            <!-- Back link -->
            <div class="mt-5">
                <a href="<?= site_url('/') ?>"
                    class="text-sm text-slate-600 hover:text-slate-900 inline-flex items-center gap-2">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Kembali ke menu
                </a>
            </div>

            <!-- ✅ Actions (paling bawah) -->
            <div class="mt-auto pt-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

                    <!-- Add to cart -->
                    <form method="post" action="<?= site_url('cart/add') ?>"
                        class="grid grid-cols-[90px_1fr] gap-2 items-stretch min-w-0">
                        <?= csrf_field() ?>
                        <input type="hidden" name="menu_id" value="<?= (int) ($menu['id'] ?? 0) ?>">

                        <input type="number" name="qty" value="1" min="1"
                            class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-black/20">

                        <button type="submit"
                            class="w-full min-w-0 inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-black text-white font-semibold hover:opacity-90">
                            <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                            <span class="truncate">Tambah ke Keranjang</span>
                        </button>
                    </form>

                    <!-- WhatsApp -->
                    <?php if (!empty($waUrl)): ?>
                        <a href="<?= esc($waUrl) ?>" target="_blank" rel="noopener"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl border font-semibold hover:bg-slate-50 min-w-0">
                            <i data-lucide="message-circle" class="w-5 h-5"></i>
                            <span class="truncate">Pesan via WhatsApp</span>
                        </a>
                    <?php else: ?>
                        <div
                            class="w-full px-4 py-3 rounded-xl border text-slate-500 text-sm flex items-center justify-center">
                            ADMIN_WA_NUMBER belum diatur
                        </div>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>

    <!-- Related -->
    <?php if (!empty($related) && is_array($related)): ?>
        <div class="mt-10">
            <div class="flex items-center justify-between gap-3 mb-4">
                <h2 class="text-lg font-bold text-slate-900">Menu lainnya</h2>
                <a href="<?= site_url('/') ?>" class="text-sm text-slate-600 hover:text-slate-900">Lihat semua</a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <?php foreach ($related as $r): ?>
                    <a href="<?= site_url('menu/' . (int) $r['id']) ?>"
                        class="bg-white border rounded-2xl overflow-hidden hover:shadow-md transition">
                        <?php if (!empty($r['image'])): ?>
                            <img src="<?= base_url($r['image']) ?>" class="w-full h-32 object-cover">
                        <?php else: ?>
                            <div class="w-full h-32 bg-slate-100"></div>
                        <?php endif; ?>
                        <div class="p-3">
                            <div class="font-semibold text-slate-900 line-clamp-1">
                                <?= esc($r['name'] ?? '-') ?>
                            </div>
                            <div class="mt-1 text-sm font-bold">
                                Rp<?= number_format((int) ($r['price'] ?? 0), 0, ',', '.') ?>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

</div>
<?= $this->endSection() ?>