<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แดชบอร์ด - SkyTrade</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        sky: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50">
    <?php
    $currentUser = $user;
    $activePage = 'dashboard';
    include __DIR__ . '/../partials/user_navbar.php';
    ?>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-3 bg-sky-100 rounded-lg">
                        <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">ยอดเงินจริง</p>
                        <p class="text-xl font-semibold text-gray-900">฿<?php echo number_format($real_balance, 2); ?></p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">ยอดเงิน Demo</p>
                        <p class="text-xl font-semibold text-gray-900">฿<?php echo number_format($demo_balance, 2); ?></p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">การเทรดทั้งหมด</p>
                        <p class="text-xl font-semibold text-gray-900"><?php echo $trade_stats->total_trades ?? 0; ?></p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">อัตราชนะ</p>
                        <p class="text-xl font-semibold text-gray-900">
                            <?php 
                            $total = ($trade_stats->wins ?? 0) + ($trade_stats->losses ?? 0);
                            $win_rate = $total > 0 ? (($trade_stats->wins ?? 0) / $total) * 100 : 0;
                            echo number_format($win_rate, 1) . '%';
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">ดำเนินการเร็ว</h2>
                <div class="space-y-3">
                    <a href="/trade" class="block w-full bg-sky-600 text-white text-center py-2 px-4 rounded-lg hover:bg-sky-700 transition">
                        เริ่มเทรด
                    </a>
                    <a href="/deposit" class="block w-full bg-green-600 text-white text-center py-2 px-4 rounded-lg hover:bg-green-700 transition">
                        เติมเงิน
                    </a>
                    <a href="/trade/select-mode" class="block w-full bg-gray-600 text-white text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition">
                        เปลี่ยนโหมด (Demo/Real)
                    </a>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">การเทรดล่าสุด</h2>
                <?php if (!empty($recent_trades)): ?>
                    <div class="space-y-2">
                        <?php foreach (array_slice($recent_trades, 0, 5) as $trade): ?>
                            <div class="flex justify-between items-center p-2 border-b">
                                <div>
                                    <span class="text-sm font-medium"><?php echo htmlspecialchars($trade->symbol); ?></span>
                                    <span class="text-xs text-gray-500 ml-2"><?php echo date('H:i', strtotime($trade->created_at)); ?></span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="text-xs px-2 py-1 rounded <?php echo $trade->direction === 'up' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                                        <?php echo $trade->direction === 'up' ? '↑' : '↓'; ?>
                                    </span>
                                    <span class="text-xs px-2 py-1 rounded <?php echo $trade->result === 'win' ? 'bg-green-100 text-green-800' : ($trade->result === 'lose' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'); ?>">
                                        <?php echo $trade->result === 'win' ? 'ชนะ' : ($trade->result === 'lose' ? 'แพ้' : 'รอดำเนินการ'); ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-500 text-sm">ยังไม่มีประวัติการเทรด</p>
                <?php endif; ?>
                <div class="mt-4">
                    <a href="/trade/history" class="text-sky-600 hover:text-sky-500 text-sm">ดูทั้งหมด →</a>
                </div>
            </div>
        </div>

        <!-- Pending Trades -->
        <?php if (!empty($pending_trades)): ?>
            <div class="bg-white p-6 rounded-lg shadow mb-8">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">การเทรดที่กำลังดำเนินการ</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <?php foreach ($pending_trades as $trade): ?>
                        <div class="border rounded-lg p-4">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h3 class="font-medium"><?php echo htmlspecialchars($trade->symbol); ?></h3>
                                    <p class="text-sm text-gray-500"><?php echo htmlspecialchars($trade->name); ?></p>
                                </div>
                                <span class="text-xs px-2 py-1 rounded <?php echo $trade->direction === 'up' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                                    <?php echo $trade->direction === 'up' ? 'ขึ้น' : 'ลง'; ?>
                                </span>
                            </div>
                            <div class="text-sm text-gray-600">
                                <p>จำนวน: ฿<?php echo number_format($trade->amount, 2); ?></p>
                                <p>ราคาเข้า: <?php echo number_format($trade->entry_price, 5); ?></p>
                                <p>หมดอายุ: <?php echo date('H:i:s', strtotime($trade->expires_at)); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
