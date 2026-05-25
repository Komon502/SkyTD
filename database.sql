-- SkyTrade Forex Trading Database Schema

-- Users Table: จัดการข้อมูลผู้ใช้
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(64) NOT NULL UNIQUE,
    email VARCHAR(128) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    balance DECIMAL(12,2) DEFAULT 0.00,
    demo_balance DECIMAL(12,2) DEFAULT 10000.00,
    role ENUM('user','admin') DEFAULT 'user',
    win_rate DECIMAL(4,2) DEFAULT 0.50,
    status ENUM('active','suspended') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Forex Pairs Table: จัดการคู่สกุลเงิน
CREATE TABLE IF NOT EXISTS forex_pairs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    symbol VARCHAR(16) NOT NULL UNIQUE,
    name VARCHAR(64) NOT NULL,
    current_price DECIMAL(10,5) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Trades Table: บันทึกการเทรด
CREATE TABLE IF NOT EXISTS trades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    forex_pair_id INT NOT NULL,
    amount DECIMAL(12,2) NOT NULL,
    direction ENUM('up','down') NOT NULL,
    entry_price DECIMAL(10,5) NOT NULL,
    exit_price DECIMAL(10,5),
    result ENUM('win','lose','pending') DEFAULT 'pending',
    mode ENUM('demo','real') NOT NULL,
    duration_seconds INT,
    profit_loss DECIMAL(12,2) DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (forex_pair_id) REFERENCES forex_pairs(id)
);

-- Transactions Table: บันทึกธุรกรรมการเงิน
CREATE TABLE IF NOT EXISTS transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    type ENUM('deposit','withdraw','trade_win','trade_loss') NOT NULL,
    amount DECIMAL(12,2) NOT NULL,
    reference_id VARCHAR(128),
    payment_method VARCHAR(64),
    status ENUM('pending','completed','failed') DEFAULT 'pending',
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Payment Slips Table: จัดการสลิปการโอนเงิน (SlipOK)
CREATE TABLE IF NOT EXISTS payment_slips (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    transaction_id INT NOT NULL,
    slip_image VARCHAR(255),
    amount DECIMAL(12,2) NOT NULL,
    bank_name VARCHAR(128),
    transaction_time DATETIME,
    status ENUM('pending','verified','rejected') DEFAULT 'pending',
    admin_notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (transaction_id) REFERENCES transactions(id)
);

-- Admin Settings Table: ตั้งค่าระบบ
CREATE TABLE IF NOT EXISTS admin_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(64) NOT NULL UNIQUE,
    setting_value TEXT,
    description TEXT,
    updated_by INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (updated_by) REFERENCES users(id)
);

-- Insert default forex pairs
INSERT INTO forex_pairs (symbol, name, current_price) VALUES
('EUR/USD', 'Euro/US Dollar', 1.08550),
('GBP/USD', 'British Pound/US Dollar', 1.27450),
('USD/JPY', 'US Dollar/Japanese Yen', 157.850),
('USD/CHF', 'US Dollar/Swiss Franc', 0.91250),
('AUD/USD', 'Australian Dollar/US Dollar', 0.66450),
('USD/CAD', 'US Dollar/Canadian Dollar', 1.36550),
('NZD/USD', 'New Zealand Dollar/US Dollar', 0.61550),
('EUR/GBP', 'Euro/British Pound', 0.85150);

-- Insert default admin settings
INSERT INTO admin_settings (setting_key, setting_value, description) VALUES
('min_trade_amount', '10.00', 'จำนวนเงินขั้นต่ำในการเทรด'),
('max_trade_amount', '10000.00', 'จำนวนเงินสูงสุดในการเทรด'),
('default_trade_duration', '60', 'ระยะเวลาเทรดเริ่มต้น (วินาที)'),
('profit_percentage', '0.85', 'อัตราผลตอบแทนเมื่อชนะ (85%)'),
('site_maintenance', 'false', 'สถานะการปิดปรับปรุงระบบ');
