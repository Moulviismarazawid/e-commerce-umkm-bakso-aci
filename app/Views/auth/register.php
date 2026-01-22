<?= $this->extend('layouts/shop') ?>
<?= $this->section('content') ?>

<div class="max-w-md mx-auto bg-white border rounded-xl p-5">
    <h1 class="text-xl font-bold mb-4">Daftar Customer</h1>

    <form method="post" action="/register" class="space-y-3">
        <?= csrf_field() ?>
        <div>
            <label class="text-sm text-gray-600">Nama</label>
            <input name="name" value="<?= esc(old('name')) ?>" class="w-full border rounded-lg p-2" required>
        </div>
        <div>
            <label class="text-sm text-gray-600">Nomor WhatsApp</label>
            <input name="phone" value="<?= esc(old('phone')) ?>" class="w-full border rounded-lg p-2"
                placeholder="62812xxxx" required>
        </div>
        <div>
            <label class="text-sm text-gray-600">Email (opsional)</label>
            <input name="email" value="<?= esc(old('email')) ?>" class="w-full border rounded-lg p-2">
        </div>
        <div>
            <label class="text-sm text-gray-600">Alamat (opsional)</label>
            <textarea name="address" class="w-full border rounded-lg p-2" rows="2"><?= esc(old('address')) ?></textarea>
        </div>
        <div>
            <label class="text-sm text-gray-600">Password</label>
            <input type="password" name="password" class="w-full border rounded-lg p-2" required>
        </div>

        <button class="w-full bg-black text-white rounded-lg py-2">Daftar</button>
    </form>

    <p class="text-sm text-gray-600 mt-3">
        Sudah punya akun? <a href="/login" class="underline">Login</a>
    </p>
</div>

<?= $this->endSection() ?>