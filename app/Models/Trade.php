<?php
// Trade Model: โครงสร้างข้อมูลการเทรด + ฟังก์ชัน DB
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/Transaction.php';
require_once __DIR__ . '/ForexPair.php';
require_once __DIR__ . '/User.php';

class Trade {
    public $id;
    public $user_id;
    public $forex_pair_id;
    public $amount;
    public $direction;
    public $entry_price;
    public $exit_price;
    public $result;
    public $mode;
    public $duration_seconds;
    public $profit_loss;
    public $created_at;
    public $expires_at;

    // สร้าง PDO connection
    private static function db() {
        $cfg = include __DIR__ . '/../../config/database.php';
        return new PDO('mysql:host=' . $cfg['host'] . ';dbname=' . $cfg['dbname'], $cfg['user'], $cfg['pass']);
    }

    // สร้างการเทรดใหม่
    public static function create($userId, $forexPairId, $amount, $direction, $mode, $duration = 60) {
        try {
            $db = self::db();
            
            // ดึงข้อมูลคู่เงิน
            $forexPair = ForexPair::findById($forexPairId);
            if (!$forexPair) return false;
            
            // สร้างการเทรดใหม่
            $stmt = $db->prepare('INSERT INTO trades (user_id, forex_pair_id, amount, direction, entry_price, result, mode, duration_seconds, created_at, expires_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $result = $stmt->execute([
                $userId,
                $forexPairId,
                $amount,
                $direction,
                $forexPair->current_price,
                'pending',
                $mode,
                $duration,
                date('Y-m-d H:i:s'),
                date('Y-m-d H:i:s', strtotime("+{$duration} seconds"))
            ]);
            
            if ($result) {
                $tradeId = $db->lastInsertId();
                
                // หักเงินจากยอดคงเหลือ
                if ($mode === 'real') {
                    User::deductBalance($userId, $amount);
                } else {
                    User::deductDemoBalance($userId, $amount);
                }
                
                return $tradeId;
            }
            return false;
        } catch (Exception $e) {
            // Log error instead of throwing
            error_log("Trade creation error: " . $e->getMessage());
            return false;
            return $tradeId;
        }
        return false;
    }

    // ดึงข้อมูลการเทรดตาม ID
    public static function findById($id) {
        $db = self::db();
        $stmt = $db->prepare('SELECT t.*, fp.symbol, fp.name FROM trades t LEFT JOIN forex_pairs fp ON t.forex_pair_id = fp.id WHERE t.id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // ดึงการเทรดที่ยังไม่สิ้นสุดของผู้ใช้
    public static function getPendingTrades($userId) {
        $db = self::db();
        $stmt = $db->prepare('SELECT t.*, fp.symbol, fp.name FROM trades t LEFT JOIN forex_pairs fp ON t.forex_pair_id = fp.id WHERE t.user_id = ? AND t.result = "pending" ORDER BY t.created_at DESC');
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // ดึงประวัติการเทรดของ user
    public static function getByUser($userId, $limit = 50) {
        $db = self::db();
        $stmt = $db->prepare('SELECT t.*, fp.symbol, fp.name FROM trades t LEFT JOIN forex_pairs fp ON t.forex_pair_id = fp.id WHERE t.user_id = ? ORDER BY t.created_at DESC LIMIT ' . (int)$limit);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // ดึงการเทรดทั้งหมด (สำหรับ admin)
    public static function getAll($limit = 100) {
        $db = self::db();
        $stmt = $db->prepare('SELECT t.*, u.username, fp.symbol FROM trades t LEFT JOIN users u ON t.user_id = u.id LEFT JOIN forex_pairs fp ON t.forex_pair_id = fp.id ORDER BY t.created_at DESC LIMIT ' . (int)$limit);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // ปิดการเทรดและคำนวณผล
    public static function closeTrade($tradeId, $exitPrice) {
        $db = self::db();
        
        // ดึงข้อมูลการเทรด
        $trade = self::findById($tradeId);
        if (!$trade || $trade->result !== 'pending') return false;
        
        // คำนวณผลการเทรด
        $result = self::calculateResult($trade, $exitPrice);
        $profitLoss = $result['profit_loss'];
        $tradeResult = $result['result'];
        
        // อัปเดตข้อมูลการเทรด
        $stmt = $db->prepare('UPDATE trades SET exit_price = ?, result = ?, profit_loss = ? WHERE id = ?');
        $updateResult = $stmt->execute([$exitPrice, $tradeResult, $profitLoss, $tradeId]);
        
        if ($updateResult) {
            // อัปเดตยอดเงินผู้ใช้
            if ($profitLoss > 0) {
                if ($trade->mode === 'real') {
                    User::addBalance($trade->user_id, $profitLoss);
                } else {
                    User::addDemoBalance($trade->user_id, $profitLoss);
                }
                
                // บันทึกธุรกรรม
                Transaction::create($trade->user_id, 'trade_win', $profitLoss, $tradeId, 'Trade Win - ' . $trade->symbol);
            }
            
            return $result;
        }
        return false;
    }

    // คำนวณผลการเทรด
    private static function calculateResult($trade, $exitPrice) {
        // ดึงอัตราผลตอบแทนจาก settings
        $profitPercentage = self::getProfitPercentage();
        $profitAmount = $trade->amount * $profitPercentage;
        
        $isWin = false;
        if ($trade->direction === 'up' && $exitPrice > $trade->entry_price) {
            $isWin = true;
        } elseif ($trade->direction === 'down' && $exitPrice < $trade->entry_price) {
            $isWin = true;
        }
        
        // ปรับอัตราชนะตาม win_rate ของผู้ใช้ (สำหรับการควบคุม)
        $user = User::findById($trade->user_id);
        if ($user && isset($user->win_rate)) {
            $randomChance = mt_rand(1, 100);
            $winChance = $user->win_rate * 100;
            if ($randomChance > $winChance) {
                $isWin = false;
            } elseif ($randomChance <= $winChance && !$isWin) {
                // ถ้าสุ่มได้เข้าเกณฑ์ win_rate แต่ราคาไม่ได้ชนะ ให้บังคับให้ชนะ
                $isWin = true;
            }
        }
        
        return [
            'result' => $isWin ? 'win' : 'lose',
            'profit_loss' => $isWin ? ($trade->amount + $profitAmount) : -$trade->amount
        ];
    }

    // ดึงอัตราผลตอบแทนจาก settings
    private static function getProfitPercentage() {
        $db = self::db();
        $stmt = $db->prepare('SELECT setting_value FROM admin_settings WHERE setting_key = "profit_percentage"');
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result ? (float)$result->setting_value : 0.85;
    }

    // ดึงสถิติการเทรดของผู้ใช้
    public static function getUserStats($userId) {
        $db = self::db();
        
        $stmt = $db->prepare('SELECT 
            COUNT(*) as total_trades,
            SUM(CASE WHEN result = "win" THEN 1 ELSE 0 END) as wins,
            SUM(CASE WHEN result = "lose" THEN 1 ELSE 0 END) as losses,
            SUM(profit_loss) as total_profit_loss,
            AVG(CASE WHEN result = "win" THEN profit_loss ELSE NULL END) as avg_win,
            AVG(CASE WHEN result = "lose" THEN profit_loss ELSE NULL END) as avg_loss
            FROM trades WHERE user_id = ? AND result != "pending"');
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // ตรวจสอบการเทรดที่หมดอายุและปิดอัตโนมัติ
    public static function checkExpiredTrades() {
        $db = self::db();
        $current_time = date('Y-m-d H:i:s');
        
        $stmt = $db->prepare('SELECT * FROM trades WHERE result = "pending" AND expires_at <= ?');
        $stmt->execute([$current_time]);
        $expiredTrades = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        foreach ($expiredTrades as $trade) {
            // ดึกราคาปัจจุบัน
            $forexPair = ForexPair::findById($trade->forex_pair_id);
            if ($forexPair) {
                self::closeTrade($trade->id, $forexPair->current_price);
            }
        }
        
        return count($expiredTrades);
    }
}
