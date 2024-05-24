<style>
  nav#sidebar {
    background: #2C3E50;
    height: 100%;
    position: fixed;
    width: 250px;
    z-index: 1;
    overflow-x: hidden;
    transition: 0.5s;
  }

  .sidebar-list {
    padding: 0;
    list-style: none;
    margin-top: 3px;
  }

  .nav-item {
    padding: 10px;
    text-decoration: none;
    font-size: 16px;
    color: #ecf0f1;
    display: block;
    transition: 0s;
  }

  .nav-item:hover {
    background-color: #1F2933;
    color: #ffffff;
  }

  .nav-item:not(.active) {
    background-color: #2C3E50;
    color: #fff;
  }

  .active {
    background-color: #1F2933;
    color: #ffffff;
  }

  .icon-field {
    margin-right: 10px;
  }

  .brand-logo {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px;
    margin-top: -20px;
  }

  .brand-logo img {
    max-width: 100%;
    height: auto;
  }
</style>

<nav id="sidebar">
  <div class="sidebar-list">
    <a href="index.php?page=home" class="nav-item nav-home active">
      <span class='icon-field'><i class="fa-solid fa-gauge"></i></span> Dashboard
    </a>

    <a href="index.php?page=list_students" class="nav-item nav-list_students">
      <span class='icon-field'>
        <i class="fa-solid fa-users-line"></i>
      </span> All students
    </a>
    <a href="index.php?page=users" class="nav-item nav-users">
      <span class='icon-field'><i class="fa-solid fa-users-gear"></i></span> Manage Students
    </a>
  </div>
</nav>

<script>
  $('.nav_collapse').click(function () {
    console.log($(this).attr('href'))
    $($(this).attr('href')).collapse()
  })
  $('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
  if ('<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>' !== 'home') {
    $('.nav-home').removeClass('active');
  }
</script>