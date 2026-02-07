<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <title><?= esc($title ?? 'Admin') ?></title>
</head>

<?php
$path = '/' . trim((string) (service('uri')->getPath()), '/'); // contoh: /admin/orders
$adminName = (string) (session()->get('admin_name') ?? 'Admin');

$nav = [
    ['label' => 'Dashboard', 'href' => '/admin/dashboard', 'icon' => 'layout-dashboard'],
    ['label' => 'Menu', 'href' => '/admin/menus', 'icon' => 'utensils'],
    ['label' => 'Banner', 'href' => '/admin/banners', 'icon' => 'image'],
    ['label' => 'Promo', 'href' => '/admin/promo', 'icon' => 'ticket'],
    ['label' => 'Order', 'href' => '/admin/orders', 'icon' => 'shopping-bag'],
    ['label' => 'Antrian', 'href' => '/admin/queue', 'icon' => 'list-ordered'],
    ['label' => 'Kontak', 'href' => '/admin/settings/kontak', 'icon' => 'link'],

    ['label' => 'Template WA', 'href' => '/admin/wa-templates', 'icon' => 'message-circle'],
    ['label' => 'Laporan', 'href' => '/admin/reports/finance', 'icon' => 'bar-chart-3'],
];

function isActive(string $current, string $href): bool
{
    // aktif jika exact match atau current dimulai dengan href (untuk /admin/orders/12 dll)
    if ($current === $href)
        return true;
    if (str_starts_with($current, rtrim($href, '/') . '/'))
        return true;
    return false;
}
?>

<body class="bg-gray-50">
    <div class="min-h-screen flex">

        <!-- Mobile overlay -->
        <div id="overlay" class="fixed inset-0 bg-black/40 z-40 hidden md:hidden"></div>

        <!-- Sidebar (Desktop + Mobile Drawer) -->
        <aside id="sidebar" class="fixed md:static z-50 md:z-auto inset-y-0 left-0 w-72 md:w-64 bg-white border-r
                   transform -translate-x-full md:translate-x-0 transition-transform duration-200">

            <!-- Brand -->
            <div class="p-4 border-b">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-black text-white flex items-center justify-center shadow">
                            <i data-lucide="chef-hat" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <div class="font-extrabold text-base leading-tight">Admin Bakso Aci</div>
                            <div class="text-xs text-gray-500">Panel Manajemen</div>
                        </div>
                    </div>

                    <button id="closeSidebar" class="md:hidden p-2 rounded-lg hover:bg-gray-100">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <div class="mt-4 flex items-center gap-3 bg-gray-50 border rounded-2xl p-3">
                    <div class="w-9 h-9 rounded-xl bg-white border flex items-center justify-center">
                        <i data-lucide="user" class="w-4 h-4"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="text-xs text-gray-500">Login sebagai</div>
                        <div class="text-sm font-semibold truncate"><?= esc($adminName) ?></div>
                    </div>
                </div>
            </div>

            <!-- Nav -->
            <nav class="p-3">
                <div class="text-xs font-semibold text-gray-500 px-3 mt-2 mb-2">MENU</div>

                <div class="space-y-1">
                    <?php foreach ($nav as $n): ?>
                        <?php $active = isActive($path, $n['href']); ?>
                        <a href="<?= esc($n['href']) ?>"
                            class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm border
                                   <?= $active ? 'bg-black text-white border-black shadow-sm' : 'bg-white text-gray-700 border-transparent hover:border-gray-200 hover:bg-gray-50' ?>">
                            <span class="w-9 h-9 rounded-xl flex items-center justify-center
                                         <?= $active ? 'bg-white/10' : 'bg-white border group-hover:bg-gray-100' ?>">
                                <i data-lucide="<?= esc($n['icon']) ?>" class="w-4 h-4"></i>
                            </span>
                            <span class="font-medium"><?= esc($n['label']) ?></span>

                            <?php if ($active): ?>
                                <span class="ml-auto text-xs px-2 py-1 rounded-lg bg-white/10 border border-white/10">
                                    aktif
                                </span>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>

                <div class="mt-4 pt-4 border-t">
                    <a href="/admin/logout" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm border
                               bg-red-50 text-red-700 border-red-100 hover:bg-red-100">
                        <span
                            class="w-9 h-9 rounded-xl bg-white border border-red-100 flex items-center justify-center">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                        </span>
                        <span class="font-medium">Logout</span>
                    </a>
                </div>
            </nav>

            <!-- Footer mini -->
            <div class="p-4 text-xs text-gray-500 border-t">
                <div class="flex items-center justify-between">
                    <span>© <?= date('Y') ?> Bakso Aci</span>
                    <span class="inline-flex items-center gap-1">
                        <i data-lucide="shield-check" class="w-4 h-4"></i> Secure
                    </span>
                </div>
            </div>
        </aside>

        <!-- Content -->
        <div class="flex-1 min-w-0">

            <!-- Topbar -->
            <header class="sticky top-0 z-30 bg-white/80 backdrop-blur border-b">
                <div class="p-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <button id="openSidebar" class="md:hidden p-2 rounded-lg border hover:bg-gray-50">
                            <i data-lucide="menu" class="w-5 h-5"></i>
                        </button>

                        <div>
                            <div class="text-sm text-gray-500">Halaman</div>
                            <div class="font-bold"><?= esc($title ?? 'Admin') ?></div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="/" target="_blank"
                            class="px-3 py-2 rounded-xl border bg-white hover:bg-gray-50 text-sm inline-flex items-center gap-2">
                            <i data-lucide="external-link" class="w-4 h-4"></i> Lihat Website
                        </a>
                    </div>
                </div>
            </header>

            <main class="p-4">
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="mb-4 p-3 rounded-xl border border-red-200 bg-red-50 text-red-700">
                        <?= esc(session()->getFlashdata('error')) ?>
                    </div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="mb-4 p-3 rounded-xl border border-green-200 bg-green-50 text-green-700">
                        <?= esc(session()->getFlashdata('success')) ?>
                    </div>
                <?php endif; ?>

                <?= $this->renderSection('content') ?>
            </main>

        </div>
    </div>

    <script>
        // Mobile sidebar toggle
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const openBtn = document.getElementById('openSidebar');
        const closeBtn = document.getElementById('closeSidebar');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }

        if (openBtn) openBtn.addEventListener('click', openSidebar);
        if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
        if (overlay) overlay.addEventListener('click', closeSidebar);

        lucide.createIcons();
    </script>
</body>

</html>