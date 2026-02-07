<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-4">
    <h1 class="text-xl font-bold">Edit Menu</h1>
    <a href="<?= site_url('admin/menus') ?>" class="px-3 py-2 rounded-lg border text-sm">Kembali</a>
</div>

<form method="post" action="<?= site_url('admin/menus/' . $menu['id']) ?>" enctype="multipart/form-data"
    class="bg-white border rounded-xl p-5 space-y-3 max-w-2xl">
    <?= csrf_field() ?>

    <div>
        <label class="text-sm text-gray-600">Nama</label>
        <input name="name" value="<?= esc(old('name') ?? $menu['name']) ?>" class="w-full border rounded-lg p-2"
            required>
    </div>

    <?php if (!empty($hasCategories)): ?>
        <div>
            <label class="text-sm text-gray-600">Kategori</label>
            <select name="category_id" class="w-full border rounded-lg p-2">
                <option value="">- Tanpa kategori -</option>
                <?php foreach ($categories as $c): ?>
                    <option value="<?= (int) $c['id'] ?>" <?= ((int) ($menu['category_id'] ?? 0) === (int) $c['id']) ? 'selected' : '' ?>>
                        <?= esc($c['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    <?php endif; ?>

    <div>
        <label class="text-sm text-gray-600">Deskripsi</label>
        <textarea name="description" class="w-full border rounded-lg p-2"
            rows="3"><?= esc(old('description') ?? ($menu['description'] ?? '')) ?></textarea>
    </div>

    <div>
        <label class="text-sm text-gray-600">Harga</label>
        <input type="number" name="price" value="<?= esc(old('price') ?? $menu['price']) ?>"
            class="w-full border rounded-lg p-2" min="1" required>
    </div>
    <div>
  <label class="text-sm text-gray-600">Link Shopee (opsional)</label>
  <input type="url" name="shopee_link"
         value="<?= esc(old('shopee_link') ?? ($menu['shopee_link'] ?? '')) ?>"
         class="w-full border rounded-lg p-2">
</div>

<div>
  <label class="text-sm text-gray-600">Link TikTok (opsional)</label>
  <input type="url" name="tiktok_link"
         value="<?= esc(old('tiktok_link') ?? ($menu['tiktok_link'] ?? '')) ?>"
         class="w-full border rounded-lg p-2">
</div>


    <div>
        <label class="text-sm text-gray-600">Gambar (opsional)</label>

        <?php if (!empty($menu['image'])): ?>
            <img src="<?= base_url($menu['image']) ?>" class="w-24 h-24 object-cover rounded-lg border mb-2" />
        <?php endif; ?>

        <input type="file" name="image" class="w-full border rounded-lg p-2">
    </div>

    <label class="inline-flex items-center gap-2 text-sm">
        <input type="checkbox" name="is_active" value="1" <?= ((int) $menu['is_active'] === 1) ? 'checked' : '' ?>>
        Aktif
    </label>

    <div class="flex gap-2">
        <button class="px-4 py-2 rounded-lg bg-black text-white">Update</button>
        <a href="<?= site_url('admin/menus') ?>" class="px-4 py-2 rounded-lg border">Batal</a>
    </div>
</form>

<?= $this->endSection() ?>