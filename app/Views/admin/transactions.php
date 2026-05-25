<!DOCTYPE html>
<html lang="th">
<head>
    <?php $title = 'ธุรกรรม - SkyTrade Admin'; include __DIR__ . '/../partials/head.php'; ?>
</head>
<body class="bg-gray-50">
    <?php $activePage = 'transactions'; include __DIR__ . '/partials/navbar.php'; ?>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 min-h-screen">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">จัดการธุรกรรม</h2>
                <p class="text-gray-600 mt-1">ดูและจัดการธุรกรรมการเงินทั้งหมดในระบบ</p>
            </div>
        </div>

        <!-- Success/Error Messages -->
        <?php if (!empty($success)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <?php echo $success; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293-1.293a1 1 0 00-1.414 1.414L7.172 11.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <?php echo $error; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Search and Filter -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                <div class="flex-1 max-w-md">
                    <div class="relative">
                        <input type="text" id="searchInput" placeholder="ค้นหาธุรกรรม..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500">
                        <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex space-x-4">
                    <select id="typeFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500">
                        <option value="">ทุกประเภท</option>
                        <option value="deposit">เติมเงิน</option>
                        <option value="withdraw">ถอนเงิน</option>
                        <option value="trade">การเทรด</option>
                        <option value="bonus">โบนัส</option>
                    </select>
                    <select id="statusFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500">
                        <option value="">ทุกสถานะ</option>
                        <option value="completed">สำเร็จ</option>
                        <option value="pending">รอดำเนินการ</option>
                        <option value="failed">ล้มเหลว</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Transactions Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ผู้ใช้</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ประเภท</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">จำนวน</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">คงเหลือ</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">สถานะ</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">รายละเอียด</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">วันที่</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if (!empty($transactions)): ?>
                            <?php foreach ($transactions as $transaction): ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-sky-100 flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($transaction->username ?? 'N/A'); ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php 
                                            if ($transaction->type === 'deposit') echo 'bg-green-100 text-green-800';
                                            elseif ($transaction->type === 'withdraw') echo 'bg-red-100 text-red-800';
                                            elseif ($transaction->type === 'trade') echo 'bg-blue-100 text-blue-800';
                                            else echo 'bg-purple-100 text-purple-800';
                                        ?>">
                                            <?php 
                                            if ($transaction->type === 'deposit') echo 'เติมเงิน';
                                            elseif ($transaction->type === 'withdraw') echo 'ถอนเงิน';
                                            elseif ($transaction->type === 'trade') echo 'การเทรด';
                                            else echo 'โบนัส';
                                            ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium <?php echo ($transaction->amount ?? 0) >= 0 ? 'text-green-600' : 'text-red-600'; ?>">
                                        $<?php echo number_format($transaction->amount ?? 0, 2); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$<?php echo number_format($transaction->balance_after ?? 0, 2); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php 
                                            if ($transaction->status === 'completed') echo 'bg-green-100 text-green-800';
                                            elseif ($transaction->status === 'pending') echo 'bg-yellow-100 text-yellow-800';
                                            else echo 'bg-red-100 text-red-800';
                                        ?>">
                                            <?php 
                                            if ($transaction->status === 'completed') echo 'สำเร็จ';
                                            elseif ($transaction->status === 'pending') echo 'รอดำเนินการ';
                                            else echo 'ล้มเหลว';
                                            ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($transaction->description ?? '-'); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo date('d/m/Y H:i', strtotime($transaction->created_at ?? 'now')); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <p>ไม่พบข้อมูลธุรกรรม</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        // Filter functionality
        document.getElementById('typeFilter').addEventListener('change', filterTable);
        document.getElementById('statusFilter').addEventListener('change', filterTable);

        function filterTable() {
            const typeFilter = document.getElementById('typeFilter').value;
            const statusFilter = document.getElementById('statusFilter').value;
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                if (row.querySelector('td[colspan]')) return; // Skip empty row
                
                const type = row.querySelector('td:nth-child(2)').textContent.trim();
                const status = row.querySelector('td:nth-child(5)').textContent.trim();
                
                const typeMatch = !typeFilter || type.includes(
                    typeFilter === 'deposit' ? 'เติมเงิน' : 
                    (typeFilter === 'withdraw' ? 'ถอนเงิน' : 
                    (typeFilter === 'trade' ? 'การเทรด' : 'โบนัส'))
                );
                const statusMatch = !statusFilter || status.includes(
                    statusFilter === 'completed' ? 'สำเร็จ' : 
                    (statusFilter === 'pending' ? 'รอดำเนินการ' : 'ล้มเหลว')
                );
                
                row.style.display = typeMatch && statusMatch ? '' : 'none';
            });
        }
    </script>
</body>
</html>
