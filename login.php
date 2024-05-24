<?php
session_start();
include 'header.php';
include ('db_connect.php');
ob_start();
ob_end_flush();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <?php include ('./header.php'); ?>
  <?php
  if (isset($_SESSION['login_id']))
    header('location:index.php?page=home');

  ?>

  <style>
    body {
      background: #f2f2f2 !important;
      color: #333;
    }

    .login {
      min-height: 100vh;
    }

    .bg-image {
      position: relative;
      background-image: url(assets/img/background.jpg);
      background-size: cover;
      background-position: center;
      filter: brightness(100%);
    }

    .bg-image::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: rgba(8, 70, 11, 0.3);
      z-index: 1;
    }

    .btn-login {
      font-weight: 600;
      font-size: 0.9rem;
      letter-spacing: 0.05rem;
      padding: 0.75rem 1rem;
    }

    .btn-login:hover {
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }

    .password-container {
      position: relative;
    }

    .EyePass {
      position: absolute;
      right: 10px;
      top: 80%;
      transform: translate(0, -80%);
      cursor: pointer;
    }
  </style>
</head>

<body>
  <div class="container-fluid ps-md-0">
    <div class="row g-0">
      <div class="d-none d-md-flex col-md-4 col-lg-8 bg-image" data-aos="fade-right" data-aos-offset="300"
        data-aos-easing="ease-in-out" data-aos-duration="2000"></div>
      <div class="col-md-8 col-lg-4">
        <div class="login d-flex align-items-center py-5">
          <div class="container">
            <div class="row">
              <div class="col-md-9 col-lg-10 mx-auto text-center ">
                <!-- Brand -->
                <div class="text-center">
                  <img src="assets/img/logo.png" alt="Logo" width="150" height="150">
                  <h5 class="mt-3 mb-4">BNSAT STUDENT ATTENDANCE</h5>
                  <h4 class="mt-3 mb-4">Welcome back Admin!</h4>
                </div>
                <h5 class="mb-4 text-opacity text-left">Please login to continue</h5>

                <!-- Sign In Form -->
                <form id="login-form" class="text-left">
                  <label class="control-label">Username:</label>
                  <div class="mb-3">
                    <input type="text" class="form-control pt-4 pb-4" id="username" name="username">
                  </div>
                  <div class="mb-3">
                    <div class="password-container">
                      <label class="control-label">Password:</label>
                      <input type="password" class="form-control pt-4 pb-4" id="password" name="password">
                      <span class="EyePass">
                        <i class="fa fa-eye" aria-hidden="true" id="eye" onclick="toggle()"></i>
                      </span>
                    </div>

                  </div>
                  <div class="d-grid">
                    <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-5 w-100"
                      type="submit">Login</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

</body>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init();
  $('#login-form').submit(function (e) {
    e.preventDefault()
    $('#login-form button[type="button"]').attr('disabled', true).html('Logging in...');
    if ($(this).find('.alert-danger').length > 0)
      $(this).find('.alert-danger').remove();
    $.ajax({
      url: 'ajax.php?action=login',
      method: 'POST',
      data: $(this).serialize(),
      error: err => {
        console.log(err)
        $('#login-form button[type="button"]').removeAttr('disabled').html('Login');

      },
      success: function (resp) {
        if (resp == 1) {
          location.href = 'index.php?page=home';
        } else {
          $('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
          $('#login-form button[type="button"]').removeAttr('disabled').html('Login');
        }
      }
    })
  })

  // Password toggle eye icon
  var state = false;

  function toggle() {
    // Use the name attribute to select the password input
    var passwordInput = document.getElementsByName("password")[0];

    if (state) {
      passwordInput.setAttribute("type", "password");
      document.getElementById("eye").style.color = '#7a797e';
      state = false;
    } else {
      passwordInput.setAttribute("type", "text");
      document.getElementById("eye").style.color = '#5887ef';
      state = true;
    }
  }

</script>


</html>