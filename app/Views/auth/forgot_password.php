<!DOCTYPE html>
<html lang="th">
<head>
    <?php $title = 'ลืมรหัสผ่าน - SkyTrade'; include __DIR__ . '/../partials/head.php'; ?>
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
<body class="bg-gradient-to-br from-sky-50 to-gray-100 min-h-screen flex items-start justify-center">
    <?php include __DIR__ . '/../partials/user_navbar.php'; ?>
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-xl shadow-lg mt-20">
        <div>
            <div class="text-center">
                <h1 class="text-3xl font-bold text-sky-600">SkyTrade</h1>
                <h2 class="mt-6 text-2xl font-semibold text-gray-900">เปลี่ยนรหัสผ่านใหม่</h2>
                <p class="mt-2 text-sm text-gray-600">
                    หรือ <a href="/login" class="text-sky-600 hover:text-sky-500">กลับไปหน้าเข้าสู่ระบบ</a>
                </p>
            </div>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg space-y-1">
                <?php foreach ($errors as $error): ?>
                    <p class="text-sm"><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($success)): ?>
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                <p class="text-sm"><?php echo htmlspecialchars($success); ?></p>
            </div>
        <?php endif; ?>

        <form class="mt-8 space-y-6" action="/forgot-password/post" method="POST">
            <div class="space-y-4">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">ชื่อผู้ใช้</label>
                    <input id="username" name="username" type="text" required
                           value="<?php echo htmlspecialchars($username ?? ''); ?>"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500"
                           placeholder="กรุณากรอกชื่อผู้ใช้ของคุณ">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">อีเมล</label>
                    <input id="email" name="email" type="email" required
                           value="<?php echo htmlspecialchars($email ?? ''); ?>"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500"
                           placeholder="กรุณากรอกอีเมลที่ใช้สมัคร">
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">รหัสผ่านใหม่</label>
                    <input id="password" name="password" type="password" required
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500"
                           placeholder="รหัสผ่านใหม่ (อย่างน้อย 6 ตัวอักษร)">
                </div>

                <div>
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700">ยืนยันรหัสผ่านใหม่</label>
                    <input id="confirm_password" name="confirm_password" type="password" required
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500"
                           placeholder="กรุณากรอกรหัสผ่านใหม่อีกครั้ง">
                </div>
            </div>

            <div>
                <button type="submit" 
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition">
                    เปลี่ยนรหัสผ่าน
                </button>
            </div>
        </form>
    </div>
</body>
</html>