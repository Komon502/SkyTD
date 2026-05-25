<?php
// Setup Forex Pairs in Database
// This script ensures all required forex pairs exist in the database

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/app/Models/ForexPair.php';

try {
    $cfg = include __DIR__ . '/config/database.php';
    $db = new PDO('mysql:host=' . $cfg['host'] . ';dbname=' . $cfg['dbname'], $cfg['user'], $cfg['pass']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create forex_pairs table if it doesn't exist
    $db->exec("CREATE TABLE IF NOT EXISTS forex_pairs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        symbol VARCHAR(20) NOT NULL UNIQUE,
        name VARCHAR(100) NOT NULL,
        current_price DECIMAL(15, 6) NOT NULL,
        is_active TINYINT(1) DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )");
    
    // Define forex pairs with initial prices
    $forexPairs = [
        ['symbol' => 'EUR/USD', 'name' => 'Euro/US Dollar', 'current_price' => 1.0850],
        ['symbol' => 'GBP/USD', 'name' => 'British Pound/US Dollar', 'current_price' => 1.2740],
        ['symbol' => 'USD/JPY', 'name' => 'US Dollar/Japanese Yen', 'current_price' => 157.50],
        ['symbol' => 'USD/CHF', 'name' => 'US Dollar/Swiss Franc', 'current_price' => 0.8980],
        ['symbol' => 'USD/CAD', 'name' => 'US Dollar/Canadian Dollar', 'current_price' => 1.3620],
        ['symbol' => 'AUD/USD', 'name' => 'Australian Dollar/US Dollar', 'current_price' => 0.6560],
        ['symbol' => 'NZD/USD', 'name' => 'New Zealand Dollar/US Dollar', 'current_price' => 0.6030],
        ['symbol' => 'EUR/GBP', 'name' => 'Euro/British Pound', 'current_price' => 0.8520],
        ['symbol' => 'EUR/JPY', 'name' => 'Euro/Japanese Yen', 'current_price' => 170.90],
        ['symbol' => 'GBP/JPY', 'name' => 'British Pound/Japanese Yen', 'current_price' => 200.80],
        ['symbol' => 'AUD/JPY', 'name' => 'Australian Dollar/Japanese Yen', 'current_price' => 103.30],
        ['symbol' => 'EUR/AUD', 'name' => 'Euro/Australian Dollar', 'current_price' => 1.6540],
        ['symbol' => 'GBP/AUD', 'name' => 'British Pound/Australian Dollar', 'current_price' => 1.9420],
        ['symbol' => 'EUR/CAD', 'name' => 'Euro/Canadian Dollar', 'current_price' => 1.4780],
        ['symbol' => 'USD/THB', 'name' => 'US Dollar/Thai Baht', 'current_price' => 36.20],
        ['symbol' => 'USD/SGD', 'name' => 'US Dollar/Singapore Dollar', 'current_price' => 1.3480],
        ['symbol' => 'USD/MXN', 'name' => 'US Dollar/Mexican Peso', 'current_price' => 18.45],
        ['symbol' => 'USD/HKD', 'name' => 'US Dollar/Hong Kong Dollar', 'current_price' => 7.820],
        ['symbol' => 'XAU/USD', 'name' => 'Gold/US Dollar', 'current_price' => 3320.0],
        ['symbol' => 'XAG/USD', 'name' => 'Silver/US Dollar', 'current_price' => 33.50],
    ];
    
    $insertCount = 0;
    $updateCount = 0;
    
    foreach ($forexPairs as $pair) {
        $stmt = $db->prepare('SELECT id FROM forex_pairs WHERE symbol = ?');
        $stmt->execute([$pair['symbol']]);
        
        if ($stmt->fetch()) {
            // Update existing pair
            $stmt = $db->prepare('UPDATE forex_pairs SET name = ?, current_price = ?, is_active = 1 WHERE symbol = ?');
            $stmt->execute([$pair['name'], $pair['current_price'], $pair['symbol']]);
            $updateCount++;
        } else {
            // Insert new pair
            $stmt = $db->prepare('INSERT INTO forex_pairs (symbol, name, current_price, is_active) VALUES (?, ?, ?, 1)');
            $stmt->execute([$pair['symbol'], $pair['name'], $pair['current_price']]);
            $insertCount++;
        }
    }
    
    echo "✅ Forex pairs setup completed successfully!\n";
    echo "📊 Inserted: {$insertCount} new pairs\n";
    echo "🔄 Updated: {$updateCount} existing pairs\n";
    echo "📈 Total pairs in database: " . count($forexPairs) . "\n";
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}