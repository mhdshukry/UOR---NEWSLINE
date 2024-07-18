<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>UOR - NEWSLINE</title>
  <link rel="stylesheet" href="./assets/CSS/style.css" />
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="icon" type="image/png" href="./assets/images/ruhuna.png">
</head>
<body>
  <!-- Header -->
  <header class="header">
    <nav class="nav">
      <img src="./assets/images/ruhuna.png" alt="Rajarata University Logo" class="nav_logo_img">
      <a href="index.php" class="nav_logo">UOR - NEWSLINE</a>
    </nav>
  </header>

  <section class="home show">
    <div class="form_container show">
      <!-- Login Form -->
      <div class="form login_form show">
        <form action="login.php" method="post">
          <h2>Login</h2>
          <div class="input_box">
            <input type="email" name="email" placeholder="Enter your email" required />
            <i class="uil uil-envelope-alt email"></i>
          </div>
          <div class="input_box">
            <input type="password" name="password" placeholder="Enter your password" required />
            <i class="uil uil-lock password"></i>
            <i class="uil uil-eye-slash pw_hide"></i>
          </div>
          <div class="option_field">
            <span class="checkbox">
              <input type="checkbox" id="check" />
              <label>Remember me</label>
            </span>
            <a href="#" class="forgot_pw">Forgot password?</a>
          </div>
          <button class="button" type="submit">Login Now</button>
          <div class="login_signup">Don't have an account? <a href="#" id="signup">Signup</a></div>
        </form>
      </div>

      <!-- Signup Form -->
<div class="form signup_form">
  <form action="signup.php" method="post" enctype="multipart/form-data"> 
    <h2>Signup</h2>
    <div class="profile_picture_upload">
      <label for="profile_picture">
        <img src="./assets/images/pro.png" alt="Default Profile Picture" id="profile_preview">
      </label>
      <input type="file" id="profile_picture" name="profile_picture" accept="image/*" style="display: none;">
    </div>
    
    <div class="input_box">
      <input type="text" name="name" placeholder="Enter your name" required />
      <i class="uil uil-user-circle"></i>
    </div>
    <div class="input_box">
      <input type="email" name="email" placeholder="Enter your email" required />
      <i class="uil uil-envelope-alt email"></i>
    </div>
    <div class="input_box">
      <input type="password" name="password" placeholder="Enter your password" required />
      <i class="uil uil-lock password"></i>
      <i class="uil uil-eye-slash pw_hide"></i>
    </div>
    <div class="input_box">
      <input type="password" name="confirm_password" placeholder="Confirm password" required />
      <i class="uil uil-lock password"></i>
      <i class="uil uil-eye-slash pw_hide"></i>
    </div>
    <button class="button" type="submit">Signup Now</button>
    <div class="login_signup">Already have an account? <a href="#" id="login">Login</a></div>
  </form>
</div>


    </div>
  </section>
  
  <script src="./assets/js/script.js"></script>
</body>
</html>
