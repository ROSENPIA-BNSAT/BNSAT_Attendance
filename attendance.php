<?php
include 'admin/db_connect.php';
include 'auth_check.php';
?>

<head>
    <title>Attendance</title>
</head>
<style>
    body {
        font-family: 'Poppins', sans-serif;
    }

    .masthead {
        min-height: 23vh !important;
        height: 23vh !important;
    }

    .masthead:before {
        min-height: 23vh !important;
        height: 23vh !important;
    }

    img#cimg {
        max-height: 10vh;
        max-width: 6vw;
    }

    .password-container {
        position: relative;
    }

    .EyePass {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translate(0, -50%);
        cursor: pointer;
    }

    #eye {
        font-size: 15px;
        color: #7a797e;
    }

    /* Style for the form */
    .attendance-form {
        max-width: 500px;
        margin: 0 auto;
    }

    .attendance-form label {
        display: block;
        margin-bottom: 10px;
    }

    .attendance-form input[type="text"] {
        width: 100%;
        padding: 8px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .attendance-form button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .attendance-form button:hover {
        background-color: #45a049;
    }
</style>
<section id="hero-about" class="d-flex align-items-center">
</section>
<section>
    <div class="container">
        <div class="d-flex justify-content-center" data-aos="zoom-out" data-aos-delay="500">
            <h1 class="text-center">Attendance for today</h1>
        </div>
        <div class="d-flex justify-content-center">
            <h3 class="datetime-display" id="datetime">
                <!-- Date and time will be displayed here -->
            </h3>
        </div>
        <div class="attendance-form">
            <form id="attendanceForm">
                <label for="student_id">Enter Student ID:</label>
                <input type="text" id="student_id" name="student_id" placeholder="Student ID" required>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            if (typeof openLoginModal !== 'undefined' && openLoginModal) {
                uni_modal("Login", "popup.php");
            }

            // Automatically record attendance when student ID is entered
            $('#student_id').on('keyup', function (e) {
                if (this.value.length === 11) { // assuming the student ID has 11 characters
                    recordAttendance(this.value);
                    this.value = ''; // Clear the input field
                }
            });
        });

        function recordAttendance(studentId) {
            if (studentId === "") {
                alert("Please enter a Student ID.");
                return;
            }

            $.ajax({
                url: 'admin/ajax.php?action=save_attendance',
                data: { student_id: studentId },
                method: 'POST',
                success: function (resp) {
                    alert(resp);
                },
                error: function () {
                    alert("An error occurred while processing the request.");
                }
            });
        }

        // Function to update the date and time
        function updateDateTime() {
            var now = new Date();
            var options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric',
                hour12: false
            };
            var dateTimeString = now.toLocaleDateString('en-US', options);
            document.getElementById('datetime').textContent = dateTimeString;
        }

        // Update the date and time every second
        setInterval(updateDateTime, 1000);
        updateDateTime(); // Initial call to display the date and time immediately
    </script>
</section>