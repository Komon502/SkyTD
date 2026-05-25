<!-- login.php: ฟอร์มเข้าสู่ระบบ SkyTrade -->
<html lang="th">
<head>
    <?php $title = 'SkyTrade Login'; include __DIR__ . '/partials/head.php'; ?>
</head>
                <span class="text-white text-3xl font-bold">S</span>
            </div>
            <h1 class="text-2xl font-bold text-blue-600">SkyTrade</h1>
            <p class="text-gray-500">เข้าสู่ระบบเพื่อเทรด Forex</p>
        </div>
        <?php if (!empty($error)) : ?>
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 text-center">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($message)) : ?>
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4 text-center">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
        <form method="post" action="/login" class="space-y-4">
            <input type="text" name="username" placeholder="Username" required class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-300" />
            <input type="password" name="password" placeholder="Password" required class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-300" />
            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 rounded transition">Login</button>
        </form>
        <div class="mt-4 text-center">
            <a href="/register" class="text-blue-500 hover:underline">ยังไม่มีบัญชี? สมัครสมาชิก</a>
        </div>
    </div>
</body>
</html>
