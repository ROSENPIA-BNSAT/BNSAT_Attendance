<?php
session_start();
include ('admin/db_connect.php');
ob_start();

ob_end_flush();
include ('header.php');

?>
<!DOCTYPE html>
<html lang="en">
<style>
  body {
    position: relative;
  }

  #success_message {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 9999;
  }


  #viewer_modal .btn-close {
    position: absolute;
    z-index: 999999;
    background: unset;
    color: white;
    border: unset;
    font-size: 27px;
    top: 0;
  }

  #viewer_modal .modal-dialog {
    width: 80%;
    max-width: unset;
    height: calc(90%);
    max-height: unset;
  }

  #viewer_modal .modal-content {
    background: black;
    border: unset;
    height: calc(100%);
    display: flex;
    align-items: center;
    justify-content: center;
  }

  #viewer_modal img,
  #viewer_modal video {
    max-height: calc(100%);
    max-width: calc(100%);
  }

  a.jqte_tool_label.unselectable {
    height: auto !important;
    min-width: 4rem !important;
    padding: 5px;
  }
</style>

<body id="page-top">
  <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body text-white">
    </div>
  </div>
  <header id="header" class="fixed-top d-flex align-items-center" data-aos="zoom-in">
    <div class="container d-flex align-items-center">
      <nav class="navbar navbar-expand-lg navbar-dark py-3 fixed-top order-last order-lg-0 mx-auto" id="mainNav">
        <div class="d-none d-md-block"><a href="index.php?page=attendance" class="logo me-auto"><img
              src="assets/img/logo.png" alt=""></a></div>
        <div class="d-block d-md-none"><a href="index.php?page=attendance" class="logo-small me-auto"><img
              src="assets/img/logo.png" alt=""></a></div>
        <button class="navbar-toggler navbar-toggler-right " type="button" data-toggle="collapse"
          data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
          aria-label="Toggle navigation"><span class="navbar-toggler-icon"></button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto my-2 my-lg-0 mr-3">
            <?php if (!isset($_SESSION['login_id'])): ?>
              <li class="nav-item"><a class="nav-link login-link js-scroll-trigger" href="#" id="login">Login</a></li>
            <?php elseif ($_SESSION['login_name'] != 'Admin'): ?>
              <li class="nav-item">
                <div class="dropdown mr-4 dropdown-link">
                  <a href="#" class="nav-link dropdown-link dropdown-link" id="account_settings" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <?php echo $_SESSION['login_name'] ?> <i class="fa fa-angle-down"></i>
                  </a>
                  <div class="dropdown-menu dropdown-link" aria-labelledby="account_settings">
                    <a class="dropdown-item" href="index.php?page=my_account" id="manage_my_account"><i
                        class="fa fa-cog"></i> Manage Account</a>
                    <a class="dropdown-item" href="index.php?page=attendance">
                      <i class="fas fa-calendar-check"></i> Attendance
                    </a> <a class="dropdown-item" href="admin/ajax.php?action=logout2"><i class="fa fa-power-off"></i>
                      Logout</a>
                  </div>
                </div>
              </li>
            <?php else: ?>
              <li class="nav-item">
                <div class="dropdown mr-4 dropdown-link">
                  <a href="#" class="nav-link dropdown-link" id="account_settings" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <?php echo $_SESSION['login_name'] ?> <i class="fa fa-angle-down"></i>
                  </a>
                  <div class="dropdown-menu dropdown-link" aria-labelledby="account_settings">
                    <a class="dropdown-item" href="admin/index.php?page=home" id="manage_my_account"><i
                        class="fa Example of server fa-server"></i> Go to Panel</a>
                    <a class="dropdown-item" href="admin/ajax.php?action=logout2"><i class="fa fa-power-off"></i>
                      Logout</a>
                  </div>
                </div>
              </li>
            <?php endif; ?>
          </ul>
      </nav>
    </div>
  </header>
  <?php
  $page = isset($_GET['page']) ? $_GET['page'] : "attendance";
  include $page . '.php';
  ?>
  <div class="modal fade" id="confirm_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmation</h5>
        </div>
        <div class="modal-body">
          <div id="delete_content"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id='confirm' onclick="">Continue</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
          <button id="saveButton" type="button" class="btn btn-primary"
            onclick="$('#uni_modal form').submit()">Save</button>
          <button id="cancelButton" type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal_right" role='dialog'>
    <div class="modal-dialog modal-full-height  modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="fa fa-arrow-righ t"></span>
          </button>
        </div>
        <div class="modal-body">
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="viewer_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <img src="" alt="">
      </div>
    </div>
  </div>
  </main>
  <!-- End #main -->

  <?php include ('footer.php') ?>
</body>

<?php $conn->close() ?>

</html>