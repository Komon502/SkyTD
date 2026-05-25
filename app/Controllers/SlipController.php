<?php
// SlipController: จัดการเติมเงินและตรวจสอบ slip
require_once __DIR__ . '/../Models/Slip.php';
require_once __DIR__ . '/../Helpers/AuthHelper.php';

class SlipController {
    // แสดงฟอร์มอัปโหลด slip
    public function showUpload() {
        AuthHelper::isLoggedIn() or die('กรุณาเข้าสู่ระบบ');
        include __DIR__ . '/../Views/upload_slip.php';
    }
    // รับ slip และบันทึก
    public function upload() {
        AuthHelper::isLoggedIn() or die('กรุณาเข้าสู่ระบบ');
        if (!isset($_FILES['slip']) || $_FILES['slip']['error'] !== UPLOAD_ERR_OK) {
            $error = 'กรุณาเลือกไฟล์สลิป';
            include __DIR__ . '/../Views/upload_slip.php';
            return;
        }
        $userId = $_SESSION['user_id'];
        $target = '/uploads/' . uniqid() . '_' . basename($_FILES['slip']['name']);
        move_uploaded_file($_FILES['slip']['tmp_name'], __DIR__ . '/../../public' . $target);
        $slip = new Slip();
        $slip->user_id = $userId;
        $slip->image_path = $target;
        $slip->status = 'pending';
        $slip->created_at = date('Y-m-d H:i:s');
        $slip->save();
        $message = 'อัปโหลดสลิปเรียบร้อย รอแอดมินตรวจสอบ';
        include __DIR__ . '/../Views/upload_slip.php';
    }
}
