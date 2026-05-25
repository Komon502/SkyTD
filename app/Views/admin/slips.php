<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตรวจสอบสลิป - SkyTrade Admin</title>
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
    <?php $activePage = 'slips'; include __DIR__ . '/partials/navbar.php'; ?>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="bg-gradient-to-r from-sky-500 to-blue-600 rounded-lg p-6 mb-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-2">ตรวจสอบสลิปการโอนเงิน</h2>
                    <p class="opacity-90">อนุมัติหรือปฏิเสธสลิปการโอนเงินจากผู้ใช้</p>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold"><?php echo count($pendingSlips); ?></div>
                    <div class="text-sm opacity-75">รอการตรวจสอบ</div>
                </div>
            </div>
        </div>

        <?php if (isset($success)): ?>
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">รายการสลิปที่รอตรวจสอบ</h2>
                    <span class="text-sm text-gray-500"><?php echo count($pendingSlips); ?> รายการ</span>
                </div>
            </div>
            
            <?php if (!empty($pendingSlips)): ?>
                <div class="divide-y divide-gray-200">
                    <?php foreach ($pendingSlips as $slip): ?>
                        <div class="p-6">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Slip Info -->
                                <div>
                                    <div class="flex items-center justify-between mb-4">
                                        <h3 class="text-lg font-medium text-gray-900">
                                            คำร้อง #<?php echo $slip->id; ?> - <?php echo htmlspecialchars($slip->username); ?>
                                        </h3>
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            รอตรวจสอบ
                                        </span>
                                    </div>
                                    
                                    <div class="space-y-3">
                                        <div class="flex justify-between">
                                            <span class="text-sm font-medium text-gray-500">จำนวนเงิน:</span>
                                            <span class="text-sm font-semibold text-gray-900">฿<?php echo number_format($slip->amount, 2); ?></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-sm font-medium text-gray-500">ธนาคาร:</span>
                                            <span class="text-sm text-gray-900"><?php echo htmlspecialchars($slip->bank_name); ?></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-sm font-medium text-gray-500">วันเวลาโอน:</span>
                                            <span class="text-sm text-gray-900"><?php echo date('d/m/Y H:i', strtotime($slip->transaction_time)); ?></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-sm font-medium text-gray-500">สร้างคำร้อง:</span>
                                            <span class="text-sm text-gray-900"><?php echo date('d/m/Y H:i:s', strtotime($slip->created_at)); ?></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Slip Image & Actions -->
                                <div>
                                    <div class="mb-4">
                                        <h4 class="text-sm font-medium text-gray-700 mb-2">รูปสลิปการโอนเงิน</h4>
                                        <?php if ($slip->slip_image): ?>
                                            <div class="border rounded-lg overflow-hidden">
                                                <img src="/<?php echo htmlspecialchars($slip->slip_image); ?>" 
                                                     alt="Slip Image" 
                                                     class="w-full h-48 object-cover cursor-pointer"
                                                     onclick="window.open('/<?php echo htmlspecialchars($slip->slip_image); ?>', '_blank')">
                                            </div>
                                            <p class="text-xs text-gray-500 mt-1">คลิกเพื่อดูรูปขนาดใหญ่</p>
                                        <?php else: ?>
                                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                <p class="mt-2 text-sm text-gray-500">ไม่พบรูปสลิป</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- Action Form -->
                                    <form action="/admin/slips" method="POST" class="space-y-3">
                                        <input type="hidden" name="slip_id" value="<?php echo $slip->id; ?>">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">หมายเหตุ (ถ้ามี)</label>
                                            <textarea name="admin_notes" rows="3" 
                                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-sky-500 focus:border-sky-500"
                                                      placeholder="กรอกหมายเหตุสำหรับการอนุมัติหรือปฏิเสธ..."></textarea>
                                        </div>
                                        <div class="flex space-x-3">
                                            <button type="submit" name="slip_action" value="approve" 
                                                    class="flex-1 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                                                ✅ อนุมัติ
                                            </button>
                                            <button type="submit" name="slip_action" value="reject" 
                                                    class="flex-1 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                                                ❌ ปฏิเสธ
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">ไม่มีสลิปที่รอการตรวจสอบ</h3>
                    <p class="text-gray-500">ทุกสลิปได้รับการตรวจสอบเรียบร้อยแล้ว</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
