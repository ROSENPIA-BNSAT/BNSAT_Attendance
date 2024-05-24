<?php include ('db_connect.php'); ?>
<!DOCTYPE html>
<html>

<head>
	<title>Students List</title>
	<style>
		.filter-wrapper {
			margin-top: 20px;
			margin-left: 20px;
		}

		.filter-wrapper .checkBox {
			margin-right: 10px;
		}
	</style>
</head>

<body>
	<div class="container-fluid">
		<div class="row mt-3">
			<div class="col-lg-12">
				<!-- Date Filter Form -->
				<div class="filter-wrapper">
					<form id="filterForm">
						<label for="date">Select Date:</label>
						<input type="date" id="date" name="date">
						<button type="submit">Filter</button>
					</form>
				</div>

				<!-- Table Panel -->
				<div class="card">
					<div class="card-header">
						<b>List of Students</b>
						<button class="btn btn-sm btn-outline-secondary toggle_attendance" type="button">
							Show All Students
						</button>
					</div>
					<div class="card-body table-responsive">
						<table id="myTable" class="table table-bordered table-sm table-striped nowrap compact">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Last Name</th>
									<th class="text-center">First Name</th>
									<th class="text-center">Email Address</th>
									<th class="text-center">Gender</th>
									<th class="text-center">Age</th>
									<th class="text-center">Student ID</th>
								</tr>
							</thead>
							<tbody>
								<!-- Data will be loaded here via AJAX -->
							</tbody>
						</table>
					</div>
				</div>
				<!-- End Table Panel -->
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function () {
			function loadStudents(date = '', showAll = false) {
				$.ajax({
					url: 'fetch_students.php',
					method: 'GET',
					data: { date: date, showAll: showAll },
					success: function (data) {
						$('#myTable tbody').html(data);
					}
				});
			}

			// Load all students initially
			loadStudents();

			// Handle form submission
			$('#filterForm').submit(function (e) {
				e.preventDefault();
				var date = $('#date').val();
				loadStudents(date);
			});

			// Toggle attendance button
			$('.toggle_attendance').click(function () {
				var showAll = $(this).text() === 'Show All Students';
				loadStudents('', showAll);
				$(this).text(showAll ? 'Show Students with Attendance' : 'Show All Students');
			});
		});
	</script>
</body>

</html>