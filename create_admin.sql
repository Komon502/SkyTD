-- SkyTrade - Create Admin User
-- รันคำสั่งนี้ใน phpMyAdmin เพื่อสร้างแอดมิน

-- ลบแอดมินเก่า (ถ้ามี)
DELETE FROM users WHERE username = 'admin';

-- สร้างแอดมินใหม่
INSERT INTO users (username, email, password, role, balance, demo_balance, win_rate, status) 
VALUES ('admin', 'admin@skytrade.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 0.00, 10000.00, 1.00, 'active');

-- ตรวจสอบผล
SELECT * FROM users WHERE role = 'admin';

-- ข้อมูลการล็อกอิน:
-- Username: admin
-- Password: admin123
