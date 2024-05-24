<?php
include ('db_connect.php');
?>


<style>
  .navbar {
    min-height: 4.5rem;
  }

  .brand-logo {
    top: -10%;
    transform: translateY(10%);
    margin-left: -60%;
  }

  .brand-logo:hover {
    color: #fff !important;
  }

  .dropdown-toggle:hover {
    transition: 0.4s;
  }

  .dropdown-item:hover {
    color: red;
  }

  .dropdown-item:focus {
    color: red;
    background-color: transparent !important;
  }


  .disabled.nav-link.dropdown-toggle.dropdown-link {
    color: #fff !important;
  }

  .dropdown-toggle::after {
    display: none !important;
  }
</style>

<nav class="navbar navbar-light fixed-top bg-success " style="padding:0;min-height: 2rem">
  <div class="container-fluid mt-2 mb-2">
    <div class="col-lg-12">
      <div class="col-md-3 float-left">
        <a href="index.php?page=home" class="brand-logo">
          <h5 class=" mt-2" style="margin-left: 170px;">Baggao National School Of Arts and Trades
          </h5>
        </a>
      </div>
      <h5 class="text-center text-white float-left mt-2"
        style="text-transform: uppercase; letter-spacing: 2px; font-weight: medium; color: #f9f9f9 !important; margin-left: 15%;">
        BNSAT Student Attendance Management System</h5>
      <div class="float-right users">
        <div class="dropdown mr-4 mt-2 ">
          <a href="#" class="text-white dropdown-toggle dropdown-link" id="account_settings" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fa-solid fa-user mr-2"></i>
            Profile
          </a>
          <div class="dropdown-menu dropdown-link" aria-labelledby="account_settings" style="left: -4.70em;">
            <a class="dropdown-item" href="javascript:void(0)" id="manage_my_account"><i class="fa fa-cog"></i> Manage
              Account</a>
            <a class="dropdown-item" href="ajax.php?action=logout"><i class="fa fa-power-off"></i> Logout</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</nav>


<script>
  $('#manage_my_account').click(function () {
    uni_modal("Manage Account", "manage_user.php?id=<?php echo $_SESSION['login_id'] ?>&mtype=own");
  });
</script>