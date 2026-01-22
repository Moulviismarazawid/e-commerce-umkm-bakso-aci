<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<h1 class="text-xl font-bold mb-4">Tambah Banner</h1>

<form method="post" action="<?= site_url('admin/banners') ?>" enctype="multipart/form-data"
    class="bg-white border rounded-xl p-5 space-y-3 max-w-2xl">
    <?= csrf_field() ?>

    <div>
        <label class="text-sm text-gray-600">Judul</label>
        <input name="title" value="<?= esc(old('title')) ?>" class="w-full border rounded-lg p-2">
    </div>

    <div>
        <label class="text-sm text-gray-600">Subjudul</label>
        <input name="subtitle" value="<?= esc(old('subtitle')) ?>" class="w-full border rounded-lg p-2">
    </div>

    <div>
        <label class="text-sm text-gray-600">Alamat Toko</label>
        <textarea name="store_address" class="w-full border rounded-lg p-2"
            rows="3"><?= esc(old('store_address')) ?></textarea>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
            <label class="text-sm text-gray-600">CTA Label (opsional)</label>
            <input name="cta_label" value="<?= esc(old('cta_label')) ?>" class="w-full border rounded-lg p-2"
                placeholder="Contoh: Lihat Maps">
        </div>
        <div>
            <label class="text-sm text-gray-600">CTA URL (opsional)</label>
            <input name="cta_url" value="<?= esc(old('cta_url')) ?>" class="w-full border rounded-lg p-2"
                placeholder="https://maps.google.com/...">
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
            <label class="text-sm text-gray-600">Urutan</label>
            <input type="number" name="sort_order" value="<?= esc(old('sort_order') ?? 0) ?>"
                class="w-full border rounded-lg p-2">
        </div>
        <div class="flex items-center gap-2 mt-6">
            <input type="checkbox" name="is_active" value="1" checked>
            <span class="text-sm">Aktif</span>
        </div>
    </div>

    <div>
        <label class="text-sm text-gray-600">Gambar Banner</label>
        <input type="file" name="image" class="w-full border rounded-lg p-2">
        <div class="text-xs text-gray-500 mt-1">Disarankan ukuran landscape (misal 1200x500).</div>
    </div>

    <div class="flex gap-2">
        <button class="px-4 py-2 rounded-lg bg-black text-white">Simpan</button>
        <a href="<?= site_url('admin/banners') ?>" class="px-4 py-2 rounded-lg border">Batal</a>
    </div>
</form>

<?= $this->endSection() ?>