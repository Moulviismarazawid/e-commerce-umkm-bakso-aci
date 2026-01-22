<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<h1 class="text-xl font-bold mb-4">Edit Banner</h1>

<form method="post" action="<?= site_url('admin/banners/' . $banner['id']) ?>" enctype="multipart/form-data"
    class="bg-white border rounded-xl p-5 space-y-3 max-w-2xl">
    <?= csrf_field() ?>

    <div>
        <label class="text-sm text-gray-600">Judul</label>
        <input name="title" value="<?= esc(old('title') ?? ($banner['title'] ?? '')) ?>"
            class="w-full border rounded-lg p-2">
    </div>

    <div>
        <label class="text-sm text-gray-600">Subjudul</label>
        <input name="subtitle" value="<?= esc(old('subtitle') ?? ($banner['subtitle'] ?? '')) ?>"
            class="w-full border rounded-lg p-2">
    </div>

    <div>
        <label class="text-sm text-gray-600">Alamat Toko</label>
        <textarea name="store_address" class="w-full border rounded-lg p-2"
            rows="3"><?= esc(old('store_address') ?? ($banner['store_address'] ?? '')) ?></textarea>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
            <label class="text-sm text-gray-600">CTA Label</label>
            <input name="cta_label" value="<?= esc(old('cta_label') ?? ($banner['cta_label'] ?? '')) ?>"
                class="w-full border rounded-lg p-2">
        </div>
        <div>
            <label class="text-sm text-gray-600">CTA URL</label>
            <input name="cta_url" value="<?= esc(old('cta_url') ?? ($banner['cta_url'] ?? '')) ?>"
                class="w-full border rounded-lg p-2">
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
            <label class="text-sm text-gray-600">Urutan</label>
            <input type="number" name="sort_order" value="<?= esc(old('sort_order') ?? (int) $banner['sort_order']) ?>"
                class="w-full border rounded-lg p-2">
        </div>
        <div class="flex items-center gap-2 mt-6">
            <input type="checkbox" name="is_active" value="1" <?= ((int) $banner['is_active'] === 1) ? 'checked' : '' ?>>
            <span class="text-sm">Aktif</span>
        </div>
    </div>

    <div>
        <label class="text-sm text-gray-600">Gambar Banner</label>

        <?php if (!empty($banner['image'])): ?>
            <img src="<?= base_url($banner['image']) ?>" class="w-full max-w-md h-40 object-cover rounded-lg border mb-2">
        <?php endif; ?>

        <input type="file" name="image" class="w-full border rounded-lg p-2">
    </div>

    <div class="flex gap-2">
        <button class="px-4 py-2 rounded-lg bg-black text-white">Update</button>
        <a href="<?= site_url('admin/banners') ?>" class="px-4 py-2 rounded-lg border">Batal</a>
    </div>
</form>

<?= $this->endSection() ?>