<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-4">
    <h1 class="text-xl font-bold">Banner</h1>
    <a href="<?= site_url('admin/banners/create') ?>"
        class="px-3 py-2 rounded-lg bg-black text-white text-sm">Tambah</a>
</div>

<div class="bg-white border rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left p-3">Gambar</th>
                <th class="text-left p-3">Judul</th>
                <th class="text-left p-3">Alamat</th>
                <th class="text-left p-3">Urutan</th>
                <th class="text-left p-3">Aktif</th>
                <th class="text-left p-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($banners)): ?>
                <tr>
                    <td class="p-3 text-gray-600" colspan="6">Belum ada banner.</td>
                </tr>
            <?php else:
                foreach ($banners as $b): ?>
                    <tr class="border-t">
                        <td class="p-3">
                            <?php if (!empty($b['image'])): ?>
                                <img src="<?= base_url($b['image']) ?>" class="w-24 h-14 object-cover rounded-lg border">
                            <?php else: ?>
                                <div class="w-24 h-14 rounded-lg border bg-gray-100"></div>
                            <?php endif; ?>
                        </td>
                        <td class="p-3 font-medium"><?= esc($b['title'] ?? '-') ?></td>
                        <td class="p-3 text-gray-600"><?= esc($b['store_address'] ?? '-') ?></td>
                        <td class="p-3"><?= (int) $b['sort_order'] ?></td>
                        <td class="p-3"><?= ((int) $b['is_active'] === 1) ? 'Ya' : 'Tidak' ?></td>
                        <td class="p-3 flex gap-2">
                            <a class="px-3 py-2 rounded-lg border text-sm"
                                href="<?= site_url('admin/banners/' . $b['id'] . '/edit') ?>">Edit</a>
                            <form method="post" action="<?= site_url('admin/banners/' . $b['id'] . '/delete') ?>"
                                onsubmit="return confirm('Hapus banner ini?')">
                                <?= csrf_field() ?>
                                <button class="px-3 py-2 rounded-lg bg-red-600 text-white text-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>