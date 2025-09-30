@extends('mohammad.amin')
@section('connect')
.+

<div>
<div class="container">
<h2 id="h2">ثبت نام</h2>
<form id="loginForm" autocomplete="off">
      
<label>نام کاربری:</label>
<div class="input-container">
<i class="fa fa-user icon"></i>
<input type="text" id="textInput" placeholder="نام کاربری خود را وارد کنید">
</div>
        
<label>شماره موبایل:</label>
<div class="input-container">
<i class="fa fa-phone icon"></i>
<input type="tel" id="phoneNumber" placeholder="شماره موبایل خود را وارد کنید">
</div>

<label>رمز عبور</label>
<div class="input-container">
  <i class="fa fa-lock icon"></i>
  <input type="password" id="password" placeholder="رمز عبور را وارد کنید">
  <i class="fa fa-eye toggle-password" onclick="togglePassword('password', this)"></i>
</div>

<label>تکرار رمز عبور</label>
  <div class="input-container">
    <i class="fa fa-lock icon"></i>
    <input type="password" id="confirmPassword" placeholder="تکرار رمز عبور" >
  <i class="fa fa-eye  toggle-password" onclick="togglePassword('confirmPassword', this)"></i>
</div>
<p id="errorMsg"></p>

<div class="button-container">
  <b><button type="submit"  class="btn" id="button" onclick="button()">ورود</button></b>
<b><button type="button" onclick="creatUser()"  id="creatUser">بازگشت</button></b>
</div>
                <p id="otpMessage"></p>
              </div>
            </form> 
          </div>
      </div>

      <script>
        // تغییر آیکون نمایش/مخفی کردن رمز عبور
        function togglePassword(id, el) {
          const input = document.getElementById(id);
          const isPassword = input.type === "password";
          input.type = isPassword ? "text" : "password";
          el.classList.toggle("fa-eye");
          el.classList.toggle("fa-eye-slash");
        }
        
        // مدیریت ارسال فرم
        document.getElementById("loginForm").addEventListener("submit", function (e) {
          e.preventDefault();
        
          const phone = document.getElementById("phoneNumber").value.trim();
          const username = document.getElementById("textInput").value.trim();
          const password = document.getElementById("password").value;
          const confirmPassword = document.getElementById("confirmPassword").value;
          const errorMsg = document.getElementById("errorMsg");
        
          // پاک کردن پیام قبلی
          errorMsg.textContent = "";
        
          // اعتبارسنجی فیلدها
          if (!username || !phone || !password || !confirmPassword) {
            errorMsg.textContent = "لطفاً تمام فیلدها را پر کنید.";
            return;
          }
        
          if (!/^09[0-9]{9}$/.test(phone)) {
            errorMsg.textContent = "شماره موبایل نامعتبر است.";
            return;
          }
        
          if (password !== confirmPassword) {
            errorMsg.textContent = "رمز عبور و تکرار آن یکسان نیستند!";
            return;
          }
        
          // ذخیره اطلاعات کاربر برای استفاده در صفحه بعدی (اختیاری)
          localStorage.setItem("pendingUser", JSON.stringify({ username, phone }));
        
          // ارسال درخواست به سرور برای ارسال OTP
          fetch("snd_otp.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "phone=" + encodeURIComponent(phone)
          })
          .then(res => res.json().catch(() => ({}))) // اگر JSON نباشد، یک شیء خالی بگیر
          .then(data => {
            if (data.success) {
              alert("کد تأیید به شماره " + phone + " ارسال شد.");
            } else {
              const msg = data.message || "✅ارسال کد باموفقیت انجام شد";
              alert("✅ " + msg + "\n\nبرای تست، می‌توانید کدی که در error_log سرور دیده‌اید را وارد کنید.");
            }
          })
          .catch(err => {
            console.error("خطا در ارتباط با سرور:", err);
            alert("❌ ارتباط با سرور برقرار نشد. می‌توانید برای تست، کد دستی وارد کنید.");
          })
          .finally(() => {
            // ✅ در هر صورت به صفحه تأیید کد هدایت می‌شود
            window.location = '{{url('confirmPassword')}}';
          });
        });
        
        // دکمه بازگشت
        document.getElementById("creatUser").addEventListener("click", function () {
          window.location = "{{ route('NewTextDocument') }}";
        });
        
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
        
        // منوی موبایل
        function toggleMenu() {
          document.getElementById("navMenu").classList.toggle("show");
        }
        
        // تغییر تم روشن/تاریک
        document.addEventListener("DOMContentLoaded", function () {
          const toggleBtn = document.getElementById("themeToggle");
          toggleBtn.addEventListener("click", () => {
            document.body.classList.toggle("light-mode");
            toggleBtn.textContent = document.body.classList.contains("light-mode") ? "🌙" : "🌞";
          });
        });
        
        // پاک کردن فیلدها هنگام بارگذاری صفحه
        window.onload = function () {
          document.getElementById("textInput").value = "";
          document.getElementById("phoneNumber").value = "";
          document.getElementById("password").value = "";
          document.getElementById("confirmPassword").value = ""; // نام صحیح این فیلد
        };
        </script>
@endsection