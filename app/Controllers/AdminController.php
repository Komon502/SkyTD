<?php
// AdminController: จัดการฝั่งแอดมิน
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/Trade.php';
require_once __DIR__ . '/../Models/ForexPair.php';
require_once __DIR__ . '/../Models/Transaction.php';

// IDE Helper: Define User class structure for type resolution
if (!class_exists('User', false)) {
    /**
     * User Model - IDE Helper
     */
    class User {
        public static function isLoggedIn() {}
        public static function getCurrentUser() {}
        public static function getAll() {}
        public static function findById($id) {}
        public static function getDbConnection() {}
        public static function addBalance($id, $amount) {}
        public static function addDemoBalance($id, $amount) {}
        public static function updateWinRate($id, $winRate) {}
        public static function update($id, $data) {}
    }
}

class AdminController {
    
    // ตรวจสอบสิทธิ์ admin
    private function checkAdminAccess() {
        if (!User::isLoggedIn()) {
            header('Location: /login');
            exit;
        }
        
        $currentUser = User::getCurrentUser();
        if (!$currentUser || $currentUser->role !== 'admin') {
            header('Location: /dashboard');
            exit;
        }
        
        return $currentUser;
    }

    // หน้าแดชบอร์ด admin
    public function dashboard() {
        $currentUser = $this->checkAdminAccess();
        
        try {
            // สถิติทั่วไป
            $allUsers = User::getAll() ?: [];
            $allTrades = Trade::getAll(100) ?: [];
            
            $stats = (object)[
                'total_users' => count($allUsers),
                'total_balance' => $this->getTotalBalance(),
                'today_trades' => $this->getTodayTrades(),
                'pending_slips' => $this->getPendingSlipsCount()
            ];
            
            // ข้อมูลกราฟ 7 วันล่าสุด
            $volumeChart = $this->getVolumeChartData();
            $userChart = $this->getUserChartData();
            
            // กิจกรรมล่าสุด
            $recentTrades = $this->getRecentTrades();
            $recentUsers = $this->getRecentUsers();
            
            include __DIR__ . '/../Views/admin/dashboard.php';
        } catch (Exception $e) {
            // Log error and show error page
            error_log("Dashboard error: " . $e->getMessage());
            http_response_code(500);
            echo '<div class="min-h-screen flex items-center justify-center bg-gray-50"><div class="text-center"><h1 class="text-2xl font-bold text-red-600 mb-4">เกิดข้อผิดพลาด</h1><p class="text-gray-600">ไม่สามารถโหลดข้อมูลแดชบอร์ดได้ กรุณาลองใหม่ภายหลัง</p></div></div>';
        }
    }

    // ดึงยอดเงินรวมในระบบ
    private function getTotalBalance() {
        try {
            $db = User::getDbConnection();
            $stmt = $db->query('SELECT SUM(amount) as total FROM transactions WHERE type = "deposit" AND status = "completed"');
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            return ($result !== null && isset($result->total)) ? (float)$result->total : 0;
        } catch (Exception $e) {
            error_log("Get total deposits error: " . $e->getMessage());
            return 0;
        }
    }

    // ดึงจำนวนการเทรดวันนี้
    private function getTodayTrades() {
        try {
            $db = User::getDbConnection();
            $stmt = $db->prepare('SELECT COUNT(*) as count FROM trades WHERE DATE(created_at) = CURDATE()');
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            return ($result !== null && isset($result->count)) ? (int)$result->count : 0;
        } catch (Exception $e) {
            error_log("Get today trades error: " . $e->getMessage());
            return 0;
        }
    }

    // ดึงจำนวนสลิปรออนุมัติ
    private function getPendingSlipsCount() {
        try {
            $db = User::getDbConnection();
            $stmt = $db->prepare('SELECT COUNT(*) as count FROM payment_slips WHERE status = "pending"');
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            return ($result !== null && isset($result->count)) ? (int)$result->count : 0;
        } catch (Exception $e) {
            error_log("Get pending slips error: " . $e->getMessage());
            return 0;
        }
    }

    // ดึงข้อมูลกราฟปริมาณการเทรด
    private function getVolumeChartData() {
        $db = User::getDbConnection();
        $labels = [];
        $data = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-{$i} days"));
            $dateLabel = date('d/m', strtotime("-{$i} days"));
            $labels[] = $dateLabel;
            
            $stmt = $db->prepare('SELECT COUNT(*) as count, SUM(amount) as total FROM trades WHERE DATE(created_at) = ? AND result != "pending"');
            $queryResult = $stmt->execute([$date]);
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            $data[] = ($result !== null && isset($result->total)) ? (float)$result->total : 0;
        }
        
        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    // ดึงข้อมูลกราฟผู้ใช้ใหม่
    private function getUserChartData() {
        $db = User::getDbConnection();
        $labels = [];
        $data = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-{$i} days"));
            $dateLabel = date('d/m', strtotime("-{$i} days"));
            $labels[] = $dateLabel;
            
            $stmt = $db->prepare('SELECT COUNT(*) as count FROM users WHERE DATE(created_at) = ?');
            $queryResult = $stmt->execute([$date]);
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            $data[] = ($result !== null && isset($result->count)) ? (int)$result->count : 0;
        }
        
        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    // จัดการผู้ใช้
    public function manageUsers() {
        $currentUser = $this->checkAdminAccess();
        
        $users = User::getAll();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            $userId = intval($_POST['user_id'] ?? 0);
            
            if ($action === 'add_balance' && $userId > 0) {
                $amount = floatval($_POST['amount'] ?? 0);
                $mode = $_POST['mode'] ?? 'real';
                
                if ($amount > 0) {
                    if ($mode === 'real') {
                        User::addBalance($userId, $amount);
                        Transaction::create($userId, 'deposit', $amount, null, 'Admin Deposit');
                    } else {
                        User::addDemoBalance($userId, $amount);
                    }
                    $success = 'เติมเงินสำเร็จ!';
                }
            }
            
            if ($action === 'adjust_win_rate' && $userId > 0) {
                $winRate = floatval($_POST['win_rate'] ?? 0.5);
                if ($winRate >= 0 && $winRate <= 1) {
                    User::updateWinRate($userId, $winRate);
                    $success = 'ปรับอัตราชนะสำเร็จ!';
                }
            }
            
            if ($action === 'toggle_status' && $userId > 0) {
                $user = User::findById($userId);
                if ($user) {
                    $newStatus = $user->status === 'active' ? 'suspended' : 'active';
                    User::update($userId, ['status' => $newStatus]);
                    $success = 'เปลี่ยนสถานะผู้ใช้สำเร็จ!';
                }
            }
            
            // Refresh users data
            $users = User::getAll();
        }
        
        include __DIR__ . '/../Views/admin/users.php';
    }

    // จัดการคู่สกุลเงิน Forex
    public function manageForex() {
        $currentUser = $this->checkAdminAccess();
        
        $forexPairs = ForexPair::getAll();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            
            if ($action === 'add_pair') {
                $symbol = $_POST['symbol'] ?? '';
                $name = $_POST['name'] ?? '';
                $price = floatval($_POST['current_price'] ?? 0);
                
                if (!empty($symbol) && !empty($name) && $price > 0) {
                    if (ForexPair::create($symbol, $name, $price)) {
                        $success = 'เพิ่มคู่สกุลเงินสำเร็จ!';
                    } else {
                        $error = 'เกิดข้อผิดพลาดในการเพิ่มคู่สกุลเงิน';
                    }
                }
            }
            
            if ($action === 'update_pair') {
                $pairId = intval($_POST['pair_id'] ?? 0);
                $price = floatval($_POST['current_price'] ?? 0);
                $isActive = isset($_POST['is_active']);
                
                if ($pairId > 0 && $price > 0) {
                    $data = [
                        'current_price' => $price,
                        'is_active' => $isActive ? 1 : 0
                    ];
                    
                    if (ForexPair::update($pairId, $data)) {
                        $success = 'อัปเดตคู่สกุลเงินสำเร็จ!';
                    } else {
                        $error = 'เกิดข้อผิดพลาดในการอัปเดตคู่สกุลเงิน';
                    }
                }
            }
            
            if ($action === 'delete_pair') {
                $pairId = intval($_POST['pair_id'] ?? 0);
                if ($pairId > 0) {
                    if (ForexPair::delete($pairId)) {
                        $success = 'ลบคู่สกุลเงินสำเร็จ!';
                    } else {
                        $error = 'เกิดข้อผิดพลาดในการลบคู่สกุลเงิน';
                    }
                }
            }
            
            // Refresh forex pairs data
            $forexPairs = ForexPair::getAll();
        }
        
        include __DIR__ . '/../Views/admin/forex.php';
    }

    // อนุมัติสลิปการโอนเงิน (SlipOK)
    public function approveSlip() {
        $currentUser = $this->checkAdminAccess();
        
        // ดึงรายการสลิปที่รอการอนุมัติ
        $pendingSlips = $this->getPendingSlips();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $slipId = intval($_POST['slip_id'] ?? 0);
            $action = $_POST['slip_action'] ?? '';
            $notes = $_POST['admin_notes'] ?? '';
            
            if ($slipId > 0 && in_array($action, ['approve', 'reject'])) {
                $this->processSlip($slipId, $action, $notes);
                $success = $action === 'approve' ? 'อนุมัติสลิปสำเร็จ!' : 'ปฏิเสธสลิปสำเร็จ!';
                $pendingSlips = $this->getPendingSlips();
            }
        }
        
        include __DIR__ . '/../Views/admin/slips.php';
    }

    // ดูการเทรดทั้งหมด
    public function viewTrades() {
        $currentUser = $this->checkAdminAccess();
        
        $trades = Trade::getAll(100);
        
        // Extract variables for view
        include __DIR__ . '/../Views/admin/trades.php';
    }

    // ดูธุรกรรมทั้งหมด
    public function viewTransactions() {
        $currentUser = $this->checkAdminAccess();
        
        $transactions = Transaction::getAll(100);
        
        include __DIR__ . '/../Views/admin/transactions.php';
    }

    // ตั้งค่าระบบ
    public function settings() {
        $currentUser = $this->checkAdminAccess();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $settings = [
                'min_trade_amount' => floatval($_POST['min_trade_amount'] ?? 10),
                'max_trade_amount' => floatval($_POST['max_trade_amount'] ?? 10000),
                'default_trade_duration' => intval($_POST['default_trade_duration'] ?? 60),
                'profit_percentage' => floatval($_POST['profit_percentage'] ?? 0.85),
                'site_maintenance' => isset($_POST['site_maintenance']) ? 'true' : 'false'
            ];
            
            foreach ($settings as $key => $value) {
                $this->updateSetting($key, $value);
            }
            
            $success = 'อัปเดตการตั้งค่าสำเร็จ!';
        }
        
        $currentSettings = $this->getAllSettings();
        
        include __DIR__ . '/../Views/admin/settings.php';
    }

    // Helper methods
    private function getTotalDeposits() {
        $db = User::getDbConnection();
        $stmt = $db->query('SELECT SUM(amount) as total FROM transactions WHERE type = "deposit" AND status = "completed"');
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result && $result->total !== null ? (float)$result->total : 0;
    }

    private function getActiveTrades() {
        $db = User::getDbConnection();
        $stmt = $db->query('SELECT COUNT(*) as count FROM trades WHERE result = "pending"');
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result && $result->count !== null ? (int)$result->count : 0;
    }

    private function getPendingSlips() {
        try {
            $db = User::getDbConnection();
            $stmt = $db->query('SELECT ps.*, u.username, t.amount as transaction_amount FROM payment_slips ps LEFT JOIN users u ON ps.user_id = u.id LEFT JOIN transactions t ON ps.transaction_id = t.id WHERE ps.status = "pending" ORDER BY ps.created_at DESC');
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            return ($result !== null && is_array($result)) ? $result : [];
        } catch (Exception $e) {
            error_log("Get pending slips error: " . $e->getMessage());
            return [];
        }
    }

    private function processSlip(int $slipId, string $action, string $notes) {
        $db = User::getDbConnection();
        
        if ($action === 'approve') {
            // อนุมัติสลิปและเติมเงิน
            $stmt = $db->prepare('UPDATE payment_slips SET status = "verified", admin_notes = ? WHERE id = ?');
            $result = $stmt->execute([$notes, $slipId]);
            
            // เติมเงินให้ผู้ใช้
            $slip = $db->prepare('SELECT user_id, amount FROM payment_slips WHERE id = ?');
            $slipResult = $slip->execute([$slipId]);
            $slipData = $slip->fetch(PDO::FETCH_OBJ);
            
            if ($slipData !== null && isset($slipData->user_id)) {
                User::addBalance($slipData->user_id, $slipData->amount);
                Transaction::create($slipData->user_id, 'deposit', $slipData->amount, $slipId, 'SlipOK Deposit');
            }
        } else {
            // ปฏิเสธสลิป
            $stmt = $db->prepare('UPDATE payment_slips SET status = "rejected", admin_notes = ? WHERE id = ?');
            $result = $stmt->execute([$notes, $slipId]);
        }
    }

    private function getAllSettings() {
        try {
            $db = User::getDbConnection();
            $stmt = $db->query('SELECT * FROM admin_settings');
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            $settings = [];
            foreach ($result as $row) {
                $settings[$row->setting_key] = $row->setting_value;
            }
            return $settings;
        } catch (Exception $e) {
            error_log("Get all settings error: " . $e->getMessage());
            return [];
        }
    }

    private function updateSetting(string $key, $value) {
        $db = User::getDbConnection();
        $stmt = $db->prepare('UPDATE admin_settings SET setting_value = ? WHERE setting_key = ?');
        $result = $stmt->execute([$value, $key]);
        return $result;
    }

    // ดึงการเทรดล่าสุด
    private function getRecentTrades() {
        try {
            $db = User::getDbConnection();
            $stmt = $db->prepare('SELECT t.*, u.username, fp.symbol FROM trades t LEFT JOIN users u ON t.user_id = u.id LEFT JOIN forex_pairs fp ON t.forex_pair_id = fp.id ORDER BY t.created_at DESC LIMIT 5');
            $result = $stmt->execute();
            $trades = $stmt->fetchAll(PDO::FETCH_OBJ);
            return ($trades !== null && is_array($trades)) ? $trades : [];
        } catch (Exception $e) {
            error_log("Get recent trades error: " . $e->getMessage());
            return [];
        }
    }

    // ดึงผู้ใช้ใหม่ล่าสุด
    private function getRecentUsers() {
        try {
            $db = User::getDbConnection();
            $stmt = $db->prepare('SELECT * FROM users ORDER BY created_at DESC LIMIT 5');
            $result = $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_OBJ);
            return ($users !== null && is_array($users)) ? $users : [];
        } catch (Exception $e) {
            error_log("Get recent users error: " . $e->getMessage());
            return [];
        }
    }
}
