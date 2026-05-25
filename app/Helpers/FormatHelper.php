<?php
// FormatHelper: ฟังก์ชันช่วยเหลือการแสดงผล
class FormatHelper {
    public static function money($amount) {
        return number_format($amount, 2);
    }
}
