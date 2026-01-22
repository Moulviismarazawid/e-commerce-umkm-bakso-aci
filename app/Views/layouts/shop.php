<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <title><?= esc($title ?? 'Bakso Aci') ?></title>

    <!-- Optional: font biar lebih modern -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: "Plus Jakarta Sans", ui-sans-serif, system-ui;
        }
    </style>
</head>

<?php
$cart = session()->get('cart') ?? [];
$cartCount = 0;
foreach ($cart as $it) {
    $cartCount += (int) ($it['qty'] ?? 0);
}
$loggedIn = (bool) session()->get('customer_logged_in');
$customerName = (string) (session()->get('customer_name') ?? '');
?>

<body class="bg-gradient-to-b from-orange-50 via-white to-white text-gray-900">

    <header class="sticky top-0 z-40 border-b bg-white/85 backdrop-blur">
        <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between gap-4">

            <!-- Brand -->
            <a href="/" class="flex items-center gap-3 group">
                <div
                    class="w-10 h-10 rounded-2xl bg-gradient-to-br from-orange-500 to-rose-500 text-white flex items-center justify-center shadow-sm">
                    <i data-lucide="chef-hat" class="w-5 h-5"></i>
                </div>
                <div class="leading-tight">
                    <div class="font-extrabold text-base group-hover:opacity-90">Bakso Aci</div>
                    <div class="text-xs text-gray-500 -mt-0.5">Hangat • Pedas • Nagih</div>
                </div>
            </a>

            <!-- NAV MENU (Desktop) -->
            <nav class="hidden md:flex items-center gap-1 text-sm font-medium">
                <a href="/" class="px-3 py-2 rounded-xl hover:bg-orange-50">Menu</a>
                <a href="/promo" class="px-3 py-2 rounded-xl hover:bg-orange-50">Promo</a>
                <a href="/#tentang" class="px-3 py-2 rounded-xl hover:bg-orange-50">Tentang</a>
                <a href="/#kontak" class="px-3 py-2 rounded-xl hover:bg-orange-50">Kontak</a>
            </nav>

            <!-- Actions -->
            <div class="flex items-center gap-2 sm:gap-3">

                <!-- Cart -->
                <a href="/cart"
                    class="relative inline-flex items-center gap-2 text-sm px-3 py-2 rounded-xl border bg-white hover:bg-gray-50">
                    <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                    <span class="hidden sm:inline">Keranjang</span>

                    <?php if (($cartCount ?? 0) > 0): ?>
                        <span
                            class="absolute -top-2 -right-2 text-[10px] font-bold px-2 py-0.5 rounded-full bg-black text-white">
                            <?= (int) $cartCount ?>
                        </span>
                    <?php endif; ?>
                </a>

                <!-- Auth -->
                <?php if (session()->get('customer_logged_in')): ?>
                    <div
                        class="hidden sm:flex items-center gap-2 px-3 py-2 rounded-xl bg-gradient-to-r from-orange-50 to-rose-50 border">
                        <i data-lucide="user" class="w-4 h-4 text-gray-700"></i>
                        <div class="text-sm text-gray-700">
                            Hi, <b><?= esc(session()->get('customer_name')) ?></b>
                        </div>
                    </div>
                    <a href="/logout" class="text-sm px-3 py-2 rounded-xl border bg-white hover:bg-gray-50">
                        Logout
                    </a>
                <?php else: ?>
                    <a href="/login" class="text-sm px-3 py-2 rounded-xl border bg-white hover:bg-gray-50">
                        Login
                    </a>
                    <a href="/register" class="text-sm px-4 py-2 rounded-xl text-white font-semibold shadow-sm
                           bg-gradient-to-r from-orange-600 to-rose-600 hover:opacity-95">
                        Daftar
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- NAV MOBILE -->
        <div class="md:hidden border-t bg-white">
            <nav class="max-w-5xl mx-auto px-4 py-2 grid grid-cols-4 text-xs font-medium text-center">
                <a href="/" class="py-2 rounded-lg hover:bg-orange-50 flex flex-col items-center gap-1">
                    <i data-lucide="utensils" class="w-4 h-4"></i>
                    Menu
                </a>
                <a href="/promo" class="py-2 rounded-lg hover:bg-orange-50 flex flex-col items-center gap-1">
                    <i data-lucide="ticket" class="w-4 h-4"></i>
                    Promo
                </a>
                <a href="/#tentang" class="py-2 rounded-lg hover:bg-orange-50 flex flex-col items-center gap-1">
                    <i data-lucide="info" class="w-4 h-4"></i>
                    Tentang
                </a>
                <a href="/#kontak" class="py-2 rounded-lg hover:bg-orange-50 flex flex-col items-center gap-1">
                    <i data-lucide="phone" class="w-4 h-4"></i>
                    Kontak
                </a>
            </nav>
        </div>
    </header>

    <!-- Hero (full width) -->
    <?= $this->renderSection('hero') ?>

    <!-- Main -->
    <main class="max-w-5xl mx-auto px-4 py-4">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="mb-4 p-4 rounded-2xl border border-red-200 bg-red-50 text-red-800 flex items-start gap-3">
                <i data-lucide="alert-triangle" class="w-5 h-5 mt-0.5"></i>
                <div><?= esc(session()->getFlashdata('error')) ?></div>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="mb-4 p-4 rounded-2xl border border-green-200 bg-green-50 text-green-800 flex items-start gap-3">
                <i data-lucide="check-circle" class="w-5 h-5 mt-0.5"></i>
                <div><?= esc(session()->getFlashdata('success')) ?></div>
            </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>

        <!-- Footer -->
        <footer class="mt-10 pt-6 border-t text-sm text-gray-500">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <div class="flex items-center gap-2">
                    <i data-lucide="sparkles" class="w-4 h-4"></i>
                    <span>Terima kasih sudah belanja di Bakso Aci!</span>
                </div>
                <div class="text-xs">
                    © <?= date('Y') ?> Bakso Aci • Powered by CodeIgniter 4
                </div>
            </div>
        </footer>
    </main>

    <script>lucide.createIcons();</script>
</body>

</html>