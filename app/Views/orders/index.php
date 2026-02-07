<?= $this->extend('layouts/shop') ?>
<?= $this->section('content') ?>

<div class="max-w-5xl mx-auto px-4 py-4">

    <div class="flex items-start justify-between gap-4 mb-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900">Riwayat Pembelian</h1>
            <p class="text-sm text-slate-600 mt-1">Daftar pesanan kamu yang pernah dibuat.</p>
        </div>
        <a href="<?= site_url('/') ?>"
            class="inline-flex items-center gap-2 text-sm px-3 py-2 rounded-xl border bg-white hover:bg-slate-50">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Belanja lagi
        </a>
    </div>

    <?php if (empty($orders)): ?>
        <div class="bg-white border rounded-2xl p-6 text-center">
            <div class="mx-auto w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center">
                <i data-lucide="receipt" class="w-6 h-6 text-orange-600"></i>
            </div>
            <div class="mt-3 font-semibold text-slate-900">Belum ada pesanan</div>
            <div class="text-sm text-slate-600 mt-1">Yuk mulai belanja dari menu yang tersedia.</div>
            <a href="<?= site_url('/') ?>" class="mt-4 inline-flex items-center justify-center px-4 py-2 rounded-xl text-white font-semibold
                bg-gradient-to-r from-orange-600 to-rose-600 hover:opacity-95">
                Lihat Menu
            </a>
        </div>
    <?php else: ?>

        <div class="bg-white border rounded-2xl overflow-hidden">
            <div class="hidden sm:grid grid-cols-12 gap-2 px-4 py-3 bg-slate-50 text-xs font-semibold text-slate-600">
                <div class="col-span-4">Kode / Tanggal</div>
                <div class="col-span-3">Total</div>
                <div class="col-span-3">Status</div>
                <div class="col-span-2 text-right">Aksi</div>
            </div>

            <?php foreach ($orders as $o): ?>
                <?php
                $code = $o['order_code'] ?? ($o['code'] ?? ($o['invoice'] ?? '-'));
                $date = $o['created_at'] ?? ($o['createdAt'] ?? '');
                $total = (int) ($o['total'] ?? ($o['total_price'] ?? 0));
                $status = strtoupper((string) ($o['status'] ?? ''));
                $detail = site_url('order/' . $code);

                $badge = 'bg-slate-100 text-slate-700';
                if (in_array($status, ['MENUNGGU', 'PENDING']))
                    $badge = 'bg-amber-100 text-amber-800';
                if (in_array($status, ['DIPROSES', 'PROCESS']))
                    $badge = 'bg-blue-100 text-blue-800';
                if (in_array($status, ['SELESAI', 'DONE']))
                    $badge = 'bg-green-100 text-green-800';
                if (in_array($status, ['BATAL', 'CANCEL', 'DIBATALKAN']))
                    $badge = 'bg-rose-100 text-rose-800';
                ?>

                <div class="grid grid-cols-1 sm:grid-cols-12 gap-2 px-4 py-4 border-t">
                    <div class="sm:col-span-4">
                        <div class="font-semibold text-slate-900">
                            <?= esc($code) ?>
                        </div>
                        <div class="text-xs text-slate-500 mt-1">
                            <?= esc($date) ?>
                        </div>
                    </div>

                    <div class="sm:col-span-3 flex items-center">
                        <div class="font-bold">Rp
                            <?= number_format($total, 0, ',', '.') ?>
                        </div>
                    </div>

                    <div class="sm:col-span-3 flex items-center">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold <?= $badge ?>">
                            <?= esc($status ?: '—') ?>
                        </span>
                    </div>

                    <div class="sm:col-span-2 flex sm:justify-end items-center gap-2">
                        <a href="<?= $detail ?>"
                            class="inline-flex items-center gap-2 text-sm px-3 py-2 rounded-xl border bg-white hover:bg-slate-50">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                            Detail
                        </a>
                        <a href="<?= site_url('order/' . $code . '/wa') ?>"
                            class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-green-600 hover:bg-green-700 text-white"
                            title="Chat WA">
                            <i data-lucide="message-circle" class="w-5 h-5"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

</div>

<?= $this->endSection() ?>