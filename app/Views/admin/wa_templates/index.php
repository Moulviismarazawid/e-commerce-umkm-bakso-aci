<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<h1 class="text-xl font-bold mb-4">Template Pesan WhatsApp</h1>

<div class="bg-white border rounded-xl p-4 mb-4 text-sm text-gray-700">
    <div class="font-semibold mb-2">Placeholder yang tersedia</div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-1 text-xs">
        <div>{invoice}</div>
        <div>{customer_name}</div>
        <div>{customer_phone}</div>
        <div>{subtotal}</div>
        <div>{discount}</div>
        <div>{total}</div>
        <div>{queue_number}</div>
        <div>{queue_date}</div>
        <div>{items}</div>
    </div>
</div>

<?php if (empty($templates)): ?>
    <div class="bg-white border rounded-xl p-6 text-gray-600">Belum ada template.</div>
<?php else: ?>
    <div class="space-y-4">
        <?php foreach ($templates as $t): ?>
            <form method="post" action="<?= site_url('admin/wa-templates') ?>" class="bg-white border rounded-xl p-5">
                <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= (int) $t['id'] ?>">

                <div class="flex items-start justify-between gap-3">
                    <div>
                        <div class="text-sm text-gray-500">
                            <?= esc($t['key']) ?>
                        </div>
                        <div class="text-lg font-bold">
                            <?= esc($t['title'] ?? '-') ?>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <label class="text-sm">Aktif</label>
                        <input type="checkbox" name="is_active" value="1" <?= ((int) $t['is_active'] === 1) ? 'checked' : '' ?>>
                    </div>
                </div>

                <div class="mt-3">
                    <label class="text-sm text-gray-600">Judul</label>
                    <input name="title" value="<?= esc($t['title'] ?? '') ?>" class="w-full border rounded-lg p-2">
                </div>

                <div class="mt-3">
                    <label class="text-sm text-gray-600">Pesan Template</label>
                    <textarea name="message" rows="8"
                        class="w-full border rounded-lg p-2 font-mono text-sm"><?= esc($t['message'] ?? '') ?></textarea>
                    <div class="text-xs text-gray-500 mt-2">
                        Tips: untuk baris baru cukup Enter. Nanti otomatis dikirim sebagai pesan WA.
                    </div>
                </div>

                <div class="mt-3 flex gap-2">
                    <button class="px-4 py-2 rounded-lg bg-black text-white">Simpan</button>
                </div>
            </form>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>