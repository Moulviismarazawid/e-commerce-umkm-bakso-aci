<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Register Admin</title>
</head>

<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md bg-white border rounded-xl p-5">
            <h1 class="text-xl font-bold mb-4">Register Admin</h1>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="mb-3 p-3 rounded bg-red-50 text-red-700">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('success')): ?>
                <div class="mb-3 p-3 rounded bg-green-50 text-green-700">
                    <?= esc(session()->getFlashdata('success')) ?>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= site_url('admin/register') ?>" class="space-y-3">
                <?= csrf_field() ?>

                <div>
                    <label class="text-sm text-gray-600">Nama</label>
                    <input name="name" value="<?= esc(old('name')) ?>" class="w-full border rounded-lg p-2" required>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Email</label>
                    <input name="email" value="<?= esc(old('email')) ?>" class="w-full border rounded-lg p-2" required>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Password</label>
                    <input type="password" name="password" class="w-full border rounded-lg p-2" required>
                </div>

                <button class="w-full bg-black text-white rounded-lg py-2">Buat Admin</button>
            </form>

            <p class="text-sm text-gray-600 mt-3">
                Sudah punya akun? <a class="underline" href="<?= site_url('admin/login') ?>">Login Admin</a>
            </p>
        </div>
    </div>
</body>

</html>