<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-4">
    <h1 class="text-xl font-bold">Menu</h1>
    <a href="<?= site_url('admin/menus/create') ?>" class="px-3 py-2 rounded-lg bg-black text-white text-sm">
        Tambah Menu
    </a>
</div>

<div class="bg-white border rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left p-3">Gambar</th>
                <th class="text-left p-3">Nama</th>
                <?php if (!empty($hasCategories)): ?>
                    <th class="text-left p-3">Kategori</th>
                <?php endif; ?>
                <th class="text-left p-3">Harga</th>
                <th class="text-left p-3">Aktif</th>
                <th class="text-left p-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($menus)): ?>
                <tr>
                    <td class="p-3 text-gray-600" colspan="<?= !empty($hasCategories) ? 6 : 5 ?>">
                        Belum ada menu.
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($menus as $m): ?>
                    <tr class="border-t">
                        <td class="p-3">
                            <?php if (!empty($m['image'])): ?>
                                <img src="<?= base_url($m['image']) ?>" class="w-16 h-16 object-cover rounded-lg border" />
                            <?php else: ?>
                                <div class="w-16 h-16 rounded-lg border bg-gray-100"></div>
                            <?php endif; ?>
                        </td>

                        <td class="p-3 font-medium"><?= esc($m['name']) ?></td>

                        <?php if (!empty($hasCategories)): ?>
                            <td class="p-3"><?= esc($m['category_name'] ?? '-') ?></td>
                        <?php endif; ?>

                        <td class="p-3">Rp<?= number_format((int) $m['price'], 0, ',', '.') ?></td>
                        <td class="p-3"><?= ((int) $m['is_active'] === 1) ? 'Ya' : 'Tidak' ?></td>

                        <td class="p-3 flex gap-2">
                            <a class="px-3 py-2 rounded-lg border text-sm"
                                href="<?= site_url('admin/menus/' . $m['id'] . '/edit') ?>">
                                Edit
                            </a>

                            <form method="post" action="<?= site_url('admin/menus/' . $m['id'] . '/delete') ?>"
                                onsubmit="return confirm('Hapus menu ini?')">
                                <?= csrf_field() ?>
                                <button class="px-3 py-2 rounded-lg bg-red-600 text-white text-sm">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>