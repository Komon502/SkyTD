<?php
/** @var object $currentUser */
/** @var string $activePage - ค่าที่เป็นไปได้: dashboard, users, forex, slips, trades, transactions, settings */
if (!isset($activePage)) $activePage = '';
?>
<nav class="bg-gradient-to-r from-sky-600 to-sky-700 shadow-xl border-b border-sky-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <div class="flex-shrink-0 flex items-center">
                    <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-white">SkyTrade Admin</h1>
                </div>
                <div class="hidden md:flex space-x-1">
                    <?php
                    $navItems = [
                        ['key' => 'dashboard',    'href' => '/admin',            'label' => 'แดชบอร์ด'],
                        ['key' => 'users',         'href' => '/admin/users',      'label' => 'ผู้ใช้'],
                        ['key' => 'forex',         'href' => '/admin/forex',      'label' => 'Forex'],
                        ['key' => 'slips',         'href' => '/admin/slips',      'label' => 'สลิป'],
                        ['key' => 'trades',        'href' => '/admin/trades',     'label' => 'การเทรด'],
                        ['key' => 'transactions',  'href' => '/admin/transactions', 'label' => 'ธุรกรรม'],
                        ['key' => 'settings',      'href' => '/admin/settings',   'label' => 'ตั้งค่า'],
                    ];
                    foreach ($navItems as $item):
                        $isActive = $activePage === $item['key'];
                    ?>
                        <a href="<?php echo $item['href']; ?>"
                           class="<?php echo $isActive ? 'bg-sky-800 text-white' : 'text-sky-100 hover:text-white hover:bg-sky-800'; ?> px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 <?php echo $isActive ? 'border-b-2 border-white' : ''; ?>">
                            <?php echo $item['label']; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="hidden sm:flex items-center space-x-3">
                    <div class="text-white text-sm">
                        <span class="font-medium">แอดมิน:</span>
                        <span class="font-bold"><?php echo htmlspecialchars($currentUser->username); ?></span>
                    </div>
                    <a href="/dashboard" class="text-white hover:text-sky-100 px-3 py-2 text-sm font-medium rounded-lg bg-sky-800 transition-all duration-200">ไปหน้าผู้ใช้</a>
                    <a href="/logout" class="text-red-200 hover:text-white hover:bg-red-600 px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200">ออกจากระบบ</a>
                </div>
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="text-white hover:text-sky-100 p-2 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden pb-4">
            <div class="flex flex-col space-y-1">
                <?php foreach ($navItems as $item):
                    $isActive = $activePage === $item['key'];
                ?>
                    <a href="<?php echo $item['href']; ?>"
                       class="<?php echo $isActive ? 'bg-sky-800 text-white' : 'text-sky-100 hover:text-white hover:bg-sky-800'; ?> px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200">
                        <?php echo $item['label']; ?>
                    </a>
                <?php endforeach; ?>
            </div>
            <div class="border-t border-sky-700 mt-3 pt-3 flex flex-col space-y-2 sm:hidden">
                <div class="text-white text-sm px-4">
                    <span class="font-medium">แอดมิน:</span>
                    <span class="font-bold"><?php echo htmlspecialchars($currentUser->username); ?></span>
                </div>
                <a href="/dashboard" class="text-white hover:text-sky-100 px-4 py-2 text-sm font-medium rounded-lg bg-sky-800 transition-all duration-200">ไปหน้าผู้ใช้</a>
                <a href="/logout" class="text-red-200 hover:text-white hover:bg-red-600 px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200">ออกจากระบบ</a>
            </div>
        </div>
    </div>
</nav>
