<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<h1 class="text-xl font-bold mb-4">Edit Promo</h1>

<form method="post" action="<?= site_url('admin/promo/' . $promo['id']) ?>"
    class="bg-white border rounded-xl p-5 space-y-3 max-w-2xl">
    <?= csrf_field() ?>

    <div>
        <label class="text-sm text-gray-600">Kode</label>
        <input value="<?= esc($promo['code']) ?>" class="w-full border rounded-lg p-2 bg-gray-50" readonly>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
            <label class="text-sm text-gray-600">Tipe</label>
            <select name="type" class="w-full border rounded-lg p-2">
                <option value="percent" <?= (($promo['type'] ?? '') === 'percent') ? 'selected' : '' ?>>percent</option>
                <option value="fixed" <?= (($promo['type'] ?? '') === 'fixed') ? 'selected' : '' ?>>fixed</option>
            </select>
        </div>
        <div>
            <label class="text-sm text-gray-600">Nilai</label>
            <input type="number" name="value" value="<?= esc($promo['value'] ?? 0) ?>"
                class="w-full border rounded-lg p-2">
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
            <label class="text-sm text-gray-600">Minimal Subtotal</label>
            <input type="number" name="min_subtotal" value="<?= esc($promo['min_subtotal'] ?? 0) ?>"
                class="w-full border rounded-lg p-2">
        </div>
        <div>
            <label class="text-sm text-gray-600">Max Diskon</label>
            <input type="number" name="max_discount" value="<?= esc($promo['max_discount'] ?? '') ?>"
                class="w-full border rounded-lg p-2">
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
            <label class="text-sm text-gray-600">Mulai</label>
            <input type="date" name="start_date" value="<?= esc($promo['start_date'] ?? '') ?>"
                class="w-full border rounded-lg p-2">
        </div>
        <div>
            <label class="text-sm text-gray-600">Berakhir</label>
            <input type="date" name="end_date" value="<?= esc($promo['end_date'] ?? '') ?>"
                class="w-full border rounded-lg p-2">
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
            <label class="text-sm text-gray-600">Limit Penggunaan</label>
            <input type="number" name="usage_limit" value="<?= esc($promo['usage_limit'] ?? '') ?>"
                class="w-full border rounded-lg p-2">
        </div>
        <div class="flex items-center gap-2 mt-6">
            <input type="checkbox" name="is_active" value="1" <?= ((int) ($promo['is_active'] ?? 0) === 1) ? 'checked' : '' ?>>
            <span class="text-sm">Aktif</span>
        </div>
    </div>

    <div class="flex gap-2">
        <button class="px-4 py-2 rounded-lg bg-black text-white">Update</button>
        <a href="<?= site_url('admin/promo') ?>" class="px-4 py-2 rounded-lg border">Batal</a>
    </div>
</form>

<?= $this->endSection() ?>