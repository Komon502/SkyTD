<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkyTrade - เทรด Forex ออนไลน์</title>
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
<body class="bg-gradient-to-br from-sky-50 to-gray-100 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <h1 class="text-2xl font-bold text-sky-600">SkyTrade</h1>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="/login" class="text-gray-700 hover:text-sky-600 px-3 py-2 rounded-md text-sm font-medium">เข้าสู่ระบบ</a>
                    <a href="/register" class="bg-sky-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-sky-700">สมัครสมาชิก</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
                เทรด Forex กับ <span class="text-sky-600">SkyTrade</span>
            </h1>
            <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                แพลตฟอร์มเทรด Forex ออนไลน์ที่ปลอดภัย ไว้ใจได้ พร้อมโหมด Demo สำหรับผู้เริ่มต้น
            </p>
            <div class="flex justify-center space-x-4">
                <a href="/register" class="bg-sky-600 text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-sky-700 transition">
                    เริ่มเทรดฟรี
                </a>
                <a href="/login" class="bg-white text-sky-600 border-2 border-sky-600 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-sky-50 transition">
                    เข้าสู่ระบบ
                </a>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-xl shadow-md">
                <div class="text-sky-600 mb-4">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">เทรดได้ทั้ง Demo และ Real</h3>
                <p class="text-gray-600">ฝึกฝนทักษะด้วยโหมด Demo ก่อนเทรดด้วยเงินจริง</p>
            </div>
            
            <div class="bg-white p-6 rounded-xl shadow-md">
                <div class="text-sky-600 mb-4">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <รึ class="text-xl font-semibold text-gray-900 mb-2">ราคาจริง อัปเดตแบบ Real-time</h3>
                <p class="text-gray-600">ราคา Forex อิงจากตลาดจริง อัปเดตทันที</p>
            </div>
            
            <div class="bg-white p-6 rounded-xl shadow-md">
                <div class="text-sky-600 mb-4">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">ปลอดภัย ไว้ใจได้</h3>
                <p class="text-gray-600">ระบบฝาก-ถอนผ่าน SlipOK ตรวจสอบโดยแอดมิน</p>
            </div>
        </div>
    </div>

    <!-- How It Works -->
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">วิธีการเริ่มต้น</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="bg-sky-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-sky-600 font-bold text-xl">1</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">สมัครสมาชิก</h3>
                    <p class="text-gray-600 text-sm">สร้างบัญชี SkyTrade ฟรี</p>
                </div>
                <div class="text-center">
                    <div class="bg-sky-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-sky-600 font-bold text-xl">2</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">เติมเงิน</h3>
                    <p class="text-gray-600 text-sm">ฝากเงินผ่าน SlipOK</p>
                </div>
                <div class="text-center">
                    <div class="bg-sky-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-sky-600 font-bold text-xl">3</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">เลือกคู่เงิน</h3>
                    <p class="text-gray-600 text-sm">เลือกคู่สกุลเงินที่ต้องการ</p>
                </div>
                <div class="text-center">
                    <div class="bg-sky-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-sky-600 font-bold text-xl">4</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">เทรด</h3>
                    <p class="text-gray-600 text-sm">ทำนายทิศทางและเริ่มเทรด</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p>&copy; 2026 SkyTrade. All rights reserved.</p>
                <p class="text-gray-400 text-sm mt-2">เทรด Forex อย่างมีความรับผิดชอบ</p>
            </div>
        </div>
    </footer>
</body>
</html>
