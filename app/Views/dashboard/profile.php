<!DOCTYPE html>
<html lang="th">
<head>
    <?php $title = 'โปรไฟล์ - SkyTrade'; include __DIR__ . '/../partials/head.php'; ?>
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
            <!-- Profile Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">ข้อมูลส่วนตัว</h2>
                    
                    <form action="/profile" method="POST" class="space-y-6">
                        <!-- Username (Readonly) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">ชื่อผู้ใช้</label>
                            <input type="text" value="<?php echo htmlspecialchars($currentUser->username); ?>" readonly
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-500">
                            <p class="text-xs text-gray-500 mt-1">ไม่สามารถแก้ไขชื่อผู้ใช้ได้</p>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">อีเมล</label>
                            <input type="email" id="email" name="email" 
                                   value="<?php echo htmlspecialchars($currentUser->email); ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-sky-500 focus:border-sky-500"
                                   placeholder="example@email.com">
                        </div>

                        <!-- Password Change -->
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">เปลี่ยนรหัสผ่าน</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">รหัสผ่านปัจจุบัน</label>
                                    <input type="password" id="current_password" name="current_password"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-sky-500 focus:border-sky-500"
                                           placeholder="กรอกรหัสผ่านปัจจุบัน">
                                </div>
                                
                                <div>
                                    <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">รหัสผ่านใหม่</label>
                                    <input type="password" id="new_password" name="new_password" minlength="6"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-sky-500 focus:border-sky-500"
                                           placeholder="อย่างน้อย 6 ตัวอักษร">
                                </div>
                                
                                <div>
                                    <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">ยืนยันรหัสผ่านใหม่</label>
                                    <input type="password" id="confirm_password" name="confirm_password" minlength="6"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-sky-500 focus:border-sky-500"
                                           placeholder="กรอกรหัสผ่านใหม่อีกครั้ง">
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-4">
                            <a href="/dashboard" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                                ยกเลิก
                            </a>
                            <button type="submit" 
                                    class="bg-sky-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-sky-700 transition">
                                บันทึกข้อมูล
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Side Panel -->
            <div class="space-y-6">
                <!-- Account Info -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">ข้อมูลบัญชี</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">สถานะ</span>
                            <span class="px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                ใช้งานได้
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">ประเภท</span>
                            <span class="px-2 py-1 rounded-full text-xs font-medium <?php echo $currentUser->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800'; ?>">
                                <?php echo $currentUser->role === 'admin' ? 'แอดมิน' : 'ผู้ใช้'; ?>
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">สมัครเมื่อ</span>
                            <span class="text-sm"><?php echo date('d/m/Y', strtotime($currentUser->created_at)); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">อัตราชนะ</span>
                            <span class="text-sm font-medium"><?php echo number_format($currentUser->win_rate * 100, 1); ?>%</span>
                        </div>
                    </div>
                </div>

                <!-- Balance Summary -->
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
                    <div class="mt-4 pt-4 border-t space-y-2">
                        <a href="/deposit" class="block w-full bg-green-600 text-white text-center py-2 px-4 rounded-lg hover:bg-green-700 transition">
                            เติมเงิน
                        </a>
                        <a href="/trade" class="block w-full bg-sky-600 text-white text-center py-2 px-4 rounded-lg hover:bg-sky-700 transition">
                            เริ่มเทรด
                        </a>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">สถิติการเทรด</h3>
                    <?php
                    $tradeStats = Trade::getUserStats($currentUser->id);
                    if ($tradeStats && $tradeStats->total_trades > 0):
                    ?>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">การเทรดทั้งหมด</span>
                                <span class="font-semibold"><?php echo $tradeStats->total_trades; ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">ชนะ</span>
                                <span class="font-semibold text-green-600"><?php echo $tradeStats->wins; ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">แพ้</span>
                                <span class="font-semibold text-red-600"><?php echo $tradeStats->losses; ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">กำไร/ขาดทุน</span>
                                <span class="font-semibold <?php echo ($tradeStats->total_profit_loss ?? 0) >= 0 ? 'text-green-600' : 'text-red-600'; ?>">
                                    ฿<?php echo number_format($tradeStats->total_profit_loss ?? 0, 2); ?>
                                </span>
                            </div>
                        </div>
                    <?php else: ?>
                        <p class="text-gray-500 text-sm">ยังไม่มีประวัติการเทรด</p>
                    <?php endif; ?>
                </div>

                <!-- Security Tips -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h3 class="font-semibold text-blue-900 mb-2">💡 เคล็ดลับความปลอดภัย</h3>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>• เปลี่ยนรหัสผ่านเป็นประจำ</li>
                        <li>• ไม่แชร์ข้อมูลบัญชี</li>
                        <li>• ตรวจสอบประวัติการเทรด</li>
                        <li>• ติดต่อแอดมินหากสงสัย</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Password strength indicator
        document.getElementById('new_password').addEventListener('input', function(e) {
            const password = e.target.value;
            const strength = checkPasswordStrength(password);
            
            // You can add visual feedback here if needed
            console.log('Password strength:', strength);
        });

        function checkPasswordStrength(password) {
            if (password.length < 6) return 'weak';
            if (password.length < 10) return 'medium';
            if (password.match(/[a-z]/) && password.match(/[A-Z]/) && password.match(/[0-9]/)) return 'strong';
            return 'medium';
        }

        // Confirm password validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (newPassword && newPassword !== confirmPassword) {
                e.preventDefault();
                alert('รหัสผ่านใหม่ไม่ตรงกัน กรุณาตรวจสอบอีกครั้ง');
            }
        });
    </script>
</body>
</html>
