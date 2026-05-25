<?php
// DashboardController: จัดการหน้าแดชบอร์ดผู้ใช้
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/Trade.php';
require_once __DIR__ . '/../Models/Transaction.php';

class DashboardController {
    
    // แสดงหน้าแดชบอร์ด
    public function index() {
        if (!User::isLoggedIn()) {
            header('Location: /login');
            exit;
        }
        
        $currentUser = User::getCurrentUser();
        
        // ดึงข้อมูลสถิติ
        $tradeStats = Trade::getUserStats($currentUser->id);
        $transactionStats = Transaction::getUserStats($currentUser->id);
        $pendingTrades = Trade::getPendingTrades($currentUser->id);
        $recentTrades = Trade::getByUser($currentUser->id, 10);
        
        // ดึงยอดเงินคงเหลือ
        $realBalance = User::getBalance($currentUser->id, 'real');
        $demoBalance = User::getBalance($currentUser->id, 'demo');
        
        // Extract variables for view
        $user = $currentUser;
        $real_balance = $realBalance;
        $demo_balance = $demoBalance;
        $trade_stats = $tradeStats;
        $transaction_stats = $transactionStats;
        $pending_trades = $pendingTrades;
        $recent_trades = $recentTrades;
        
        include __DIR__ . '/../Views/dashboard/index.php';
    }

    // แสดงหน้าโปรไฟล์
    public function profile() {
        if (!User::isLoggedIn()) {
            header('Location: /login');
            exit;
        }
        
        $currentUser = User::getCurrentUser();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            $errors = [];
            
            // ตรวจสอบการเปลี่ยนรหัสผ่าน
            if (!empty($newPassword)) {
                if (empty($currentPassword)) {
                    $errors[] = 'กรุณาระบุรหัสผ่านปัจจุบัน';
                } elseif (strlen($newPassword) < 6) {
                    $errors[] = 'รหัสผ่านใหม่ต้องมีอย่างน้อย 6 ตัวอักษร';
                } elseif ($newPassword !== $confirmPassword) {
                    $errors[] = 'รหัสผ่านใหม่ไม่ตรงกัน';
                } else {
                    // ตรวจสอบรหัสผ่านปัจจุบัน
                    $authUser = User::authenticate($currentUser->username, $currentPassword);
                    if (!$authUser) {
                        $errors[] = 'รหัสผ่านปัจจุบันไม่ถูกต้อง';
                    }
                }
            }
            
            // ตรวจสอบอีเมล
            if (!empty($email) && $email !== $currentUser->email) {
                if (User::findByEmail($email)) {
                    $errors[] = 'อีเมลนี้ถูกใช้แล้ว';
                }
            }
            
            if (empty($errors)) {
                $updateData = [];
                
                if (!empty($email) && $email !== $currentUser->email) {
                    $updateData['email'] = $email;
                }
                
                if (!empty($newPassword)) {
                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    $updateData['password'] = $hashedPassword;
                }
                
                if (!empty($updateData)) {
                    if (User::update($currentUser->id, $updateData)) {
                        $success = 'อัปเดตข้อมูลสำเร็จ!';
                        $currentUser = User::getCurrentUser(); // Refresh
                    } else {
                        $errors[] = 'เกิดข้อผิดพลาดในการอัปเดตข้อมูล';
                    }
                }
            }
        }
        
        // Extract variables for view
        $currentUser = $currentUser;
        
        include __DIR__ . '/../Views/dashboard/profile.php';
    }

    // แสดงหน้าเติมเงิน
    public function deposit() {
        if (!User::isLoggedIn()) {
            header('Location: /login');
            exit;
        }
        
        $currentUser = User::getCurrentUser();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $amount = floatval($_POST['amount'] ?? 0);
            $bankName = $_POST['bank_name'] ?? '';
            $transactionTime = $_POST['transaction_time'] ?? '';
            
            $errors = [];
            
            if ($amount <= 0) $errors[] = 'กรุณาระบุจำนวนเงินที่ถูกต้อง';
            if (empty($bankName)) $errors[] = 'กรุณาระบุชื่อธนาคาร';
            if (empty($transactionTime)) $errors[] = 'กรุณาระบุเวลาทำรายการ';
            
            // ตรวจสอบการอัปโหลดสลิป
            if (!isset($_FILES['slip_image']) || $_FILES['slip_image']['error'] !== UPLOAD_ERR_OK) {
                $errors[] = 'กรุณาอัปโหลดรูปสลิปการโอนเงิน';
            }
            
            if (empty($errors)) {
                // สร้างธุรกรรม
                $transactionId = $this->createDepositTransaction($currentUser->id, $amount);
                
                if ($transactionId) {
                    // อัปโหลดรูปสลิป
                    $slipImagePath = $this->uploadSlipImage($_FILES['slip_image']);
                    
                    if ($slipImagePath) {
                        // บันทึกข้อมูลสลิป
                        $this->savePaymentSlip($currentUser->id, $transactionId, $slipImagePath, $amount, $bankName, $transactionTime);
                        $success = 'ส่งหลักฐานการโอนเงินเรียบร้อย! รอการตรวจสอบจากแอดมิน';
                    } else {
                        $errors[] = 'เกิดข้อผิดพลาดในการอัปโหลดรูปสลิป';
                    }
                } else {
                    $errors[] = 'เกิดข้อผิดพลาดในการสร้างธุรกรรม';
                }
            }
        }
        
        // Extract variables for view
        $currentUser = $currentUser;
        
        include __DIR__ . '/../Views/dashboard/deposit.php';
    }

    // Helper methods
    private function createDepositTransaction($userId, $amount) {
        $db = User::getDbConnection();
        $stmt = $db->prepare('INSERT INTO transactions (user_id, type, amount, status, description) VALUES (?, "deposit", ?, "pending", "Deposit Request")');
        if ($stmt->execute([$userId, $amount])) {
            return $db->lastInsertId();
        }
        return false;
    }

    private function uploadSlipImage($file) {
        $uploadDir = __DIR__ . '/../../public/uploads/slips/';
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $fileName = time() . '_' . basename($file['name']);
        $targetPath = $uploadDir . $fileName;
        
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return 'uploads/slips/' . $fileName;
        }
        
        return false;
    }

    private function savePaymentSlip($userId, $transactionId, $slipImagePath, $amount, $bankName, $transactionTime) {
        $db = User::getDbConnection();
        $stmt = $db->prepare('INSERT INTO payment_slips (user_id, transaction_id, slip_image, amount, bank_name, transaction_time) VALUES (?, ?, ?, ?, ?, ?)');
        return $stmt->execute([$userId, $transactionId, $slipImagePath, $amount, $bankName, $transactionTime]);
    }
}
