@extends('mohammad.amin')
@section('connect')

  <div id="fatherDiv">
    <div class="container">
      <img src="img/Logo.svg" id="userPhotos" alt="Logo">

      <form id="loginForm" autocomplete="off">
        <label>نام کاربری:</label>
        <div class="input-container">
          <i class="fa fa-user icon"></i>
          <input type="text" id="textInput" placeholder="نام کاربری خود را وارد کنید">
        </div>

        <label>رمز عبور:</label>
        <div class="input-container">
          <i class="fa fa-lock icon"></i>
          <input type="password" id="password" placeholder="رمز عبور را وارد کنید">
          <i class="fa fa-eye toggle-password" onclick="togglePassword('password', this)"></i>
        </div>

        <center>
          <a href="phone.html" id="pLink"><p>فراموشی رمز عبور</p></a>
          <p id="errorMsg"></p>
        </center>

        <div class="button-container">
          <button type="button" class="btn" id="button" onclick="login()">ورود</button>
          <button type="button" onclick="creatUser()" id="creatUser">ثبت نام</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // ✅ تابع ورود
    function login() {
      const username = document.getElementById("textInput").value.trim();
      const password = document.getElementById("password").value.trim();
      const errorMsg = document.getElementById("errorMsg");

      // رمز عبور ذخیره شده از صفحه reset-password.html
      const savedPassword = localStorage.getItem("userPassword");

      if (!savedPassword) {
        errorMsg.textContent = "رمز عبوری تنظیم نشده است. ابتدا رمز خود را تنظیم کنید.";
        setTimeout(() => {
          window.location.href = "reset-password.html";
        }, 1500);
        return;
      }

      if (username === "" || password === "") {
        errorMsg.textContent = "لطفاً همه فیلدها را پر کنید.";
        return;
      }

      // فرض میکنیم نام کاربری دلخواه است، فقط رمز مهم است
      if (password === savedPassword) {
        errorMsg.textContent = "";
        alert("ورود موفقیت‌آمیز بود!");
        window.location = '{{url('dashboard')}}';
// یا صفحه بعدی
      } else {
        errorMsg.textContent = "نام کاربری یا رمز عبور اشتباه است.";
      }
    }

    // نمایش/مخفی کردن رمز عبور
    function togglePassword(id, el) {
      const input = document.getElementById(id);
      const isPassword = input.type === "password";
      input.type = isPassword ? "text" : "password";
      el.classList.toggle("fa-eye");
      el.classList.toggle("fa-eye-slash");
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
        
    document.addEventListener("DOMContentLoaded", function () {
      const toggleBtn = document.getElementById("themeToggle");
      toggleBtn.addEventListener("click", () => {
        document.body.classList.toggle("light-mode");
        toggleBtn.textContent = document.body.classList.contains("light-mode") ? "🌙" : "🌞";
      });
    });

    function toggleMenu() {
      document.getElementById("navMenu").classList.toggle("show");
    }

    // پاک کردن فیلدها هنگام بارگذاری
    window.onload = function () {
      document.getElementById("textInput").value = "";
      document.getElementById("password").value = "";
    };
  </script>
@endsection

