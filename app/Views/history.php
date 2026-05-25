<!-- history.php: ประวัติการเทรด -->
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ประวัติการเทรด | SkyTrade</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-2xl mx-auto mt-10 bg-white rounded shadow p-6">
        <h1 class="text-2xl font-bold text-blue-600 mb-4">ประวัติการเทรด</h1>
        <table class="w-full table-auto border">
            <thead>
                <tr class="bg-blue-100">
                    <th class="p-2">คู่เงิน</th>
                    <th class="p-2">จำนวน</th>
                    <th class="p-2">ทิศทาง</th>
                    <th class="p-2">โหมด</th>
                    <th class="p-2">ผลลัพธ์</th>
                    <th class="p-2">เวลา</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($trades)) : foreach ($trades as $trade) : ?>
                <tr>
                    <td class="p-2 text-center"><?= htmlspecialchars($trade->forex_pair) ?></td>
                    <td class="p-2 text-center"><?= htmlspecialchars($trade->amount) ?></td>
                    <td class="p-2 text-center"><?= htmlspecialchars($trade->direction) ?></td>
                    <td class="p-2 text-center"><?= htmlspecialchars($trade->mode) ?></td>
                    <td class="p-2 text-center <?= $trade->result === 'win' ? 'text-green-600' : 'text-red-600' ?>">
                        <?= $trade->result === 'win' ? 'ชนะ' : 'แพ้' ?>
                    </td>
                    <td class="p-2 text-center"><?= htmlspecialchars($trade->created_at) ?></td>
                </tr>
            <?php endforeach; else: ?>
                <tr><td colspan="6" class="text-center text-gray-400">ไม่มีข้อมูล</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
        <div class="mt-4 text-center">
            <a href="/trade" class="text-blue-500 hover:underline">กลับไปเทรด</a>
        </div>
    </div>
</body>
</html>
