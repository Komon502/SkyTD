# SkyTrade - Forex Trading Platform

แพลตฟอร์มเทรด Forex ออนไลน์ที่ปลอดภัย ไว้ใจได้ พัฒนาด้วย PHP, MySQL, Tailwind CSS

## 🌟 Features

### ผู้ใช้ (User)
- ✅ สมัครสมาชิกและเข้าสู่ระบบ
- ✅ เทรด Forex แบบไม้ต่อไม้ หรือหลายไม้พร้อมกัน
- ✅ เลือกโหมด Demo หรือ Real ได้
- ✅ เติมเงินผ่าน SlipOK ตรวจสอบโดยแอดมิน
- ✅ ราคา Forex จริง อัปเดตแบบ Real-time
- ✅ ระบบควบคุมอัตราชนะตามการตั้งค่า

### แอดมิน (Admin)
- ✅ จัดการผู้ใช้ทุกรายการ
- ✅ เพิ่ม/แก้ไข/ลบคู่สกุลเงิน Forex
- ✅ เติมเงินให้ผู้ใช้
- ✅ ปรับอัตราชนะของผู้ใช้
- ✅ อนุมัติ/ปฏิเสธสลิปการโอนเงิน
- ✅ ดูสถิติและรายงานทั้งหมด

## 🎨 Design
- **Theme:** สีฟ้า-ขาว-เทา (Blue-White-Gray)
- **Framework:** Tailwind CSS
- **Style:** Business Website สะอาด ทันสมัย
- **Architecture:** Clean Architecture (MVC Pattern)

## 📁 Project Structure

```
Infinity Free/
├── public/
│   ├── index.php          # Entry point
│   └── .htaccess          # URL rewriting
├── app/
│   ├── Controllers/       # Business logic
│   ├── Models/           # Database models
│   ├── Views/            # User interface
│   └── Services/         # Additional services
├── config/
│   └── database.php      # Database configuration
├── routes/
│   └── web.php          # URL routing
├── database.sql         # Database schema
└── README.md
```

## 🚀 Deployment Guide (Infinity Free)

### 1. อัปโหลดไฟล์
- อัปโหลดไฟล์ทั้งหมดในโฟลเดอร์ `Infinity Free` ไปยัง root directory ของ hosting

### 2. ตั้งค่าฐานข้อมูล
- สร้างฐานข้อมูล MySQL ผ่าน cPanel
- แก้ไขไฟล์ `config/database.php`:
```php
<?php
return [
    'host' => 'localhost',          // หรือ hostname ที่ hosting ให้
    'dbname' => 'your_database_name',
    'user' => 'your_database_user',
    'pass' => 'your_database_password',
];
```

### 3. นำเข้าฐานข้อมูล
- ใช้ phpMyAdmin นำเข้าไฟล์ `database.sql`
- หรือรันคำสั่ง SQL ในไฟล์ดังกล่าว

### 4. ตั้งค่า Permissions
- สร้างโฟลเดอร์ `public/uploads/slips/` และตั้งค่า permissions 755
- ตรวจสอบว่า PHP สามารถเขียนไฟล์ในโฟลเดอร์ดังกล่าวได้

### 5. ทดสอบระบบ
- เข้าชมเว็บไซต์: `https://yourdomain.com`
- ทดสอบการสมัครสมาชิก
- ทดสอบการเข้าสู่ระบบ
- ทดสอบการเทรด (โหมด Demo)

## 🔧 Configuration

### ตั้งค่าแอดมินคนแรก
1. สมัครสมาชิกปกติผ่านเว็บไซต์
2. ใช้ phpMyAdmin อัปเดต role เป็น 'admin':
```sql
UPDATE users SET role = 'admin' WHERE username = 'your_admin_username';
```

### ตั้งค่าธนาคารรับเงิน
แก้ไขในไฟล์ `app/Views/dashboard/deposit.php`:
```php
<p><strong>ธนาคาร:</strong> ธนาคารกสิกรไทย</p>
<p><strong>ชื่อบัญชี:</strong> ชื่อบัญชีของคุณ</p>
<p><strong>เลขที่บัญชี:</strong> เลขบัญชีของคุณ</p>
```

### ตั้งค่าระบบ
เข้าแอดมินและไปที่ `ตั้งค่าระบบ` เพื่อปรับ:
- จำนวนเงินขั้นต่ำ/สูงสุดในการเทรด
- ระยะเวลาเทรดเริ่มต้น
- อัตราผลตอบแทนเมื่อชนะ
- สถานะการปิดปรับปรุงระบบ

## 🎯 Default Settings

- **เงินเริ่มต้น Demo:** ฿10,000
- **ขั้นต่ำการเทรด:** ฿10
- **สูงสุดการเทรด:** ฿10,000
- **ระยะเวลาเทรด:** 30, 60, 120, 300 วินาที
- **อัตราผลตอบแทน:** 85%
- **คู่สกุลเงิน:** EUR/USD, GBP/USD, USD/JPY, USD/CHF, AUD/USD, USD/CAD, NZD/USD, EUR/GBP

## 📱 Responsive Design
- ✅ Desktop (1920px+)
- ✅ Tablet (768px-1024px)
- ✅ Mobile (320px-768px)

## 🔒 Security Features
- ✅ Password hashing (bcrypt)
- ✅ Session management
- ✅ Input validation
- ✅ SQL injection prevention
- ✅ File upload security
- ✅ CSRF protection (basic)

## 🚨 Important Notes

1. **การเทรดจริง:** ต้องตรวจสอบกฎหมายในพื้นที่ของคุณ
2. **ความเสี่ยง:** การเทรด Forex มีความเสี่ยงสูง ผู้ใช้ควรมีความรู้
3. **อัตราชนะ:** ระบบสามารถปรับควบคุมอัตราชนะได้ตามการตั้งค่า
4. **Backup:** ควรสำรองข้อมูลฐานข้อมูลเป็นประจำ

## 📞 Support

หากพบปัญหาในการติดตั้งหรือมีคำถาม:
1. ตรวจสอบ error log ของ hosting
2. ตรวจสอบ permissions ของโฟลเดอร์ uploads
3. ตรวจสอบการเชื่อมต่อฐานข้อมูล

---

**© 2026 SkyTrade - Forex Trading Platform**  
*เทรด Forex อย่างมีความรับผิดชอบ*
