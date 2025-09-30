<?php
header('Content-Type: application/json');
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    $phone = $_POST['phone'];

    // فقط برای شماره تست
    if ($phone !== '09109851760') {
        echo json_encode(['success' => false, 'message' => 'در حال حاضر فقط به شماره تست پیامک ارسال می‌شود.']);
        exit;
    }

    // بررسی صحت شماره
    if (!preg_match('/^09[0-9]{9}$/', $phone)) {
        echo json_encode(['success' => false, 'message' => 'شماره موبایل معتبر نیست.']);
        exit;
    }

    // تولید کد تایید
    $otp = rand(100000, 999999);

    // ذخیره در session
    $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_expire'] = time() + 90; // انقضا 90 ثانیه
    $_SESSION['phone'] = $phone;

    // اطلاعات ورود شما
    $username = 'ali-amin';
    $password = 'aslkf@#j123o21joj23';
    $sender   = '3000XXXXXXX'; // شماره ارسال کننده ثبت‌شده شما ← لطفاً این رو با شماره واقعی‌ت جایگزین کن
    $text     = "کد تایید شما: $otp";

    // آدرس API
    $url = "https://smsg.ir/rest/?method=sendOTP&arg1=USER&arg2=PASS&arg3=PHONE&arg5=BRAND"
    . "&arg1=" . urlencode($username)
    . "&arg2=" . urlencode($password)
    . "&arg3=" . urlencode($phone)
    . "&arg4=" . urlencode($sender)
    . "&arg5=" . urlencode($text);

    // ارسال درخواست با cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
$response = curl_exec($ch);

if (curl_error($ch)) {
    error_log("cURL Error: " . curl_error($ch));
    echo json_encode([
        'success' => false,
        'message' => 'ارتباط با سرور برقرار نشد.',
        'error' => curl_error($ch)
    ]);
    curl_close($ch);
    exit;
}
curl_close($ch);

// ✅ اضافه کردن: ثبت پاسخ خام در لاگ
error_log("پاسخ خام smsg.ir: " . $response);

// تحلیل پاسخ
$result = json_decode($response, true);

// ✅ اضافه کردن: اگر decode نشد، خطا ثبت کن
if (json_last_error() !== JSON_ERROR_NONE) {
    error_log("خطا در دیکد JSON: " . json_last_error_msg());
    error_log("محتوای خام: " . $response);
}

// ✅ اصلاح شرط: بررسی ساختار واقعی
if ($result && isset($result['status']) && $result['status'] === true) {
    // یا ممکن است کلید 'result' یا 'success' باشد — بستگی به API دارد
    echo json_encode([
        'success' => true,
        'message' => 'کد تأیید ارسال شد ✅'
    ]);
}
// } else {
//     // ✅ نمایش پاسخ واقعی برای دیباگ
//     echo json_encode([
//         'success' => false,
//         'message' => 'ارسال پیامک با خطا مواجه شد ❌',
//         'response' => $result ? $result : $response
//     ]);
// }
?>