<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-4">
    <h1 class="text-xl font-bold">Tambah Menu</h1>
    <a href="<?= site_url('admin/menus') ?>" class="px-3 py-2 rounded-lg border text-sm">Kembali</a>
</div>

<form method="post" action="<?= site_url('admin/menus') ?>" enctype="multipart/form-data"
    class="bg-white border rounded-xl p-5 space-y-3 max-w-2xl">
    <?= csrf_field() ?>

    <div>
        <label class="text-sm text-gray-600">Nama</label>
        <input name="name" value="<?= esc(old('name')) ?>" class="w-full border rounded-lg p-2" required>
    </div>

    <?php if (!empty($hasCategories)): ?>
        <div>
            <label class="text-sm text-gray-600">Kategori</label>
            <select name="category_id" class="w-full border rounded-lg p-2">
                <option value="">- Tanpa kategori -</option>
                <?php foreach ($categories as $c): ?>
                    <option value="<?= (int) $c['id'] ?>"><?= esc($c['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    <?php endif; ?>

    <div>
        <label class="text-sm text-gray-600">Deskripsi</label>
        <textarea name="description" class="w-full border rounded-lg p-2"
            rows="3"><?= esc(old('description')) ?></textarea>
    </div>

    <div>
        <label class="text-sm text-gray-600">Harga</label>
        <input type="number" name="price" value="<?= esc(old('price')) ?>" class="w-full border rounded-lg p-2" min="1"
            required>
    </div>

    <div>
        <label class="text-sm text-gray-600">Gambar (opsional)</label>
        <input type="file" name="image" class="w-full border rounded-lg p-2">
    </div>

    <label class="inline-flex items-center gap-2 text-sm">
        <input type="checkbox" name="is_active" value="1" checked>
        Aktif
    </label>

    <div class="flex gap-2">
        <button class="px-4 py-2 rounded-lg bg-black text-white">Simpan</button>
        <a href="<?= site_url('admin/menus') ?>" class="px-4 py-2 rounded-lg border">Batal</a>
    </div>
</form>

<?= $this->endSection() ?>