<?php include 'db_connect.php'; ?>
<title>Dashboard</title>

<style>
  span.float-right.summary_icon {
    font-size: 4rem;
    position: absolute;
    right: 1rem;
    color: #ffffff96;
  }

  .card {
    border: none;
    border-radius: 10px;
    overflow: hidden;
  }

  .Cards {
    padding: 20px;
    min-height: 150px;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .Cards h1,
  .Cards p {
    text-align: left;
    margin: 0;
    letter-spacing: 2px;
  }

  .Cards h1 {
    font-size: 2.5rem;
  }
</style>

<div class="container-fluid">
  <div class="row mt-3 ">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-4">
          <div class="card">
            <a href="index.php?page=list_students">
              <div class="card-body bg-success">
                <div class="card-body Cards text-white">
                  <span class="float-right summary_icon"><i class="fa-solid fa-users-line"></i></span>
                  <h1><b class="count-up">
                      <?php echo $conn->query("SELECT * FROM students where status = 1")->num_rows; ?>
                    </b></h1>
                  <p><b>Total Students</b></p>
                </div>
              </div>
            </a>
          </div>
        </div>

      </div><br>
    </div>
    <script>
      $(document).ready(function () {
        $('.count-up').each(function () {
          var $this = $(this);
          $({ Counter: 0 }).animate({ Counter: $this.text() }, {
            duration: 1000,
            easing: 'swing',
            step: function () {
              $this.text(Math.ceil(this.Counter));
            },
            complete: function () {
              $this.text($this.text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
            }
          }).delay(1000);
        });
      });
    </script>


  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>