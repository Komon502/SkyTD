<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตั้งค่าระบบ - SkyTrade Admin</title>
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
    <?php $activePage = 'settings'; include __DIR__ . '/partials/navbar.php'; ?>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 min-h-screen">
        <!-- Page Header -->
        <div class="bg-gradient-to-r from-sky-500 to-blue-600 rounded-lg p-6 mb-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-2">ตั้งค่าระบบ</h2>
                    <p class="opacity-90">จัดการการตั้งค่าและการกำหนดค่าของระบบ</p>
                </div>
                <svg class="w-12 h-12 opacity-30" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58a.49.49 0 00.12-.61l-1.92-3.32a.488.488 0 00-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54a.484.484 0 00-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.05.3-.07.62-.07.94s.02.64.07.94l-2.03 1.58a.49.49 0 00-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"></path>
                </svg>
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

        <!-- Settings Sections -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- General Settings -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c-.94 1.543-.826 3.31.826 2.37a1.724 1.724 0 00-2.572 1.065c-.426-1.756-2.924-1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c.94-1.543.826-3.31-.826-2.37a1.724 1.724 0 002.572-1.065z"></path>
                    </svg>
                    การตั้งค่าทั่วไป
                </h3>
                
                <form method="POST" class="space-y-4">
                    <input type="hidden" name="action" value="general_settings">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">ชื่อเว็บไซต์</label>
                        <input type="text" name="site_name" value="SkyTrade" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">อีเมลติดต่อ</label>
                        <input type="email" name="contact_email" value="admin@skytrade.com" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">สถานะระบบ</label>
                        <select name="site_status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                            <option value="online">ออนไลน์</option>
                            <option value="maintenance">บำรุงัตร</option>
                            <option value="offline">ออฟไลน์</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="w-full bg-sky-600 text-white py-2 px-4 rounded-lg hover:bg-sky-700 transition duration-200">
                        บันทึกการตั้งค่าทั่วไป
                    </button>
                </form>
            </div>

            <!-- Trading Settings -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    การตั้งค่าการเทรด
                </h3>
                
                <form method="POST" class="space-y-4">
                    <input type="hidden" name="action" value="trading_settings">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">ยอดเงินขั้นต่ำ (USD)</label>
                        <input type="number" name="min_trade_amount" value="10" step="0.01" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">ยอดเงินสูงสุด (USD)</label>
                        <input type="number" name="max_trade_amount" value="10000" step="0.01" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">เลเวอร์เริ่มต้น (%)</label>
                        <input type="number" name="default_leverage" value="100" step="10" min="1" max="1000" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">สเปรด (Pips)</label>
                        <input type="number" name="default_spread" value="2" step="0.1" min="0.1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                    </div>
                    
                    <button type="submit" class="w-full bg-sky-600 text-white py-2 px-4 rounded-lg hover:bg-sky-700 transition duration-200">
                        บันทึกการตั้งค่าการเทรด
                    </button>
                </form>
            </div>

            <!-- Deposit Settings -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    การตั้งค่าการฝากเงิน
                </h3>
                
                <form method="POST" class="space-y-4">
                    <input type="hidden" name="action" value="deposit_settings">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">ยอดเงินฝากขั้นต่ำ (USD)</label>
                        <input type="number" name="min_deposit" value="10" step="0.01" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">ยอดเงินฝากสูงสุด (USD)</label>
                        <input type="number" name="max_deposit" value="50000" step="0.01" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">ค่าธรรมเนียมฝากเงิน (%)</label>
                        <input type="number" name="deposit_fee" value="0" step="0.1" min="0" max="10" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                    </div>
                    
                    <button type="submit" class="w-full bg-sky-600 text-white py-2 px-4 rounded-lg hover:bg-sky-700 transition duration-200">
                        บันทึกการตั้งค่าการฝากเงิน
                    </button>
                </form>
            </div>

            <!-- Withdrawal Settings -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    การตั้งค่าการถอนเงิน
                </h3>
                
                <form method="POST" class="space-y-4">
                    <input type="hidden" name="action" value="withdrawal_settings">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">ยอดเงินถอนขั้นต่ำ (USD)</label>
                        <input type="number" name="min_withdrawal" value="10" step="0.01" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">ยอดเงินถอนสูงสุด (USD)</label>
                        <input type="number" name="max_withdrawal" value="50000" step="0.01" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">ค่าธรรมเนียมถอนเงิน (%)</label>
                        <input type="number" name="withdrawal_fee" value="2" step="0.1" min="0" max="10" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">ต้องการอนุมัติการถอนเงิน</label>
                        <select name="withdrawal_approval" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                            <option value="auto">อนุมัติอัตโนมัติ</option>
                            <option value="manual">ต้องอนุมัติด้วย</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="w-full bg-sky-600 text-white py-2 px-4 rounded-lg hover:bg-sky-700 transition duration-200">
                        บันทึกการตั้งค่าการถอนเงิน
                    </button>
                </form>
            </div>
        </div>

        <!-- System Information -->
        <div class="mt-8 bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                    ข้อมูลระบบ
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-sky-600">v1.0.0</div>
                    <div class="text-sm text-gray-600">เวอร์ชั่นระบบ</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600">ออนไลน์</div>
                    <div class="text-sm text-gray-600">สถานะเซิร์ฟเวอร์</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600">PHP 8.1</div>
                    <div class="text-sm text-gray-600">เวอร์ชั่น PHP</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-purple-600">MySQL 8.0</div>
                    <div class="text-sm text-gray-600">เวอร์ชั่นฐานข้อมูล</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Form submission handling
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const action = formData.get('action');
                
                // Show loading state
                const submitButton = this.querySelector('button[type="submit"]');
                const originalText = submitButton.textContent;
                submitButton.textContent = 'กำลังบันทึก...';
                submitButton.disabled = true;
                
                // Simulate form submission (replace with actual AJAX call)
                setTimeout(() => {
                    // Show success message
                    const successDiv = document.createElement('div');
                    successDiv.className = 'bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6';
                    successDiv.innerHTML = `
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            บันทึกการตั้งค่าสำเร็จ!
                        </div>
                    `;
                    
                    // Insert success message after the first h2
                    const h2 = document.querySelector('h2');
                    h2.parentNode.insertBefore(successDiv, h2.nextSibling);
                    
                    // Reset button
                    submitButton.textContent = originalText;
                    submitButton.disabled = false;
                    
                    // Remove success message after 3 seconds
                    setTimeout(() => {
                        successDiv.remove();
                    }, 3000);
                }, 1000);
            });
        });
    </script>
</body>
</html>
