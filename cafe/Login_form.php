<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Delicious Cafe</title>

  <!-- FONT AWESOME -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" />
  <!-- BOOTSTRAP -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <!-- GOOGLE FONT -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="icon" type="image/png" href="asset/image/Gemini_Generated_Image_y86qlny86qlny86q-removebg-preview.png">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Montserrat", sans-serif;
    }

    body {
      width: 100%;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow-x: hidden;
      overflow-y: auto;
      padding: 20px;
      position: relative;
    }

    #bg-video {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      z-index: -2;
      filter: brightness(0.6);
    }

    body::before {
      content: "";
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.45);
      z-index: -1;
    }

    .container_box {
      position: relative;
      width: 850px;
      max-width: 100%;
      min-height: 560px;
      overflow: hidden;
      border-radius: 30px;
      background: rgba(255, 255, 255, 0.08);
      border: 1px solid rgba(255, 255, 255, 0.18);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4), inset 0 1px 1px rgba(255, 255, 255, 0.2);
    }

    .form-container {
      position: absolute;
      top: 0;
      width: 50%;
      height: 100%;
      transition: all 0.6s ease-in-out;
    }

    .sign-in {
      left: 0;
      z-index: 2;
      opacity: 1;
    }

    .container_box.active .sign-in {
      transform: translateX(100%);
      opacity: 0;
      z-index: 1;
    }

    .sign-up {
      left: 0;
      opacity: 0;
      z-index: 1;
    }

    .container_box.active .sign-up {
      transform: translateX(100%);
      opacity: 1;
      z-index: 5;
    }

    .container_box form {
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      padding: 0 45px;
      text-align: center;
    }

    .container_box h1,
    .container_box h3 {
      color: white;
      font-weight: 700;
      margin-bottom: 10px;
    }

    .container_box p {
      color: #f1f1f1;
      font-size: 14px;
      line-height: 24px;
      margin: 15px 0;
    }

    .container_box span {
      color: #f3f3f3;
      font-size: 13px;
      margin-bottom: 15px;
    }

    .container_box a {
      color: #d5d3ce;
      text-decoration: none;
      font-size: 13px;
      margin-top: 15px;
      transition: 0.3s;
    }

    .container_box a:hover {
      color: white;
    }

    .container_box input {
      width: 100%;
      margin: 8px 0;
      padding: 14px 15px;
      border-radius: 12px;
      border: 1px solid rgba(255, 255, 255, 0.18);
      background: rgba(255, 255, 255, 0.1);
      outline: none;
      color: white;
      font-size: 14px;
      transition: 0.3s;
    }

    .container_box input:focus {
      border-color: #ffc107;
      box-shadow: 0 0 12px rgba(255, 193, 7, 0.35);
    }

    .container_box button {
      margin-top: 18px;
      border: none;
      padding: 13px 50px;
      border-radius: 12px;
      font-size: 14px;
      font-weight: 700;
      letter-spacing: 1px;
      text-transform: uppercase;
      cursor: pointer;
      color: white;
      background: linear-gradient(to right, #ffb300, #6b3b00);
      transition: 0.35s;
    }

    .hidden {
      background: transparent !important;
      border: 2px solid white !important;
    }

    .social-icons a {
      width: 42px;
      height: 42px;
      margin: 0 5px;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: white;
      border: 1px solid rgba(255, 255, 255, 0.25);
      background: rgba(255, 255, 255, 0.08);
      transition: 0.3s;
    }

    .social-icons a:hover {
      transform: scale(1.1);
      background: linear-gradient(to right, #ffb300, #6b3b00);
      border-color: transparent;
    }

    .toggle-container {
      position: absolute;
      top: 0;
      left: 50%;
      width: 50%;
      height: 100%;
      overflow: hidden;
      z-index: 1000;
      transition: all 0.6s ease-in-out;
      border-radius: 150px 0 0 100px;
    }

    .container_box.active .toggle-container {
      transform: translateX(-100%);
      border-radius: 0 150px 100px 0;
    }

    .toggle {
      position: relative;
      left: -100%;
      width: 200%;
      height: 100%;
      background: linear-gradient(135deg, rgba(248, 208, 115, 0.95), rgba(223, 120, 4, 0.95));
      color: white;
      transform: translateX(0);
      transition: all 0.6s ease-in-out;
    }

    .container_box.active .toggle {
      transform: translateX(50%);
    }

    .toggle-panel {
      position: absolute;
      width: 50%;
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      padding: 0 40px;
      text-align: center;
      transition: all 0.6s ease-in-out;
    }

    .toggle-left {
      transform: translateX(-200%);
    }

    .container_box.active .toggle-left {
      transform: translateX(0);
    }

    .toggle-right {
      right: 0;
    }

    .container_box.active .toggle-right {
      transform: translateX(200%);
    }

    /* FILE UPLOAD */
    .file-input {
      display: none;
    }

    .file-label {
      width: 100%;
      display: block;
      padding: 12px 15px;
      border-radius: 12px;
      border: 1px dashed rgba(255, 255, 255, 0.4);
      background: rgba(255, 255, 255, 0.08);
      color: white;
      cursor: pointer;
      transition: 0.3s;
    }

    /* MOBILE RESPONSIVE FIX */
    @media(max-width: 768px) {
      .container_box {
        min-height: 620px;
      }

      .form-container {
        width: 100%;
      }

      .container_box.active .sign-in {
        transform: translateX(-100%);
      }

      .container_box.active .sign-up {
        transform: translateX(0);
      }

      .toggle-container {
        display: none;
      }

      /* Mobile Toggle Link */
      .mobile-toggle {
        display: block;
        color: white;
        margin-top: 15px;
        font-size: 13px;
        cursor: pointer;
        text-decoration: underline;
      }
    }

    @media(min-width: 769px) {
      .mobile-toggle {
        display: none;
      }
    }
  </style>
</head>

<body>

  <video autoplay muted loop playsinline id="bg-video">
    <source src="asset/video/videoplayback.mp4" type="video/mp4">
  </video>

  <div class="container_box" id="container">

    <!-- SIGN UP -->
    <div class="form-container sign-up">
      <form action="signup.php" method="post" enctype="multipart/form-data">
        <h3>Create Account</h3>
        <!-- <div class="social-icons">
          <a href="#"><i class="fa-brands fa-google-plus-g"></i></a>
          <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
          <a href="#"><i class="fa-brands fa-github"></i></a>
          <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
        </div> -->
        <span>Use your email for registration</span>
        <input type="text" placeholder="Enter your name" name="Name">
        <input type="email" placeholder="Enter your email" name="email">
        <input type="password" placeholder="Create password" name="Password">
        <div class="upload-box" style="width: 100%;">
          <input type="file" id="file-upload" class="file-input" name="profileimg">
          <label for="file-upload" class="file-label">
            Upload Profile Picture
            <span style="display:block; font-size:11px; color:rgba(255,255,255,0.7)">Choose image</span>
          </label>
        </div>
        <button type="submit" name="signup">Sign Up</button>
        <p class="mobile-toggle" id="to-login">Already have an account? Sign In</p>
      </form>
    </div>

    <!-- SIGN IN -->
    <div class="form-container sign-in">
      <form action="signin.php" method="post" enctype="multipart/form-data">
        <h1>Sign In</h1>
        <!-- <div class="social-icons">
          <a href="#"><i class="fa-brands fa-google-plus-g"></i></a>
          <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
          <a href="#"><i class="fa-brands fa-github"></i></a>
          <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
        </div> -->
        <span>Use your email and password</span>
        <input type="email" placeholder="Enter your email" name="email">
        <input type="password" placeholder="Enter your password" name="password">
        <a href="#">Forget Your Password?</a>
        <button type="submit" name="signin_btn">Sign In</button>
        <p class="mobile-toggle" id="to-register">Don't have an account? Sign Up</p>
      </form>
    </div>

    <!-- TOGGLE (Desktop) -->
    <div class="toggle-container">
      <div class="toggle">
        <div class="toggle-panel toggle-left">
          <h1>Welcome Back!</h1>
          <p>Enter your details and continue your journey with us</p>
          <button class="hidden" id="login">Sign In</button>
          <a href="index.php" style="color:black !important; font-weight:700;">
            << Back To Main Website</a>
        </div>
        <div class="toggle-panel toggle-right">
          <h1>Hello Friend!</h1>
          <p>Register now and explore all amazing features</p>
          <button class="hidden" id="register">Sign Up</button>
          <a href="index.php" style="color:black !important; font-weight:700;">
            << Back To Main Website</a>
        </div>
      </div>
    </div>

  </div>

  <script>
    const container = document.getElementById("container");
    const registerBtn = document.getElementById("register");
    const loginBtn = document.getElementById("login");
    const toRegister = document.getElementById("to-register");
    const toLogin = document.getElementById("to-login");

    // Desktop Buttons
    registerBtn.addEventListener("click", () => container.classList.add("active"));
    loginBtn.addEventListener("click", () => container.classList.remove("active"));

    // Mobile Links
    toRegister.addEventListener("click", () => container.classList.add("active"));
    toLogin.addEventListener("click", () => container.classList.remove("active"));

    // Video Speed
    document.getElementById("bg-video").playbackRate = 1;
  </script>

</body>

</html>