<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-4">
    <h1 class="text-xl font-bold">Pengaturan Kontak</h1>
</div>

<form method="post" action="<?= site_url('admin/settings/kontak') ?>"
    class="bg-white border rounded-xl p-5 space-y-3 max-w-2xl">
    <?= csrf_field() ?>

    <div>
        <label class="text-sm text-gray-600">WhatsApp (format 62xxxx)</label>
        <input name="contact_whatsapp"
            value="<?= esc(old('contact_whatsapp') ?? ($settings['contact_whatsapp'] ?? '')) ?>"
            class="w-full border rounded-lg p-2" placeholder="62812xxxx">
    </div>

    <div>
        <label class="text-sm text-gray-600">Alamat</label>
        <textarea name="contact_address" class="w-full border rounded-lg p-2" rows="3"
            placeholder="Alamat toko"><?= esc(old('contact_address') ?? ($settings['contact_address'] ?? '')) ?></textarea>
    </div>

    <div>
        <label class="text-sm text-gray-600">Link Shopee</label>
        <input type="url" name="contact_shopee"
            value="<?= esc(old('contact_shopee') ?? ($settings['contact_shopee'] ?? '')) ?>"
            class="w-full border rounded-lg p-2" placeholder="https://shopee.co.id/...">
    </div>

    <div>
        <label class="text-sm text-gray-600">Link TikTok</label>
        <input type="url" name="contact_tiktok"
            value="<?= esc(old('contact_tiktok') ?? ($settings['contact_tiktok'] ?? '')) ?>"
            class="w-full border rounded-lg p-2" placeholder="https://www.tiktok.com/@...">
    </div>

    <button class="px-4 py-2 rounded-lg bg-black text-white">Simpan</button>
</form>

<?= $this->endSection() ?>