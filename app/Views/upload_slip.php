<!-- upload_slip.php: อัปโหลดสลิปเติมเงิน -->
<html lang="th">
<head>
    <?php $title = 'อัปโหลดสลิป | SkyTrade'; include __DIR__ . '/partials/head.php'; ?>
</head>
<body class="bg-blue-50 min-h-screen flex items-center justify-center">
    <div class="bg-white rounded shadow p-8 max-w-md w-full">
        <h1 class="text-2xl font-bold text-blue-600 mb-6">อัปโหลดสลิปเติมเงิน</h1>
        <?php if (!empty($error)) : ?>
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 text-center">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($message)) : ?>
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4 text-center">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
        <form method="post" action="/upload-slip" enctype="multipart/form-data" class="space-y-4">
            <input type="file" name="slip" accept="image/*" required class="w-full" />
            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 rounded transition">อัปโหลด</button>
        </form>
        <div class="mt-4 text-center">
            <a href="/dashboard" class="text-blue-500 hover:underline">กลับหน้าหลัก</a>
        </div>
    </div>
</body>
</html>
