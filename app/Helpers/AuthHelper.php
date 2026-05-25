<?php
// AuthHelper: ฟังก์ชันช่วยเหลือเกี่ยวกับ Auth
class AuthHelper {
    public static function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    public static function isAdmin() {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }
}
