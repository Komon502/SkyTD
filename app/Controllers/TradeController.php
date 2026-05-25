<?php
// TradeController: จัดการเทรด, ดูประวัติ, เลือกโหมด (Demo/Real)
require_once __DIR__ . '/../Models/Trade.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/ForexPair.php';
require_once __DIR__ . '/../Models/Transaction.php';

class TradeController {
    
    // แสดงหน้าทำรายการเทรด
    public function showTrade() {
        if (!User::isLoggedIn()) {
            header('Location: /login');
            exit;
        }
        
        $currentUser = User::getCurrentUser();
        $forexPairs = ForexPair::getActivePairs();
        $pendingTrades = Trade::getPendingTrades($currentUser->id);
        $tradeStats = Trade::getUserStats($currentUser->id);
        
        // ตรวจสอบการเทรดที่หมดอายุ
        Trade::checkExpiredTrades();
        
        // Extract variables for view
        $currentUser = $currentUser;
        $pending_trades = $pendingTrades;
        $trade_stats = $tradeStats;
        
        include __DIR__ . '/../Views/trade/index.php';
    }

    // ทำรายการเทรดใหม่
    public function executeTrade() {
        if (!User::isLoggedIn()) {
            header('Location: /login');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /trade');
            exit;
        }
        
        $currentUser = User::getCurrentUser();
        $forexPairId = intval($_POST['forex_pair_id'] ?? 0);
        $amount = floatval($_POST['amount'] ?? 0);
        $direction = $_POST['direction'] ?? '';
        $mode = $_POST['mode'] ?? 'demo';
        $duration = intval($_POST['duration'] ?? 60);
        
        $errors = [];
        
        // ตรวจสอบข้อมูล
        if ($forexPairId <= 0) $errors[] = 'กรุณาเลือกคู่สกุลเงิน';
        if ($amount <= 0) $errors[] = 'กรุณาระบุจำนวนเงิน';
        if (!in_array($direction, ['up', 'down'])) $errors[] = 'กรุณาเลือกทิศทางการเทรด';
        if (!in_array($mode, ['demo', 'real'])) $errors[] = 'โหมดการเทรดไม่ถูกต้อง';
        
        // ตรวจสอบยอดเงิน
        if (empty($errors)) {
            $balanceField = $mode === 'real' ? 'balance' : 'demo_balance';
            $currentBalance = User::getBalance($currentUser->id, $mode);
            
            if ($currentBalance < $amount) {
                $errors[] = 'ยอดเงินคงเหลือไม่เพียงพอ';
            }
        }
        
        // ตรวจสอบจำนวนเงินขั้นต่ำ
        if (empty($errors)) {
            $minAmount = 10.00;
            
            if ($amount < $minAmount) $errors[] = "จำนวนเงินขั้นต่ำคือ {$minAmount} บาท";
        }
        
        if (!empty($errors)) {
            $forexPairs = ForexPair::getActivePairs();
            $pendingTrades = Trade::getPendingTrades($currentUser->id);
            $currentUser = $currentUser;
            $pending_trades = $pendingTrades;
            $trade_stats = Trade::getUserStats($currentUser->id);
            include __DIR__ . '/../Views/trade/index.php';
            return;
        }
        
        // สร้างการเทรด
        $tradeId = Trade::create($currentUser->id, $forexPairId, $amount, $direction, $mode, $duration);
        
        if ($tradeId) {
            $success = 'เปิดออเดอร์เทรดสำเร็จ!';
            header("Location: /trade?success=1");
            exit;
        } else {
            $error = 'เกิดข้อผิดพลาดในการเปิดออเดอร์';
            $forexPairs = ForexPair::getActivePairs();
            $pendingTrades = Trade::getPendingTrades($currentUser->id);
            $currentUser = $currentUser;
            include __DIR__ . '/../Views/trade/index.php';
        }
    }

    // ดูประวัติการเทรด
    public function history() {
        if (!User::isLoggedIn()) {
            header('Location: /login');
            exit;
        }
        
        $currentUser = User::getCurrentUser();
        $trades = Trade::getByUser($currentUser->id, 50);
        $tradeStats = Trade::getUserStats($currentUser->id);
        
        // Extract variables for view
        $currentUser = $currentUser;
        $trades = $trades;
        $trade_stats = $tradeStats;
        
        include __DIR__ . '/../Views/trade/history.php';
    }

    // เลือกโหมด Demo/Real
    public function selectMode() {
        if (!User::isLoggedIn()) {
            header('Location: /login');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mode'])) {
            $_SESSION['trade_mode'] = $_POST['mode'] === 'real' ? 'real' : 'demo';
            header('Location: /trade');
            exit;
        }
        
        $currentUser = User::getCurrentUser();
        include __DIR__ . '/../Views/trade/select_mode.php';
    }

    // ดูรายละเอียดการเทรด
    public function viewTrade($tradeId) {
        if (!User::isLoggedIn()) {
            header('Location: /login');
            exit;
        }
        
        $currentUser = User::getCurrentUser();
        $trade = Trade::findById($tradeId);
        
        if (!$trade || $trade->user_id != $currentUser->id) {
            header('Location: /trade/history');
            exit;
        }
        
        include __DIR__ . '/../Views/trade/view.php';
    }

    // API: ดูการเทรดที่กำลังดำเนินการ (สำหรับ AJAX)
    public function getPendingTrades() {
        if (!User::isLoggedIn()) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
        
        $currentUser = User::getCurrentUser();
        $pendingTrades = Trade::getPendingTrades($currentUser->id);
        
        header('Content-Type: application/json');
        echo json_encode($pendingTrades);
    }

    // API: อัปเดตราคา forex แบบ real-time
    public function updatePrices() {
        if (!User::isLoggedIn()) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
        
        // อัปเดตราคาแบบสุ่ม (simulation)
        ForexPair::updateAllRandomPrices();
        
        $forexPairs = ForexPair::getActivePairs();
        
        header('Content-Type: application/json');
        echo json_encode($forexPairs);
    }
}
