<?php
// MT5Controller: จัดการหน้า MetaTrader 5 style
require_once __DIR__ . '/../Models/Trade.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/ForexPair.php';

class MT5Controller {
    
    // แสดงหน้า MetaTrader 5 style
    public function index() {
        if (!User::isLoggedIn()) {
            header('Location: /login');
            exit;
        }
        
        $currentUser = User::getCurrentUser();
        $forexPairs = ForexPair::getActivePairs();
        $pendingTrades = Trade::getPendingTrades($currentUser->id);
        $tradeStats = Trade::getUserStats($currentUser->id);
        
        // Extract variables for view
        $forexPairs = $forexPairs;
        $pending_trades = $pendingTrades;
        $trade_stats = $tradeStats;
        
        include __DIR__ . '/../Views/trade/mt5_style.php';
    }
    
    // Execute trade (เหมือนเดิม)
    public function execute() {
        if (!User::isLoggedIn()) {
            header('Location: /login');
            exit;
        }
        
        $currentUser = User::getCurrentUser();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $forexPairId = intval($_POST['forex_pair_id'] ?? 0);
            $amount = floatval($_POST['amount'] ?? 0);
            $direction = $_POST['direction'] ?? '';
            $mode = $_SESSION['trade_mode'] ?? 'demo';
            
            $errors = [];
            
            // ตรวจสอบข้อมูล
            if (empty($errors)) {
                if ($forexPairId <= 0) $errors[] = "กรุณาเลือกคู่สกุลเงิน";
                if ($amount < 10) $errors[] = "จำนวนเงินขั้นต่ำคือ 10 บาท";
                if (!in_array($direction, ['up', 'down'])) $errors[] = "กรุณาเลือกทิศทางการเทรด";
            }
            
            // ตรวจสอบยอดเงิน
            if (empty($errors)) {
                $balanceField = $mode === 'real' ? 'balance' : 'demo_balance';
                $currentBalance = User::getBalance($currentUser->id, $mode);
                
                if ($currentBalance < $amount) {
                    $errors[] = 'ยอดเงินคงเหลือไม่เพียงพอ';
                }
            }
            
            // สร้างการเทรด
            if (empty($errors)) {
                $tradeId = Trade::create($currentUser->id, $forexPairId, $amount, $direction, $mode);
                
                if ($tradeId) {
                    header('Location: /trade/mt5');
                    exit;
                } else {
                    $errors[] = 'เกิดข้อผิดพลาดในการสร้างการเทรด';
                }
            }
        }
        
        // ถ้ามี error ให้กลับไปหน้าเดิม
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: /trade/mt5');
            exit;
        }
    }
}
