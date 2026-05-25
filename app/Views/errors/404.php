<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - ไม่พบหน้านี้ | SkyTrade</title>
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
<body class="bg-gradient-to-br from-sky-50 to-gray-100 min-h-screen flex items-center justify-center">
    <div class="text-center max-w-2xl mx-auto px-4">
        <!-- 404 Icon -->
        <div class="mb-8">
            <div class="inline-flex items-center justify-center w-32 h-32 bg-sky-100 rounded-full">
                <svg class="w-16 h-16 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        
        <!-- Error Message -->
        <div class="mb-8">
            <h1 class="text-6xl font-bold text-sky-600 mb-4">404</h1>
            <h2 class="text-3xl font-bold text-gray-900 mb-4">ไม่พบหน้านี้</h2>
            <p class="text-lg text-gray-600 mb-2">หน้าที่คุณกำลังมองหาไม่มีอยู่จริง</p>
            <p class="text-gray-500">URL: <span class="font-mono bg-gray-100 px-2 py-1 rounded"><?php echo htmlspecialchars($_SERVER['REQUEST_URI'] ?? ''); ?></span></p>
        </div>
        
        <!-- Action Buttons -->
        <div class="space-y-4">
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/" class="inline-flex items-center justify-center px-6 py-3 bg-sky-600 text-white rounded-lg font-semibold hover:bg-sky-700 transition transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    กลับหน้าหลัก
                </a>
                
                <?php if (User::isLoggedIn()): ?>
                    <a href="/dashboard" class="inline-flex items-center justify-center px-6 py-3 border-2 border-sky-600 text-sky-600 rounded-lg font-semibold hover:bg-sky-50 transition transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        ไปยังแดชบอร์ด
                    </a>
                <?php else: ?>
                    <a href="/login" class="inline-flex items-center justify-center px-6 py-3 border-2 border-sky-600 text-sky-600 rounded-lg font-semibold hover:bg-sky-50 transition transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h18m-4-4v18"></path>
                        </svg>
                        เข้าสู่ระบบ
                    </a>
                <?php endif; ?>
            </div>
            
            <!-- Search -->
            <div class="mt-8">
                <p class="text-sm text-gray-500 mb-2">หรือค้นหาสิ่งที่คุณต้องการ:</p>
                <form action="/" method="GET" class="max-w-md mx-auto">
                    <div class="flex">
                        <input type="text" name="search" placeholder="ค้นหา..." 
                               class="flex-1 px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        <button type="submit" class="bg-sky-600 text-white px-6 py-2 rounded-r-lg hover:bg-sky-700 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Additional Links -->
        <div class="mt-12 grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
            <a href="/trade" class="text-sky-600 hover:text-sky-500 font-medium">เทรด Forex</a>
            <a href="/register" class="text-sky-600 hover:text-sky-500 font-medium">สมัครสมาชิก</a>
            <a href="/deposit" class="text-sky-600 hover:text-sky-500 font-medium">เติมเงิน</a>
            <a href="/admin" class="text-sky-600 hover:text-sky-500 font-medium">แอดมิน</a>
        </div>
        
        <!-- Brand -->
        <div class="mt-12">
            <h3 class="text-xl font-bold text-sky-600 mb-2">SkyTrade</h3>
            <p class="text-gray-600">แพลตฟอร์มเทรด Forex ออนไลน์</p>
            <div class="mt-4 flex justify-center space-x-4">
                <a href="#" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385C19.388 16.5 18.447 17.5 17.5 17.5c-2.948 0-5.5-2.552-5.5-5.5s2.552-5.5 5.5-5.5 5.5 2.552 5.5 5.5c-.947 0-1.888-.5-2.625-1.25v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                </a>
                <a href="#" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.953 4.57a10 10 0 01-2.825.748l-.774-.774a1 1 0 00-1.414 0l-4.1 4.1a1 1 0 000 1.414l.774.774a10 10 0 01-.748 2.825l4.761 4.762a1 1 0 001.414 0l4.1-4.1a1 1 0 000-1.414l-.774-.774a10 10 0 012.825-.748l-4.761-4.762z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Background Animation -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-sky-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-blue-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute top-40 left-20 w-80 h-80 bg-sky-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>
    </div>
    
    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</body>
</html>
