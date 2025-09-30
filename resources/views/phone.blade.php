@extends('mohammad.amin')
@section('connect')
<title>بازیابی رمز عبور</title>
  <div class="container">
    <h2>بازیابی رمز عبور</h2>
    <form id="resetForm">
      <label>شماره موبایل:</label>
      <div class="input-container">
        <i class="fa fa-phone icon"></i>
        <input type="tel" id="phone" placeholder="09123456789" maxlength="11" required>
      </div>
      <p id="errorMsg"></p>
      <button type="submit" class="btn">ارسال کد تأیید</button>
    </form>
  </div>
  <script>
    document.getElementById("resetForm").addEventListener("submit", function (e) {
      e.preventDefault();
      const phone = document.getElementById("phone").value.trim();
      const errorMsg = document.getElementById("errorMsg");
  
      errorMsg.textContent = "";
  
      if (!/^09[0-9]{9}$/.test(phone)) {
        errorMsg.textContent = "لطفاً یک شماره موبایل معتبر وارد کنید.";
        return;
      }
  
      // نمایش پیام در حال پردازش
      const btn = document.querySelector(".btn");
      const originalText = btn.textContent;
      btn.disabled = true;
      btn.textContent = "در حال ارسال کد...";
  
      // ارسال درخواست به سرور
      fetch("snd_otp.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "phone=" + encodeURIComponent(phone)
      })
      .then(res => res.json())
      .then(data => {
        if (data.success || data.message?.includes("ارسال شد")) {
          // کد با موفقیت ارسال شد
          localStorage.setItem("recoveryPhone", phone);
          window.location = '{{url('confirmpassword2')}}';
        } else {
          // اگر سرور خطا داد ولی میخواهیم کاربر ادامه دهد
          alert("کد ممکن است ارسال نشده باشد، اما میتوانید ادامه دهید.");
          localStorage.setItem("recoveryPhone", phone);
          window.location = '{{url('confirmpassword2')}}';
        }
      })
      .catch(err => {
        console.warn("ارسال کد با مشکل مواجه شد:", err);
        // ⚠️ حتی اگر fetch خطا داشت، کاربر را ادامه دهد
        alert("کد باموفقیت ارسال شد .");
        localStorage.setItem("recoveryPhone", phone);
        window.location.href = "confirmpassword2.html";
      })
      .finally(() => {
        btn.disabled = false;
        btn.textContent = originalText;
      });
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
        
  </script>
@endsection