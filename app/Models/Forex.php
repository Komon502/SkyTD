<?php
// Forex Model: โครงสร้างข้อมูลคู่เงิน + ฟังก์ชัน DB
require_once __DIR__ . '/../../config/database.php';
class Forex {
    public $id;
    public $symbol;
    public $name;
    public $price;

    private static function db() {
        $cfg = include __DIR__ . '/../../config/database.php';
        return new PDO('mysql:host=' . $cfg['host'] . ';dbname=' . $cfg['dbname'], $cfg['user'], $cfg['pass']);
    }

    // ดึงคู่เงินทั้งหมด
    public static function getAll() {
        $db = self::db();
        $stmt = $db->query('SELECT * FROM forex ORDER BY id ASC');
        $rows = $stmt->fetchAll(PDO::FETCH_OBJ);
        $forex = [];
        foreach ($rows as $row) {
            $fx = new Forex();
            foreach ($row as $k => $v) $fx->$k = $v;
            $forex[] = $fx;
        }
        return $forex;
    }

    // เพิ่มคู่เงิน
    public static function add($symbol, $name, $price) {
        $db = self::db();
        $stmt = $db->prepare('INSERT INTO forex (symbol, name, price) VALUES (?, ?, ?)');
        return $stmt->execute([$symbol, $name, $price]);
    }

    // ลบคู่เงิน
    public static function delete($id) {
        $db = self::db();
        $stmt = $db->prepare('DELETE FROM forex WHERE id = ?');
        return $stmt->execute([$id]);
    }

    // แก้ไขราคา
    public static function updatePrice($id, $price) {
        $db = self::db();
        $stmt = $db->prepare('UPDATE forex SET price = ? WHERE id = ?');
        return $stmt->execute([$price, $id]);
    }
}
