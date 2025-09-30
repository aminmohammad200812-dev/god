<?php
$host = "localhost";       // یا sometimes 127.0.0.1
$dbname = "unehir_payamak";       // اسم دیتابیس شما
$username = "unehir_amin";   // نام کاربری دیتابیس
$password = "=f?G4n-;?!r8$3V"; // رمز عبور دیتابیس

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // فعال‌سازی خطا برای PDO
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // اتصال موفق
    // echo "✅ اتصال به دیتابیس موفق بود";
} catch (PDOException $e) {
    die("❌ اتصال به دیتابیس ناموفق بود: " . $e->getMessage());
}
?>