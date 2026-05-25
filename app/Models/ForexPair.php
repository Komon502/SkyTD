<?php
// ForexPair Model: จัดการคู่สกุลเงิน
require_once __DIR__ . '/../../config/database.php';
class ForexPair {
    public $id;
    public $symbol;
    public $name;
    public $current_price;
    public $is_active;
    public $created_at;

    private static function db() {
        $cfg = include __DIR__ . '/../../config/database.php';
        return new PDO('mysql:host=' . $cfg['host'] . ';dbname=' . $cfg['dbname'], $cfg['user'], $cfg['pass']);
    }

    // ดึงคู่สกุลเงินทั้งหมดที่ active
    public static function getActivePairs() {
        $db = self::db();
        $stmt = $db->query('SELECT * FROM forex_pairs WHERE is_active = 1 ORDER BY symbol ASC');
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // ดึงคู่สกุลเงินทั้งหมด (สำหรับ admin)
    public static function getAll() {
        $db = self::db();
        $stmt = $db->query('SELECT * FROM forex_pairs ORDER BY symbol ASC');
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // ดึงข้อมูลคู่สกุลเงินตาม ID
    public static function findById($id) {
        $db = self::db();
        $stmt = $db->prepare('SELECT * FROM forex_pairs WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // ดึงข้อมูลคู่สกุลเงินตาม Symbol
    public static function findBySymbol($symbol) {
        $db = self::db();
        $stmt = $db->prepare('SELECT * FROM forex_pairs WHERE symbol = ?');
        $stmt->execute([$symbol]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // สร้างคู่สกุลเงินใหม่ (สำหรับ admin)
    public static function create($symbol, $name, $current_price) {
        $db = self::db();
        $stmt = $db->prepare('INSERT INTO forex_pairs (symbol, name, current_price) VALUES (?, ?, ?)');
        return $stmt->execute([$symbol, $name, $current_price]);
    }

    // อัปเดตราคาปัจจุบัน
    public static function updatePrice($id, $price) {
        $db = self::db();
        $stmt = $db->prepare('UPDATE forex_pairs SET current_price = ? WHERE id = ?');
        return $stmt->execute([$price, $id]);
    }

    // อัปเดตข้อมูลคู่สกุลเงิน
    public static function update($id, $data) {
        $db = self::db();
        $fields = [];
        $values = [];
        
        foreach ($data as $key => $value) {
            if (in_array($key, ['symbol', 'name', 'current_price', 'is_active'])) {
                $fields[] = "$key = ?";
                $values[] = $value;
            }
        }
        
        if (!empty($fields)) {
            $values[] = $id;
            $sql = "UPDATE forex_pairs SET " . implode(', ', $fields) . " WHERE id = ?";
            $stmt = $db->prepare($sql);
            return $stmt->execute($values);
        }
        return false;
    }

    // ลบคู่สกุลเงิน
    public static function delete($id) {
        $db = self::db();
        $stmt = $db->prepare('DELETE FROM forex_pairs WHERE id = ?');
        return $stmt->execute([$id]);
    }

    // สุ่มราคาใหม่ (จำลองการเปลี่ยนแปลงราคา)
    public static function getRandomPriceChange($currentPrice) {
        $change = (mt_rand(-100, 100) / 10000); // สุ่มเปลี่ยนแปลง ±1%
        $newPrice = $currentPrice * (1 + $change);
        return round($newPrice, 5);
    }

    // อัปเดตราคาทั้งหมดแบบสุ่ม (สำหรับ simulation)
    public static function updateAllRandomPrices() {
        $pairs = self::getAll();
        foreach ($pairs as $pair) {
            $newPrice = self::getRandomPriceChange($pair->current_price);
            self::updatePrice($pair->id, $newPrice);
        }
        return true;
    }
}
