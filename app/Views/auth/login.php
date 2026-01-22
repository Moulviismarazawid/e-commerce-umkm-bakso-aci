<?= $this->extend('layouts/shop') ?>
<?= $this->section('content') ?>

<div class="max-w-md mx-auto bg-white border rounded-xl p-5">
    <h1 class="text-xl font-bold mb-4">Login Customer</h1>

    <form method="post" action="/login" class="space-y-3">
        <?= csrf_field() ?>
        <div>
            <label class="text-sm text-gray-600">Nomor WhatsApp</label>
            <input name="phone" value="<?= esc(old('phone')) ?>" class="w-full border rounded-lg p-2"
                placeholder="contoh: 62812xxxx" required>
        </div>
        <div>
            <label class="text-sm text-gray-600">Password</label>
            <input type="password" name="password" class="w-full border rounded-lg p-2" required>
        </div>
        <button class="w-full bg-black text-white rounded-lg py-2">Login</button>
    </form>

    <p class="text-sm text-gray-600 mt-3">
        Belum punya akun? <a href="/register" class="underline">Daftar</a>
    </p>
</div>

<?= $this->endSection() ?>