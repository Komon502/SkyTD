<!DOCTYPE html>
<html lang="th">
<head>
    <?php $title = 'เลือกโหมดการเทรด - SkyTrade'; include __DIR__ . '/../partials/head.php'; ?>
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
        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">เลือกโหมดการเทรด</h2>
            <p class="text-gray-600">เลือกโหมดที่คุณต้องการเริ่มต้นการเทรด</p>
        </div>

        <!-- Mode Selection -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Demo Mode -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 text-white">
                    <div class="flex items-center justify-center mb-4">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-center">โหมดทดสอบ</h3>
                    <p class="text-center mt-2 opacity-90">Demo Mode</p>
                </div>
                <div class="p-6">
                    <ul class="space-y-3 mb-6">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">ใช้เงินทดสอบ ฿10,000</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">ไม่มีความเสี่ยงจริง</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">เหมาะสำหรับผู้เริ่มต้น</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">ฝึกฝนทักษะฟรี</span>
                        </li>
                    </ul>
                    <form method="POST" action="/trade/select-mode">
                        <input type="hidden" name="mode" value="demo">
                        <button type="submit" class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-blue-700 transition duration-200">
                            เริ่มเทรดโหมดทดสอบ
                        </button>
                    </form>
                </div>
            </div>

            <!-- Real Mode -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-green-600 p-6 text-white">
                    <div class="flex items-center justify-center mb-4">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1a1 1 0 11-2 0v-1a1 1 0 012 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-center">โหมดจริง</h3>
                    <p class="text-center mt-2 opacity-90">Real Mode</p>
                </div>
                <div class="p-6">
                    <ul class="space-y-3 mb-6">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">ใช้เงินจริงของคุณ</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">มีความเสี่ยงจริง</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">ได้ผลกำไรจริง</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">เหมาะสำหรับผู้มีประสบการณ์</span>
                        </li>
                    </ul>
                    <form method="POST" action="/trade/select-mode">
                        <input type="hidden" name="mode" value="real">
                        <button type="submit" class="w-full bg-green-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-green-700 transition duration-200">
                            เริ่มเทรดโหมดจริง
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Warning Notice -->
        <div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-lg p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">คำเตือนสำคัญ</h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <p>การเทรดในโหมดจริงมีความเสี่ยงสูง คุณอาจสูญเสียเงินทั้งหมดได้ กรุณาเทรดด้วยความระมัดระวังและเทรดเฉพาะเงินที่คุณสามารถสูญเสียได้เท่านั้น</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-8 text-center">
            <a href="/trade" class="inline-flex items-center text-gray-600 hover:text-gray-900">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                กลับไปหน้าเทรด
            </a>
        </div>
    </div>
</body>
</html>
