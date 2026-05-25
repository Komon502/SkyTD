<!DOCTYPE html>
<html lang="th">
<head>
    <?php $title = 'สมัครสมาชิก - SkyTrade'; include __DIR__ . '/../partials/head.php'; ?>
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
<body class="bg-gradient-to-br from-sky-50 to-gray-100 min-h-screen flex items-center justify-center py-12">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-xl shadow-lg">
        <div>
            <div class="text-center">
                <h1 class="text-3xl font-bold text-sky-600">SkyTrade</h1>
                <h2 class="mt-6 text-2xl font-semibold text-gray-900">สมัครสมาชิก</h2>
                <p class="mt-2 text-sm text-gray-600">
                    หรือ <a href="/login" class="text-sky-600 hover:text-sky-500">เข้าสู่ระบบ</a>
                </p>
            </div>
        </div>

        <?php if (isset($errors) && !empty($errors)): ?>
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                <ul class="list-disc list-inside space-y-1">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form class="mt-8 space-y-6" action="/register/post" method="POST">
            <div class="space-y-4">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">ชื่อผู้ใช้</label>
                    <input id="username" name="username" type="text" required
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500"
                           placeholder="กรุณากรอกชื่อผู้ใช้">
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">อีเมล</label>
                    <input id="email" name="email" type="email" required
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500"
                           placeholder="example@email.com">
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">รหัสผ่าน</label>
                    <input id="password" name="password" type="password" required minlength="6"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500"
                           placeholder="อย่างน้อย 6 ตัวอักษร">
                </div>
                
                <div>
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700">ยืนยันรหัสผ่าน</label>
                    <input id="confirm_password" name="confirm_password" type="password" required minlength="6"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500"
                           placeholder="กรอกรหัสผ่านอีกครั้ง">
                </div>
            </div>

            <div class="flex items-center">
                <input id="terms" name="terms" type="checkbox" required
                       class="h-4 w-4 text-sky-600 focus:ring-sky-500 border-gray-300 rounded">
                <label for="terms" class="ml-2 block text-sm text-gray-700">
                    ฉันยอมรับ <a href="#" class="text-sky-600 hover:text-sky-500">เงื่อนไขการใช้งาน</a> และ <a href="#" class="text-sky-600 hover:text-sky-500">นโยบายความเป็นส่วนตัว</a>
                </label>
            </div>

            <div>
                <button type="submit" 
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition">
                    สมัครสมาชิก
                </button>
            </div>

            <div class="text-center">
                <a href="/" class="text-sm text-gray-600 hover:text-sky-600">
                    ← กลับหน้าหลัก
                </a>
            </div>
        </form>
    </div>

    <script>
        // ตรวจสอบว่ารหัสผ่านตรงกัน
        document.querySelector('form').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('รหัสผ่านไม่ตรงกัน กรุณาตรวจสอบอีกครั้ง');
            }
        });
    </script>
</body>
</html>
