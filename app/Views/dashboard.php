<!-- dashboard.php: หน้าหลักผู้ใช้ -->
<?php include __DIR__ . '/partials/user_navbar.php'; ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
	<h1 class="text-2xl font-bold">SkyTrade Dashboard</h1>
	<div class="mt-4">
		<a href="/trade" class="text-sky-600 hover:underline mr-4">Trade</a>
		<a href="/history" class="text-sky-600 hover:underline mr-4">History</a>
		<a href="/logout" class="text-red-600 hover:underline">Logout</a>
	</div>
</div>
