<!DOCTYPE html>
<html lang="th">
<head>
    <?php $title = 'ฝากเงิน - SkyTrade'; include __DIR__ . '/../partials/head.php'; ?>
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
    <?php include __DIR__ . '/../partials/user_navbar.php'; ?>
        <?php if (isset($success)): ?>
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($errors) && !empty($errors)): ?>
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                <ul class="list-disc list-inside space-y-1">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Deposit Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">เติมเงินเข้าบัญชี</h2>
                    
                    <form action="/deposit" method="POST" enctype="multipart/form-data" class="space-y-6">
                        <!-- Amount Input -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">จำนวนเงิน (บาท)</label>
                            <input type="number" name="amount" min="100" max="100000" step="0.01" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-sky-500 focus:border-sky-500"
                                   placeholder="100.00 - 100,000.00">
                            <p class="text-xs text-gray-500 mt-1">ขั้นต่ำ: ฿100.00 | สูงสุด: ฿100,000.00</p>
                        </div>

                        <!-- Bank Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">ธนาคารที่โอน</label>
                            <select name="bank_name" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-sky-500 focus:border-sky-500">
                                <option value="">-- เลือกธนาคาร --</option>
                                <option value="กสิกรไทย">ธนาคารกสิกรไทย (KBank)</option>
                                <option value="ไทยพาณิชย์">ธนาคารไทยพาณิชย์ (SCB)</option>
                                <option value="กรุงเทพ">ธนาคารกรุงเทพ (BBL)</option>
                                <option value="กรุงไทย">ธนาคารกรุงไทย (KTB)</option>
                                <option value="ทหารไทย">ธนาคารทหารไทยธนชาต (TTB)</option>
                                <option value="ออมสิน">ธนาคารออมสิน (GSB)</option>
                                <option value="อื่นๆ">อื่นๆ</option>
                            </select>
                        </div>

                        <!-- Transaction Time -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">วันและเวลาทำรายการ</label>
                            <input type="datetime-local" name="transaction_time" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-sky-500 focus:border-sky-500">
                            <p class="text-xs text-gray-500 mt-1">กรุณาระบุวันเวลาที่ทำการโอนเงินจริง</p>
                        </div>

                        <!-- Slip Upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">รูปสลิปการโอนเงิน</label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <input type="file" name="slip_image" accept="image/*" required
                                       class="hidden" id="slip-upload">
                                <label for="slip-upload" class="cursor-pointer">
                                    <span class="mt-2 block text-sm font-medium text-gray-900">
                                        คลิกเพื่ออัปโหลดรูปสลิป
                                    </span>
                                    <span class="mt-1 block text-xs text-gray-500">
                                        PNG, JPG, GIF สูงสุด 10MB
                                    </span>
                                </label>
                                <p class="mt-2 text-xs text-gray-500" id="file-name"></p>
                            </div>
                        </div>

                        <!-- Bank Account Info -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h3 class="font-semibold text-blue-900 mb-2">ข้อมูลบัญชีรับเงิน</h3>
                            <div class="space-y-1 text-sm text-blue-800">
                                <p><strong>ธนาคาร:</strong> ธนาคารกสิกรไทย</p>
                                <p><strong>ชื่อบัญชี:</strong> สมชาย ใจดี</p>
                                <p><strong>เลขที่บัญชี:</strong> 123-4-56789-0</p>
                                <p class="text-xs mt-2">** กรุณาโอนเงินพร้อมระบุชื่อผู้ใช้ของคุณในหมายเหตุ **</p>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                                class="w-full bg-green-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-green-700 transition">
                            ส่งหลักฐานการโอนเงิน
                        </button>
                    </form>
                </div>
            </div>

            <!-- Side Panel -->
            <div class="space-y-6">
                <!-- Current Balance -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">ยอดเงินคงเหลือ</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Real Balance</span>
                            <span class="font-semibold">฿<?php echo number_format(User::getBalance($currentUser->id, 'real'), 2); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Demo Balance</span>
                            <span class="font-semibold">฿<?php echo number_format(User::getBalance($currentUser->id, 'demo'), 2); ?></span>
                        </div>
                    </div>
                </div>

                <!-- Deposit Instructions -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">ขั้นตอนการเติมเงิน</h3>
                    <ol class="space-y-3 text-sm text-gray-600">
                        <li class="flex">
                            <span class="flex-shrink-0 w-6 h-6 bg-sky-100 text-sky-600 rounded-full flex items-center justify-center mr-2">1</span>
                            <span>โอนเงินเข้าบัญชีธนาคารที่ระบุ</span>
                        </li>
                        <li class="flex">
                            <span class="flex-shrink-0 w-6 h-6 bg-sky-100 text-sky-600 rounded-full flex items-center justify-center mr-2">2</span>
                            <span>ถ่ายรูปสลิปการโอนเงิน</span>
                        </li>
                        <li class="flex">
                            <span class="flex-shrink-0 w-6 h-6 bg-sky-100 text-sky-600 rounded-full flex items-center justify-center mr-2">3</span>
                            <span>กรอกข้อมูลและอัปโหลดสลิป</span>
                        </li>
                        <li class="flex">
                            <span class="flex-shrink-0 w-6 h-6 bg-sky-100 text-sky-600 rounded-full flex items-center justify-center mr-2">4</span>
                            <span>รอการตรวจสอบจากแอดมิน (5-15 นาที)</span>
                        </li>
                    </ol>
                </div>

                <!-- Recent Deposits -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">การเติมเงินล่าสุด</h3>
                    <?php
                    $recentDeposits = Transaction::getByUser($currentUser->id, 5);
                    $depositTransactions = array_filter($recentDeposits, function($t) {
                        return $t->type === 'deposit';
                    });
                    ?>
                    <?php if (!empty($depositTransactions)): ?>
                        <div class="space-y-2">
                            <?php foreach (array_slice($depositTransactions, 0, 3) as $transaction): ?>
                                <div class="flex justify-between items-center p-2 border-b">
                                    <div>
                                        <span class="text-sm font-medium">฿<?php echo number_format($transaction->amount, 2); ?></span>
                                        <span class="text-xs text-gray-500 ml-2"><?php echo date('d/m H:i', strtotime($transaction->created_at)); ?></span>
                                    </div>
                                    <span class="text-xs px-2 py-1 rounded <?php echo $transaction->status === 'completed' ? 'bg-green-100 text-green-800' : ($transaction->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800'); ?>">
                                        <?php echo $transaction->status === 'completed' ? 'สำเร็จ' : ($transaction->status === 'pending' ? 'รอตรวจสอบ' : 'ปฏิเสธ'); ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-gray-500 text-sm">ยังไม่มีประวัติการเติมเงิน</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        // File upload preview
        document.getElementById('slip-upload').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name || '';
            document.getElementById('file-name').textContent = fileName ? `ไฟล์ที่เลือก: ${fileName}` : '';
        });

        // Set default transaction time to current time
        const now = new Date();
        const localDateTime = new Date(now.getTime() - now.getTimezoneOffset() * 60000)
            .toISOString()
            .slice(0, 16);
        document.querySelector('input[name="transaction_time"]').value = localDateTime;
    </script>
</body>
</html>
