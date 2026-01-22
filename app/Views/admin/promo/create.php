<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<h1 class="text-xl font-bold mb-4">Tambah Promo</h1>

<form method="post" action="<?= site_url('admin/promo') ?>" class="bg-white border rounded-xl p-5 space-y-3 max-w-2xl">
    <?= csrf_field() ?>

    <div class="flex gap-2">
        <div class="w-full">
            <label class="text-sm text-gray-600">Kode Promo</label>
            <input id="code" name="code" value="<?= esc(old('code')) ?>" class="w-full border rounded-lg p-2"
                placeholder="PROMO2026" required>
        </div>
        <div class="pt-6">
            <button type="button" id="gen" class="px-3 py-2 rounded-lg border">Auto</button>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
            <label class="text-sm text-gray-600">Tipe</label>
            <select name="type" class="w-full border rounded-lg p-2">
                <option value="percent">percent</option>
                <option value="fixed">fixed</option>
            </select>
        </div>
        <div>
            <label class="text-sm text-gray-600">Nilai</label>
            <input type="number" name="value" value="<?= esc(old('value') ?? 10) ?>"
                class="w-full border rounded-lg p-2">
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
            <label class="text-sm text-gray-600">Minimal Subtotal</label>
            <input type="number" name="min_subtotal" value="<?= esc(old('min_subtotal') ?? 0) ?>"
                class="w-full border rounded-lg p-2">
        </div>
        <div>
            <label class="text-sm text-gray-600">Max Diskon (khusus percent)</label>
            <input type="number" name="max_discount" value="<?= esc(old('max_discount') ?? '') ?>"
                class="w-full border rounded-lg p-2" placeholder="kosongkan jika tidak ada">
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
            <label class="text-sm text-gray-600">Mulai</label>
            <input type="date" name="start_date" value="<?= esc(old('start_date') ?? '') ?>"
                class="w-full border rounded-lg p-2">
        </div>
        <div>
            <label class="text-sm text-gray-600">Berakhir</label>
            <input type="date" name="end_date" value="<?= esc(old('end_date') ?? '') ?>"
                class="w-full border rounded-lg p-2">
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
            <label class="text-sm text-gray-600">Limit Penggunaan</label>
            <input type="number" name="usage_limit" value="<?= esc(old('usage_limit') ?? '') ?>"
                class="w-full border rounded-lg p-2" placeholder="kosongkan untuk unlimited">
        </div>
        <div class="flex items-center gap-2 mt-6">
            <input type="checkbox" name="is_active" value="1" checked>
            <span class="text-sm">Aktif</span>
        </div>
    </div>

    <div class="flex gap-2">
        <button class="px-4 py-2 rounded-lg bg-black text-white">Simpan</button>
        <a href="<?= site_url('admin/promo') ?>" class="px-4 py-2 rounded-lg border">Batal</a>
    </div>
</form>

<script>
    document.getElementById('gen').addEventListener('click', async () => {
        const res = await fetch("<?= site_url('admin/promo/generate') ?>", { method: "POST" });
        const data = await res.json();
        document.getElementById('code').value = data.code || '';
    });
</script>

<?= $this->endSection() ?>