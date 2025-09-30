<?php
header('Content-Type: application/json');
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'روش نامعتبر.']);
    exit;
}

$enteredOtp = trim($_POST['otp'] ?? '');

// چک کردن وجود OTP
if (!isset($_SESSION['otp'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'کدی ارسال نشده است.'
    ]);
    exit;
}

// چک کردن انقضا
if (time() > ($_SESSION['otp_expire'] ?? 0)) {
    unset($_SESSION['otp'], $_SESSION['otp_expire'], $_SESSION['phone']);
    echo json_encode([
        'status' => 'expired',
        'message' => 'مهلت ورود کد تمام شده است. دوباره درخواست دهید.'
    ]);
    exit;
}

// تأیید کد
if ($enteredOtp === $_SESSION['otp']) {
    unset($_SESSION['otp'], $_SESSION['otp_expire'], $_SESSION['phone']);
    echo json_encode([
        'status' => 'verified',
        'message' => '✅ کد با موفقیت تأیید شد.'
    ]);
} else {
    echo json_encode([
        'status' => 'invalid',
        'message' => '❌ کد وارد شده نادرست است.'
    ]);
}
exit;
?>