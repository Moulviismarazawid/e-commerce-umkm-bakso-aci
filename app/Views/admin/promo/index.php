<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-4">
    <h1 class="text-xl font-bold">Promo</h1>
    <a href="<?= site_url('admin/promo/create') ?>" class="px-3 py-2 rounded-lg bg-black text-white text-sm">Tambah</a>
</div>

<div class="bg-white border rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left p-3">Kode</th>
                <th class="text-left p-3">Tipe</th>
                <th class="text-left p-3">Nilai</th>
                <th class="text-left p-3">Min</th>
                <th class="text-left p-3">Kuota</th>
                <th class="text-left p-3">Terpakai</th>
                <th class="text-left p-3">Aktif</th>
                <th class="text-left p-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($promos)): ?>
                <tr>
                    <td class="p-3 text-gray-600" colspan="8">Belum ada promo.</td>
                </tr>
            <?php else:
                foreach ($promos as $p): ?>
                    <tr class="border-t">
                        <td class="p-3 font-semibold">
                            <?= esc($p['code']) ?>
                        </td>
                        <td class="p-3">
                            <?= esc($p['type']) ?>
                        </td>
                        <td class="p-3">
                            <?php if (($p['type'] ?? '') === 'percent'): ?>
                                <?= (int) $p['value'] ?>%
                                <?php if (!empty($p['max_discount'])): ?>
                                    <div class="text-xs text-gray-500">Max Rp
                                        <?= number_format((int) $p['max_discount'], 0, ',', '.') ?>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                Rp
                                <?= number_format((int) $p['value'], 0, ',', '.') ?>
                            <?php endif; ?>
                        </td>
                        <td class="p-3">Rp
                            <?= number_format((int) ($p['min_subtotal'] ?? 0), 0, ',', '.') ?>
                        </td>
                        <td class="p-3">
                            <?= esc($p['usage_limit'] ?? '∞') ?>
                        </td>
                        <td class="p-3">
                            <?= (int) ($p['used_count'] ?? 0) ?>
                        </td>
                        <td class="p-3">
                            <?= ((int) $p['is_active'] === 1) ? 'Ya' : 'Tidak' ?>
                        </td>
                        <td class="p-3 flex gap-2">
                            <a href="<?= site_url('admin/promo/' . $p['id'] . '/edit') ?>"
                                class="px-3 py-2 rounded-lg border text-sm">Edit</a>
                            <form method="post" action="<?= site_url('admin/promo/' . $p['id'] . '/delete') ?>"
                                onsubmit="return confirm('Hapus promo ini?')">
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