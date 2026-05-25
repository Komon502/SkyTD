<!DOCTYPE html>
<html lang="th">
<head>
    <?php $title = '404 - ไม่พบหน้า'; include __DIR__ . '/../partials/head.php'; ?>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center px-4">
    <div class="max-w-2xl mx-auto text-center">
        <h1 class="text-6xl font-bold text-sky-600 mb-4">404</h1>
        <h2 class="text-3xl font-bold text-gray-900 mb-2">ไม่พบหน้านี้</h2>
        <p class="text-gray-600 mb-6">หน้าที่คุณกำลังมองหาไม่มีอยู่จริง</p>

        <div class="flex gap-4 justify-center mb-6">
            <a href="/" class="inline-flex items-center px-6 py-3 bg-sky-600 text-white rounded-lg">กลับหน้าหลัก</a>
            <a href="/trade" class="inline-flex items-center px-6 py-3 border border-sky-600 text-sky-600 rounded-lg">เทรดต่อ</a>
        </div>

        <form action="/" method="GET" class="max-w-md mx-auto">
            <div class="flex">
                <input type="text" name="search" placeholder="ค้นหา..." class="flex-1 px-4 py-2 border rounded-l-lg focus:ring-2 focus:ring-sky-500">
                <button type="submit" class="bg-sky-600 text-white px-4 rounded-r-lg">ค้นหา</button>
            </div>
        </form>
    </div>
</body>
</html>
