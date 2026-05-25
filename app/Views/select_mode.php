<!-- select_mode.php: เลือกโหมด Demo/Real -->
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เลือกโหมด | SkyTrade</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-blue-50 min-h-screen flex items-start justify-center">
    <?php include __DIR__ . '/partials/user_navbar.php'; ?>
    <div class="bg-white rounded shadow p-8 max-w-md w-full mt-20">
        <h1 class="text-2xl font-bold text-blue-600 mb-6">เลือกโหมดการเทรด</h1>
        <form method="post" action="/select-mode" class="space-y-4">
            <button name="mode" value="demo" class="w-full bg-blue-400 hover:bg-blue-500 text-white py-2 rounded">Demo</button>
            <button name="mode" value="real" class="w-full bg-gray-400 hover:bg-gray-500 text-white py-2 rounded">Real</button>
        </form>
        <div class="mt-4 text-center">
            <a href="/dashboard" class="text-blue-500 hover:underline">กลับหน้าหลัก</a>
        </div>
    </div>
</body>
</html>
