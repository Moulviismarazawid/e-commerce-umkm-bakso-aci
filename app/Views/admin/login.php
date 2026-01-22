<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Admin Login</title>
</head>

<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md bg-white border rounded-xl p-5">
            <h1 class="text-xl font-bold mb-4">Login Admin</h1>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="mb-3 p-3 rounded bg-red-50 text-red-700">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>

            <form method="post" action="/admin/login" class="space-y-3">
                <?= csrf_field() ?>
                <div>
                    <label class="text-sm text-gray-600">Email</label>
                    <input name="email" class="w-full border rounded-lg p-2" required>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Password</label>
                    <input type="password" name="password" class="w-full border rounded-lg p-2" required>
                </div>
                <button class="w-full bg-black text-white rounded-lg py-2">Login</button>
            </form>
        </div>
    </div>
</body>

</html>