-- ตาราง slips สำหรับเติมเงิน
CREATE TABLE IF NOT EXISTS slips (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    status ENUM('pending','approved','rejected') DEFAULT 'pending',
    created_at DATETIME NOT NULL
);

-- ตาราง forex สำหรับคู่เงิน
CREATE TABLE IF NOT EXISTS forex (
    id INT AUTO_INCREMENT PRIMARY KEY,
    symbol VARCHAR(16) NOT NULL,
    name VARCHAR(64) NOT NULL,
    price DECIMAL(12,5) DEFAULT 1.00000
);
