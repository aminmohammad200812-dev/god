@extends('mohammad.amin')
@section('connect')

<title>تایید کد</title>
  <div class="container">
    <h2>تایید کد ارسالی</h2>
    <form id="otpForm">
      <label>کد 6 رقمی:</label>
      <div class="input-container">
        <i class="fa fa-lock icon"></i>
        <input type="tel" id="otp" placeholder="کد را وارد کنید" maxlength="6" required>
      </div>
      <div id="timer">⏳ زمان باقی‌مانده: 90 ثانیه</div>
      <p id="message"></p>
      <button type="submit" class="btn">تایید کد</button>
    </form>
  </div>

  <script>
    const otpInput = document.getElementById("otp");
    const form = document.getElementById("otpForm");
    const timerEl = document.getElementById("timer");
    const messageEl = document.getElementById("message");

    let timeLeft = 90;
    const countdown = setInterval(() => {
      timeLeft--;
      timerEl.textContent = `⏳ زمان باقی‌مانده: ${timeLeft} ثانیه`;
      if (timeLeft <= 0) {
        clearInterval(countdown);
        timerEl.textContent = "⛔ زمان تمام شد.";
        messageEl.textContent = "دوباره تلاش کنید.";
        messageEl.style.color = "red";
        document.querySelector(".btn").disabled = true;
      }
    }, 1000);

    form.addEventListener("submit", function (e) {
      e.preventDefault();
      const otp = otpInput.value.trim();

      if (!/^\d{6}$/.test(otp)) {
        messageEl.textContent = "کد 6 رقمی وارد کنید.";
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
          setTimeout(() => {
            window.location = '{{url('dashboard')}}';
          }, 800);
        } else if (data.status === "expired") {
          clearInterval(countdown);
          document.querySelector(".btn").disabled = true;
        }
      })
      .catch(() => {
        messageEl.textContent = "خطا در ارتباط با سرور.";
        messageEl.style.color = "red";
      });
    });

    window.onload = () => {
      otpInput.value = "";
      messageEl.textContent = "";
    };
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
