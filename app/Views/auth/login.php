<!DOCTYPE html>
<html lang="th">
<head>
    <?php $title = 'เข้าสู่ระบบ - SkyTrade'; include __DIR__ . '/../partials/head.php'; ?>
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
<body class="bg-gradient-to-br from-sky-50 to-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-xl shadow-lg">
        <div>
            <div class="text-center">
                <h1 class="text-3xl font-bold text-sky-600">SkyTrade</h1>
                <h2 class="mt-6 text-2xl font-semibold text-gray-900">เข้าสู่ระบบ</h2>
                <p class="mt-2 text-sm text-gray-600">
                    หรือ <a href="/register" class="text-sky-600 hover:text-sky-500">สมัครสมาชิกใหม่</a>
                </p>
            </div>
        </div>

        <?php if (isset($error)): ?>
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($success)): ?>
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <form class="mt-8 space-y-6" action="/login/post" method="POST">
            <div class="space-y-4">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">ชื่อผู้ใช้</label>
                    <input id="username" name="username" type="text" required
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500"
                           placeholder="กรุณากรอกชื่อผู้ใช้">
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">รหัสผ่าน</label>
                    <input id="password" name="password" type="password" required
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500"
                           placeholder="กรุณากรอกรหัสผ่าน">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" 
                           class="h-4 w-4 text-sky-600 focus:ring-sky-500 border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-700">
                        จำฉันไว้
                    </label>
                </div>

                <div class="text-sm">
                    <a href="/forgot-password" class="font-medium text-sky-600 hover:text-sky-500">
                        ลืมรหัสผ่าน?
                    </a>
                </div>
            </div>

            <div>
                <button type="submit" 
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition">
                    เข้าสู่ระบบ
                </button>
            </div>

            <div class="text-center">
                <a href="/" class="text-sm text-gray-600 hover:text-sky-600">
                    ← กลับหน้าหลัก
                </a>
            </div>
        </form>
    </div>
</body>
</html>
