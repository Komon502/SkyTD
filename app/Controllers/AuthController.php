<?php
// AuthController: จัดการ Register, Login, Logout
require_once __DIR__ . '/../Models/User.php';

class AuthController {
    
    // แสดงหน้า Login
    public function showLogin() {
        if (User::isLoggedIn()) {
            header('Location: /dashboard');
            exit;
        }
        include __DIR__ . '/../Views/auth/login.php';
    }

    // ดำเนินการ Login
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if (empty($username) || empty($password)) {
                $error = 'กรุณากรอกชื่อผู้ใช้และรหัสผ่าน';
                include __DIR__ . '/../Views/auth/login.php';
                return;
            }
            
            $user = User::authenticate($username, $password);
            
            if ($user) {
                User::createSession($user);
                header('Location: /dashboard');
                exit;
            } else {
                $error = 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง';
                include __DIR__ . '/../Views/auth/login.php';
            }
        } else {
            header('Location: /login');
            exit;
        }
    }

    // แสดงหน้า Register
    public function showRegister() {
        if (User::isLoggedIn()) {
            header('Location: /dashboard');
            exit;
        }
        include __DIR__ . '/../Views/auth/register.php';
    }

    // ดำเนินการ Register
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            $errors = [];
            
            if (empty($username)) $errors[] = 'กรุณากรอกชื่อผู้ใช้';
            if (empty($email)) $errors[] = 'กรุณากรอกอีเมล';
            if (empty($password)) $errors[] = 'กรุณากรอกรหัสผ่าน';
            if (strlen($password) < 6) $errors[] = 'รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษร';
            if ($password !== $confirmPassword) $errors[] = 'รหัสผ่านไม่ตรงกัน';
            
            // ตรวจสอบว่าชื่อผู้ใช้ซ้ำหรือไม่
            if (empty($errors)) {
                if (User::usernameExists($username) || User::findByEmail($email)) {
                    $errors[] = 'ชื่อผู้ใช้หรืออีเมลนี้ถูกใช้แล้ว';
                }
            }
            
            if (empty($errors)) {
                if (User::create($username, $email, $password)) {
                    $success = 'สมัครสมาชิกสำเร็จ! กรุณาเข้าสู่ระบบ';
                    include __DIR__ . '/../Views/auth/login.php';
                    return;
                } else {
                    $errors[] = 'เกิดข้อผิดพลาดในการสมัครสมาชิก';
                }
            }
            
            include __DIR__ . '/../Views/auth/register.php';
        } else {
            header('Location: /register');
            exit;
        }
    }

    // ออกจากระบบ
    public function logout() {
        User::destroySession();
        header('Location: /login');
        exit;
    }

    // แสดงหน้า Forgot Password
    public function showForgotPassword() {
        if (User::isLoggedIn()) {
            header('Location: /dashboard');
            exit;
        }
        include __DIR__ . '/../Views/auth/forgot_password.php';
    }

    // ดำเนินการเปลี่ยนรหัสผ่านใหม่
    public function forgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            $errors = [];
            
            if (empty($username)) $errors[] = 'กรุณากรอกชื่อผู้ใช้';
            if (empty($email)) $errors[] = 'กรุณากรอกอีเมล';
            if (empty($password)) $errors[] = 'กรุณากรอกรหัสผ่านใหม่';
            if (strlen($password) < 6) $errors[] = 'รหัสผ่านใหม่ต้องมีอย่างน้อย 6 ตัวอักษร';
            if ($password !== $confirmPassword) $errors[] = 'รหัสผ่านใหม่ไม่ตรงกัน';
            
            if (empty($errors)) {
                if (User::resetPassword($username, $email, $password)) {
                    $success = 'เปลี่ยนรหัสผ่านใหม่สำเร็จแล้ว! กรุณาเข้าสู่ระบบด้วยรหัสผ่านใหม่';
                    include __DIR__ . '/../Views/auth/login.php';
                    return;
                } else {
                    $errors[] = 'ข้อมูลชื่อผู้ใช้หรืออีเมลไม่ถูกต้อง หรือไม่มีบัญชีผู้ใช้นี้';
                }
            }
            
            include __DIR__ . '/../Views/auth/forgot_password.php';
        } else {
            header('Location: /forgot-password');
            exit;
        }
    }
}
