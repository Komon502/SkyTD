    // ดึง slip pending ทั้งหมด
    public static function getPending() {
        $db = self::db();
        $stmt = $db->query('SELECT * FROM slips WHERE status = "pending" ORDER BY created_at ASC');
        $rows = $stmt->fetchAll(PDO::FETCH_OBJ);
        $slips = [];
        foreach ($rows as $row) {
            $slip = new Slip();
            foreach ($row as $k => $v) $slip->$k = $v;
            $slips[] = $slip;
        }
        return $slips;
    }

    // อนุมัติ slip
    public static function approve($id) {
        $db = self::db();
        $stmt = $db->prepare('UPDATE slips SET status = "approved" WHERE id = ?');
        return $stmt->execute([$id]);
    }

    // ปฏิเสธ slip
    public static function reject($id) {
        $db = self::db();
        $stmt = $db->prepare('UPDATE slips SET status = "rejected" WHERE id = ?');
        return $stmt->execute([$id]);
    }
<?php
// Slip Model: โครงสร้างข้อมูลสลิปเติมเงิน + ฟังก์ชัน DB
require_once __DIR__ . '/../../config/database.php';
class Slip {
    public $id;
    public $user_id;
    public $image_path;
    public $status;
    public $created_at;

    private static function db() {
        $cfg = include __DIR__ . '/../../config/database.php';
        return new PDO('mysql:host=' . $cfg['host'] . ';dbname=' . $cfg['dbname'], $cfg['user'], $cfg['pass']);
    }

    public function save() {
        $db = self::db();
        $stmt = $db->prepare('INSERT INTO slips (user_id, image_path, status, created_at) VALUES (?, ?, ?, ?)');
        return $stmt->execute([
            $this->user_id,
            $this->image_path,
            $this->status,
            $this->created_at
        ]);
    }
}
