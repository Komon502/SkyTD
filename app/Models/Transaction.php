<?php
// Transaction Model: จัดการธุรกรรมการเงิน
require_once __DIR__ . '/../../config/database.php';

class Transaction {
    public $id;
    public $user_id;
    public $type;
    public $amount;
    public $reference_id;
    public $payment_method;
    public $status;
    public $description;
    public $created_at;

    private static function db() {
        $cfg = include __DIR__ . '/../../config/database.php';
        return new PDO('mysql:host=' . $cfg['host'] . ';dbname=' . $cfg['dbname'], $cfg['user'], $cfg['pass']);
    }

    // สร้างธุรกรรมใหม่
    public static function create($userId, $type, $amount, $referenceId = null, $description = '', $paymentMethod = null) {
        $db = self::db();
        $stmt = $db->prepare('INSERT INTO transactions (user_id, type, amount, reference_id, payment_method, description) VALUES (?, ?, ?, ?, ?, ?)');
        return $stmt->execute([$userId, $type, $amount, $referenceId, $paymentMethod, $description]);
    }

    // ดึงประวัติธุรกรรมของผู้ใช้
    public static function getByUser($userId, $limit = 50) {
        $db = self::db();
        $stmt = $db->prepare('SELECT * FROM transactions WHERE user_id = ? ORDER BY created_at DESC LIMIT ' . (int)$limit);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // ดึงธุรกรรมทั้งหมด (สำหรับ admin)
    public static function getAll($limit = 100) {
        $db = self::db();
        $stmt = $db->prepare('SELECT t.*, u.username FROM transactions t LEFT JOIN users u ON t.user_id = u.id ORDER BY t.created_at DESC LIMIT ' . (int)$limit);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // อัปเดตสถานะธุรกรรม
    public static function updateStatus($id, $status) {
        $db = self::db();
        $stmt = $db->prepare('UPDATE transactions SET status = ? WHERE id = ?');
        return $stmt->execute([$status, $id]);
    }

    // ดึงข้อมูลธุรกรรมตาม ID
    public static function findById($id) {
        $db = self::db();
        $stmt = $db->prepare('SELECT * FROM transactions WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // ดึงสถิติธุรกรรมของผู้ใช้
    public static function getUserStats($userId) {
        $db = self::db();
        
        $stmt = $db->prepare('SELECT 
            COUNT(*) as total_transactions,
            SUM(CASE WHEN type = "deposit" THEN amount ELSE 0 END) as total_deposits,
            SUM(CASE WHEN type = "withdraw" THEN amount ELSE 0 END) as total_withdrawals,
            SUM(CASE WHEN type = "trade_win" THEN amount ELSE 0 END) as total_wins,
            SUM(CASE WHEN type = "trade_loss" THEN amount ELSE 0 END) as total_losses
            FROM transactions WHERE user_id = ? AND status = "completed"');
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
