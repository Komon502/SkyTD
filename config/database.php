<?php
// SkyTrade Database Configuration
// Infinity Free MySQL Database

return [
    'host' => 'sql305.infinityfree.com',     // Database Host
    'port' => '3306',                        // Database Port
    'dbname' => 'if0_41886255_skytrade',    // Database Name
    'user' => 'if0_41886255',                // Database Username
    'pass' => 'Me0O3wnM0y'                  // Database Password
];

// Database Connection Test (Optional - remove in production)
/*
try {
    $db = new PDO('mysql:host=' . $cfg['host'] . ';port=' . $cfg['port'] . ';dbname=' . $cfg['dbname'], $cfg['user'], $cfg['pass']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Database connection successful!";
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
}
*/
