<?php
// Basic functionality test for SkyTrade
echo "<h1>SkyTrade - Basic Functionality Test</h1>";

// Test 1: Database Connection
echo "<h2>1. Database Connection Test</h2>";
try {
    require_once __DIR__ . '/../app/Models/User.php';
    $db = User::getDbConnection();
    echo "<p style='color: green;'>✅ Database connection successful</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Database connection failed: " . $e->getMessage() . "</p>";
}

// Test 2: User Model
echo "<h2>2. User Model Test</h2>";
try {
    $users = User::getAll();
    echo "<p style='color: green;'>✅ User model working - Found " . count($users) . " users</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ User model failed: " . $e->getMessage() . "</p>";
}

// Test 3: ForexPair Model
echo "<h2>3. ForexPair Model Test</h2>";
try {
    require_once __DIR__ . '/../app/Models/ForexPair.php';
    $pairs = ForexPair::getActivePairs();
    echo "<p style='color: green;'>✅ ForexPair model working - Found " . count($pairs) . " pairs</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ ForexPair model failed: " . $e->getMessage() . "</p>";
}

// Test 4: Trade Model
echo "<h2>4. Trade Model Test</h2>";
try {
    require_once __DIR__ . '/../app/Models/Trade.php';
    $trades = Trade::getAll(5);
    echo "<p style='color: green;'>✅ Trade model working - Found " . count($trades) . " trades</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Trade model failed: " . $e->getMessage() . "</p>";
}

// Test 5: Transaction Model
echo "<h2>5. Transaction Model Test</h2>";
try {
    require_once __DIR__ . '/../app/Models/Transaction.php';
    $transactions = Transaction::getAll(5);
    echo "<p style='color: green;'>✅ Transaction model working - Found " . count($transactions) . " transactions</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Transaction model failed: " . $e->getMessage() . "</p>";
}

// Test 6: Required Files Check
echo "<h2>6. Required Files Check</h2>";
$requiredFiles = [
    '/app/Controllers/AuthController.php',
    '/app/Controllers/DashboardController.php',
    '/app/Controllers/TradeController.php',
    '/app/Controllers/AdminController.php',
    '/app/Views/home.php',
    '/app/Views/auth/login.php',
    '/app/Views/auth/register.php',
    '/app/Views/dashboard/index.php',
    '/app/Views/trade/index.php',
    '/app/Views/admin/dashboard.php',
    '/routes/web.php',
    '/config/database.php'
];

foreach ($requiredFiles as $file) {
    $fullPath = __DIR__ . '/..' . $file;
    if (file_exists($fullPath)) {
        echo "<p style='color: green;'>✅ $file exists</p>";
    } else {
        echo "<p style='color: red;'>❌ $file missing</p>";
    }
}

// Test 7: Directory Permissions
echo "<h2>7. Directory Permissions Test</h2>";
$uploadDir = __DIR__ . '/../public/uploads/slips/';
if (!is_dir($uploadDir)) {
    if (mkdir($uploadDir, 0755, true)) {
        echo "<p style='color: green;'>✅ Created uploads directory</p>";
    } else {
        echo "<p style='color: red;'>❌ Failed to create uploads directory</p>";
    }
}

if (is_writable($uploadDir)) {
    echo "<p style='color: green;'>✅ Uploads directory is writable</p>";
} else {
    echo "<p style='color: red;'>❌ Uploads directory is not writable</p>";
}

// Test 8: Session Test
echo "<h2>8. Session Test</h2>";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$_SESSION['test'] = 'skytrade_test';
if ($_SESSION['test'] === 'skytrade_test') {
    echo "<p style='color: green;'>✅ Session working</p>";
    unset($_SESSION['test']);
} else {
    echo "<p style='color: red;'>❌ Session not working</p>";
}

echo "<h2>Test Complete!</h2>";
echo "<p><strong>Next Steps:</strong></p>";
echo "<ul>";
echo "<li>1. Configure database.php with your credentials</li>";
echo "<li>2. Import database.sql into your MySQL database</li>";
echo "<li>3. Upload files to your hosting</li>";
echo "<li>4. Test registration and login</li>";
echo "<li>5. Create admin user by updating role in database</li>";
echo "</ul>";
?>
