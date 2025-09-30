@extends('mohammad.amin')
@section('connect')
<title>تایید کد</title>
    <div class="container">
        <h2>تایید کد فرستاده شده</h2>
        <form id="resetForm" autocomplete="off">
            <label>کد تأیید</label>

            <div class="mb-3">
                <i class="fa fa-lock icon" id="icon"></i>
                <input type="tel" id="phone" placeholder="کد 6 رقمی را وارد کنید" maxlength="6" inputmode="numeric">
            </div>
            <div id="timer">⏳ زمان باقی‌مانده: 90 ثانیه</div>
            <p id="message"></p>
            <a href="index.html" id="mobileCorrection">اصلاح شماره موبایل</a>
            <button type="submit" id="enter" class="btn">ارسال کد تأیید</button>
        </form>
    </div>

    <script>
        // تایمر 90 ثانیه‌ای
        let timeLeft = 90;
        const timerEl = document.getElementById("timer");
        const messageEl = document.getElementById("message");
        const form = document.getElementById("resetForm");
        const submitBtn = document.getElementById("enter");
        const otpInput = document.getElementById("phone"); // ✅ id درست

        const countdown = setInterval(() => {
            timeLeft--;
            timerEl.textContent = `⏳ زمان باقی‌مانده: ${timeLeft} ثانیه`;
            if (timeLeft <= 0) {
                clearInterval(countdown);
                timerEl.textContent = "⛔ زمان ورود کد به پایان رسید.";
                messageEl.textContent = "لطفاً دوباره تلاش کنید.";
                messageEl.style.color = "red";
                submitBtn.disabled = true;
            }
        }, 1000);

        // ✅ رویداد درست: submit
        form.addEventListener("submit", function (e) {
            e.preventDefault(); // ✅ ضروری: جلوگیری از رفرش صفحه

            const otp = otpInput.value.trim();

            if (!otp || !/^\d{6}$/.test(otp)) {
                messageEl.textContent = "لطفاً یک کد 6 رقمی معتبر وارد کنید.";
                messageEl.style.color = "red";
                return;
            }

            fetch("verify_otp.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "otp=" + encodeURIComponent(otp)
            })
            .then(res => res.json())
            .then(data => {
                messageEl.textContent = data.message;
                messageEl.style.color = data.status === "verified" ? "green" : "red";

                if (data.status === "verified") {
                    clearInterval(countdown);
                    timerEl.textContent = "";
                    submitBtn.disabled = true;
                    setTimeout(() => {
                        window.location = '{{url('dashboard')}}';
                    }, 800);
                } else if (data.status === "expired") {
                    clearInterval(countdown);
                    timerEl.textContent = "⛔ مهلت کد تمام شده است.";
                    messageEl.textContent = "لطفاً دوباره شروع کنید.";
                    messageEl.style.color = "red";
                    submitBtn.disabled = true;
                }
            })
            .catch(err => {
                messageEl.textContent = "خطا در ارتباط با سرور.";
                messageEl.style.color = "red";
                console.error(err);
            });
        });

        // تغییر تم
        document.addEventListener("DOMContentLoaded", () => {
            const toggleBtn = document.getElementById("themeToggle");
            toggleBtn.addEventListener("click", () => {
                document.body.classList.toggle("light-mode");
                toggleBtn.textContent = document.body.classList.contains("light-mode") ? "🌙" : "🌞";
            });
        });

        // منوی موبایل
        function toggleMenu() {
            document.getElementById("navMenu").classList.toggle("show");
        }

        // دکمه‌های منوی هدر
        function headerButton1() {
          window.location.href = "https://shahrmad.ir/";
        }
        function headerButton2() {
          window.location = '{{url('Complaints')}}';
        }
        function headerButton3() {
          window.location = '{{url('about')}}';
        }
        function headerButton4() {
          window.location = '{{url('Contact Us')}}';
        }
        
        // پاک کردن فیلد
        window.onload = () => {
            otpInput.value = "";
            messageEl.textContent = "";
        };
    </script>
@endsection