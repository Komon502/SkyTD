<?php
/** @var object $currentUser */
/** @var object $stats */
/** @var array $volumeChart */
/** @var array $userChart */
/** @var array $recentTrades */
/** @var array $recentUsers */
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <?php $title = 'แดชบอร์ดแอดมิน - SkyTrade'; include __DIR__ . '/../partials/head.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-50">
    <?php $activePage = 'dashboard'; include __DIR__ . '/partials/navbar.php'; ?>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 min-h-screen">
        <!-- Welcome Section -->
        <div class="bg-gradient-to-r from-sky-500 to-blue-600 rounded-lg p-6 mb-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-2">ข้อมูลรับรองระบบ</h2>
                    <p class="opacity-90">จัดการระบบ SkyTrade ของคุณได้อย่างมืออาชีพ</p>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold"><?php echo date('d/m/Y H:i'); ?></div>
                    <div class="text-sm opacity-75">เวลาปัจจุบัน</div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-sky-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-500">Users</div>
                        <div class="text-2xl font-bold text-gray-900"><?php echo number_format($stats->total_users); ?></div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1a1 1 0 11-2 0v-1a1 1 0 012 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-500">Total Amount</div>
                        <div class="text-2xl font-bold text-gray-900">฿<?php echo number_format($stats->total_balance, 2); ?></div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-500">Transactions</div>
                        <div class="text-2xl font-bold text-gray-900"><?php echo number_format($stats->today_trades); ?></div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-500">Pending</div>
                        <div class="text-2xl font-bold text-gray-900"><?php echo number_format($stats->pending_slips); ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Trading Volume Chart -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">ปริมาณการขาย (7 วันล่าสุด)</h3>
                <div class="relative" style="height: 300px;">
                    <canvas id="volumeChart"></canvas>
                </div>
            </div>

            <!-- User Growth Chart -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">ผู้ใช้งาน (7 วันล่าสุด)</h3>
                <div class="relative" style="height: 300px;">
                    <canvas id="userChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Trades -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">การเทรดล่าสุด</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <?php if (!empty($recentTrades)): ?>
                            <?php foreach ($recentTrades as $trade): ?>
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center">
                                        <div class="w-2 h-2 rounded-full mr-3 <?php echo $trade->result === 'win' ? 'bg-green-500' : ($trade->result === 'lose' ? 'bg-red-500' : 'bg-yellow-500'); ?>"></div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($trade->username ?? 'N/A'); ?></div>
                                            <div class="text-xs text-gray-500"><?php echo htmlspecialchars($trade->symbol ?? 'N/A'); ?> • <?php echo number_format($trade->amount ?? 0); ?> บาท</div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm font-medium <?php echo $trade->result === 'win' ? 'text-green-600' : ($trade->result === 'lose' ? 'text-red-600' : 'text-yellow-600'); ?>">
                                            <?php 
                                            if ($trade->result === 'win') {
                                                echo '+' . number_format($trade->profit_loss ?? 0, 2);
                                            } elseif ($trade->result === 'lose') {
                                                echo '-' . number_format(abs($trade->profit_loss ?? 0), 2);
                                            } else {
                                                echo 'รอดำเนินการ';
                                            }
                                            ?>
                                        </div>
                                        <div class="text-xs text-gray-500"><?php echo date('H:i', strtotime($trade->created_at ?? 'now')); ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center py-8 text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <p>ไม่มีข้อมูลการเทรด</p>
                                <p class="text-xs mt-1">การเทรดทั้งหมดจะแสดงที่นี่</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="mt-4 text-center">
                        <a href="/admin/trades" class="text-sky-600 hover:text-sky-500 text-sm font-medium">ดูทั้งหมด →</a>
                    </div>
                </div>
            </div>

            <!-- Recent Users -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">ผู้ใช้ใหม่ล่าสุด</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <?php if (!empty($recentUsers)): ?>
                            <?php foreach ($recentUsers as $user): ?>
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-sky-100 rounded-full flex items-center justify-center mr-3">
                                            <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($user->username ?? 'N/A'); ?></div>
                                            <div class="text-xs text-gray-500"><?php echo htmlspecialchars($user->email ?? 'N/A'); ?></div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm font-medium text-gray-900">฿<?php echo number_format(($user->balance ?? 0) + ($user->demo_balance ?? 0), 2); ?></div>
                                        <div class="text-xs text-gray-500"><?php echo date('d/m/Y', strtotime($user->created_at ?? 'now')); ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center py-8 text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h.01M12 9v3m0 0v3m0-3h.01M6 9v3m0 0v3m0-3h.01M6 15h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                                <p>ไม่มีผู้ใช้ใหม่</p>
                                <p class="text-xs mt-1">ผู้ใช้ใหม่ทั้งหมดจะแสดงที่นี่</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="mt-4 text-center">
                        <a href="/admin/users" class="text-sky-600 hover:text-sky-500 text-sm font-medium">จัดการผู้ใช้ →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Scripts -->
    <script>
        // Trading Volume Chart
        const volumeCtx = document.getElementById('volumeChart').getContext('2d');
        const volumeData = <?php echo json_encode($volumeChart['data']); ?>;
        const volumeLabels = <?php echo json_encode($volumeChart['labels']); ?>;
        
        new Chart(volumeCtx, {
            type: 'line',
            data: {
                labels: volumeLabels,
                datasets: [{
                    label: 'ปริมาณการขาย',
                    data: volumeData,
                    borderColor: 'rgb(6, 182, 212)',
                    backgroundColor: 'rgba(6, 182, 212, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: volumeData.every(val => val === 0) ? 0 : 4,
                    pointBackgroundColor: 'rgb(6, 182, 212)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'ปริมาณ: ฿' + context.parsed.y.toLocaleString('th-TH', {minimumFractionDigits: 2});
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '฿' + value.toLocaleString('th-TH');
                            }
                        }
                    }
                }
            }
        });

        // User Growth Chart
        const userCtx = document.getElementById('userChart').getContext('2d');
        const userData = <?php echo json_encode($userChart['data']); ?>;
        const userLabels = <?php echo json_encode($userChart['labels']); ?>;
        
        new Chart(userCtx, {
            type: 'bar',
            data: {
                labels: userLabels,
                datasets: [{
                    label: 'ผู้ใช้งาน',
                    data: userData,
                    backgroundColor: userData.every(val => val === 0) ? 'rgba(156, 163, 175, 0.5)' : 'rgba(6, 182, 212, 0.8)',
                    borderColor: userData.every(val => val === 0) ? 'rgba(156, 163, 175, 0.8)' : 'rgb(6, 182, 212)',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'ผู้ใช้ใหม่: ' + context.parsed.y + ' คน';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            callback: function(value) {
                                return Math.floor(value) + ' คน';
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
