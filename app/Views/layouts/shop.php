<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <title><?= esc($title ?? 'Bakso Mukbang Kemiling') ?></title>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: "Plus Jakarta Sans", ui-sans-serif, system-ui;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
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

<body class="bg-gradient-to-b from-orange-50 via-white to-white text-gray-900 min-h-screen flex flex-col">

    <!-- Header -->
    <header class="sticky top-0 z-40 border-b bg-white/90 backdrop-blur">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between gap-6">

            <!-- Brand -->
            <a href="<?= site_url('/') ?>" class="flex items-center gap-3 group min-w-0 shrink-0">
                <div
                    class="w-10 h-10 rounded-2xl bg-gradient-to-br from-orange-500 to-rose-500 text-white flex items-center justify-center shadow-sm">
                    <i data-lucide="chef-hat" class="w-5 h-5"></i>
                </div>
                <div class="leading-tight min-w-0">
                    <div class="font-extrabold text-base group-hover:opacity-90 truncate">
                        Bakso Mukbang Kemiling
                    </div>
                </div>
            </a>

            <!-- Desktop Nav -->
            <nav class="hidden lg:flex items-center gap-3 text-sm font-medium">
                <a href="<?= site_url('/') ?>"
                    class="px-4 py-2 rounded-xl hover:bg-orange-50 inline-flex items-center gap-2">
                    <i data-lucide="utensils" class="w-4 h-4"></i>
                    Menu
                </a>

                <a href="<?= site_url('promo') ?>"
                    class="px-4 py-2 rounded-xl hover:bg-orange-50 inline-flex items-center gap-2">
                    <i data-lucide="ticket" class="w-4 h-4"></i>
                    Promo
                </a>

                <a href="<?= site_url('kontak') ?>"
                    class="px-4 py-2 rounded-xl hover:bg-orange-50 inline-flex items-center gap-2">
                    <i data-lucide="phone" class="w-4 h-4"></i>
                    Kontak
                </a>

                <?php if ($loggedIn): ?>
                    <a href="<?= site_url('orders') ?>"
                        class="px-4 py-2 rounded-xl hover:bg-orange-50 inline-flex items-center gap-2">
                        <i data-lucide="receipt" class="w-4 h-4"></i>
                        Riwayat
                    </a>
                <?php endif; ?>
            </nav>

            <!-- Actions -->
            <div class="flex items-center gap-3 shrink-0">

                <!-- Cart -->
                <a href="<?= site_url('cart') ?>"
                    class="relative inline-flex items-center gap-2 text-sm px-4 py-2 rounded-xl border bg-white hover:bg-gray-50">
                    <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                    <span class="hidden sm:inline">Keranjang</span>

                    <?php if ($cartCount > 0): ?>
                        <span
                            class="absolute -top-2 -right-2 text-[10px] font-bold px-2 py-0.5 rounded-full bg-black text-white">
                            <?= (int) $cartCount ?>
                        </span>
                    <?php endif; ?>
                </a>

                <?php if ($loggedIn): ?>
                    <div
                        class="hidden md:flex items-center gap-2 px-4 py-2 rounded-xl bg-gradient-to-r from-orange-50 to-rose-50 border">
                        <i data-lucide="user" class="w-4 h-4 text-gray-700"></i>
                        <div class="text-sm text-gray-700 whitespace-nowrap">
                            Hi, <b><?= esc($customerName) ?></b>
                        </div>
                    </div>

                    <a href="<?= site_url('logout') ?>"
                        class="text-sm px-4 py-2 rounded-xl border bg-white hover:bg-gray-50 inline-flex items-center gap-2">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                        Logout
                    </a>
                <?php else: ?>
                    <a href="<?= site_url('login') ?>"
                        class="text-sm px-4 py-2 rounded-xl border bg-white hover:bg-gray-50 inline-flex items-center gap-2">
                        <i data-lucide="log-in" class="w-4 h-4"></i>
                        <span>Login</span>
                    </a>

                    <a href="<?= site_url('register') ?>"
                        class="hidden sm:inline-flex text-sm px-5 py-2 rounded-xl text-white font-semibold shadow-sm
                              bg-gradient-to-r from-orange-600 to-rose-600 hover:opacity-95 inline-flex items-center gap-2">
                        <i data-lucide="user-plus" class="w-4 h-4"></i>
                        Daftar
                    </a>
                <?php endif; ?>

            </div>
        </div>

        <!-- Mobile Nav -->
        <div class="lg:hidden border-t bg-white">
            <nav class="max-w-6xl mx-auto px-4 py-2">
                <div class="flex items-center gap-2 overflow-x-auto no-scrollbar">
                    <a href="<?= site_url('/') ?>"
                        class="shrink-0 px-3 py-2 rounded-xl hover:bg-orange-50 flex items-center gap-2 text-xs font-medium">
                        <i data-lucide="utensils" class="w-4 h-4"></i> Menu
                    </a>

                    <a href="<?= site_url('promo') ?>"
                        class="shrink-0 px-3 py-2 rounded-xl hover:bg-orange-50 flex items-center gap-2 text-xs font-medium">
                        <i data-lucide="ticket" class="w-4 h-4"></i> Promo
                    </a>

                    <a href="<?= site_url('kontak') ?>"
                        class="shrink-0 px-3 py-2 rounded-xl hover:bg-orange-50 flex items-center gap-2 text-xs font-medium">
                        <i data-lucide="phone" class="w-4 h-4"></i> Kontak
                    </a>

                    <?php if ($loggedIn): ?>
                        <a href="<?= site_url('orders') ?>"
                            class="shrink-0 px-3 py-2 rounded-xl hover:bg-orange-50 flex items-center gap-2 text-xs font-medium">
                            <i data-lucide="receipt" class="w-4 h-4"></i> Riwayat
                        </a>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    </header>

    <!-- Hero -->
    <?= $this->renderSection('hero') ?>

    <!-- Content -->
    <div class="flex-1">
        <main class="max-w-6xl mx-auto px-4 py-4">

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
        </main>
    </div>

    <!-- Footer -->
    <footer class="border-t text-sm text-gray-500">
        <div class="max-w-6xl mx-auto px-4 py-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <div class="flex items-center gap-2">
                    <i data-lucide="sparkles" class="w-4 h-4"></i>
                    <span>Terima kasih sudah belanja di Bakso Mukbang Kemiling!</span>
                </div>
                <div class="text-xs">
                    © <?= date('Y') ?> Bakso Mukbang Kemiling • Powered by CodeIgniter 4
                </div>
            </div>
        </div>
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>