<?php
// SkyTrade - Entry Point for Infinity Free
// This file should be placed in the root directory

// Set error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set timezone
date_default_timezone_set('Asia/Bangkok');

// Include the routing system
require_once __DIR__ . '/routes/web.php';

// Optional: Database connection test
if (isset($_GET['test_db'])) {
    try {
        $cfg = include __DIR__ . '/config/database.php';
        $db = new PDO('mysql:host=' . $cfg['host'] . ';port=' . $cfg['port'] . ';dbname=' . $cfg['dbname'], $cfg['user'], $cfg['pass']);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        echo "<h2>✅ Database Connection Successful!</h2>";
        echo "<p>Host: " . $cfg['host'] . "</p>";
        echo "<p>Database: " . $cfg['dbname'] . "</p>";
        echo "<p><a href='/'>← Back to SkyTrade</a></p>";
        exit;
    } catch (PDOException $e) {
        echo "<h2>❌ Database Connection Failed!</h2>";
        echo "<p>Error: " . $e->getMessage() . "</p>";
        echo "<p><a href='/'>← Back to SkyTrade</a></p>";
        exit;
    }
}

// Optional: PHP Info (remove in production)
if (isset($_GET['phpinfo'])) {
    phpinfo();
    exit;
}
?>
