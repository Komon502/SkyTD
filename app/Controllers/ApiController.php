<?php
// ApiController: จัดการ API endpoints สำหรับ frontend
require_once __DIR__ . '/../Models/Trade.php';
require_once __DIR__ . '/../Models/User.php';

class ApiController {
    
    // API endpoint สำหรับดึงประวัติการเทรดของ user ปัจจุบัน
    public function getTradeHistory() {
        header('Content-Type: application/json');
        
        if (!User::isLoggedIn()) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
        
        $currentUser = User::getCurrentUser();
        $trades = Trade::getByUser($currentUser->id, 20); // ดึง 20 รายการล่าสุด
        
        $historyData = [];
        foreach ($trades as $trade) {
            if ($trade->result !== 'pending') {
                $historyData[] = [
                    'symbol' => $trade->symbol,
                    'profit_loss' => (float)$trade->profit_loss,
                    'result' => $trade->result,
                    'created_at' => $trade->created_at
                ];
            }
        }
        
        echo json_encode($historyData);
    }
    
    // API endpoint สำหรับอัปเดตราคาสด (mock data)
    public function updatePrices() {
        header('Content-Type: application/json');
        
        if (!User::isLoggedIn()) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
        
        // ส่งข้อมูล mock price updates
        echo json_encode([
            'timestamp' => date('Y-m-d H:i:s'),
            'updated' => true
        ]);
    }
}
