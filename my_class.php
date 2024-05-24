<?php
session_start();
ini_set('display_errors', 1);

class Action
{
	private $db;

	public function __construct()
	{
		ob_start();
		include 'db_connect.php';

		$this->db = $conn;
	}
	function __destruct()
	{
		$this->db->close();
		ob_end_flush();
	}

	function login()
	{

		extract($_POST);
		$qry = $this->db->query("SELECT * FROM users where username = '" . $username . "' and password = '" . md5($password) . "' ");
		if ($qry->num_rows > 0) {
			foreach ($qry->fetch_array() as $key => $value) {
				if ($key != 'password' && !is_numeric($key))
					$_SESSION['login_' . $key] = $value;
			}
			if ($_SESSION['login_type'] != 1) {
				foreach ($_SESSION as $key => $value) {
					unset($_SESSION[$key]);
				}
				return 2;
				exit;
			}
			return 1;
		} else {
			return 3;
		}
	}
	function login2()
	{
		extract($_POST);
		if (isset($email))
			$username = $email;
		$qry = $this->db->query("SELECT * FROM users where username = '" . $username . "' and password = '" . md5($password) . "' ");
		if ($qry->num_rows > 0) {
			foreach ($qry->fetch_array() as $key => $value) {
				if ($key != 'password' && !is_numeric($key))
					$_SESSION['login_' . $key] = $value;
			}
			if ($_SESSION['login_students_id'] > 0) {
				$bio = $this->db->query("SELECT * FROM students where id = " . $_SESSION['login_students_id']);
				if ($bio->num_rows > 0) {
					foreach ($bio->fetch_array() as $key => $value) {
						if ($key != 'password' && !is_numeric($key))
							$_SESSION['bio'][$key] = $value;
					}
				}
			}
			if ($_SESSION['bio']['status'] != 1) {
				foreach ($_SESSION as $key => $value) {
					unset($_SESSION[$key]);
				}
				return 2;
				exit;
			}
			return 1;
		} else {
			return 3;
		}
	}
	function logout()
	{
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}
	function logout2()
	{
		// Clear session data
		session_unset();
		session_destroy();

		header("location:../index.php");
	}
	function save_user()
	{
		extract($_POST);

		$type = isset($type) ? $type : 1; // Set a default value for $type


		// Check if the provided username already exists for a different user
		$chk = $this->db->query("SELECT * FROM users WHERE username = '$username' AND id != '$id'")->num_rows;

		if ($chk > 0) {
			return 2; // Username already exists for another user
		}

		$data = "name = '$name', username = '$username'";

		// Check if a new password is provided, and hash it
		if (!empty($password)) {
			$data .= ", password = '" . md5($password) . "'";
		}

		$data .= ", type = '$type'";

		if (empty($id)) {
			// Insert a new user record
			$save = $this->db->query("INSERT INTO users SET " . $data);
		} else {
			// Update an existing user record
			$save = $this->db->query("UPDATE users SET " . $data . " WHERE id = " . $id);
		}

		if ($save) {
			return 1; // Success
		} else {
			// Log and return the SQL error message
			$error_message = $this->db->error;
			error_log("SQL Error: $error_message"); // Log the error
			return 0; // Database error
		}
	}



	function delete_user()
	{
		extract($_POST);

		// Check if the ID is set in the POST data
		if (!isset($_POST['id'])) {
			return '<span style="color: red;">No user ID provided</span>';
		}

		// Extract the ID from the POST data
		$id = $_POST['id'];

		// Check if the ID is valid
		if (!is_numeric($id)) {
			return '<span style="color: red;">Invalid user ID</span>';
		}

		// Check the user type before deletion
		$user = $this->db->query("SELECT type, students_id FROM users WHERE id = " . $id)->fetch_assoc();

		// Debugging: Check the value of the user variable
		var_dump($user);

		// Check if the user exists
		if (!$user) {
			return '<span style="color: red;">User not found</span>';
		}

		// Check the user type before deletion
		$user = $this->db->query("SELECT type, students_id FROM users WHERE id = " . $id)->fetch_assoc();

		// Check if the user exists
		if (!$user) {
			return '<span style="color: red;">User not found</span>';
		} else {
			// If the user has associated students_id, get the avatar filename from students
			$avatarFilename = '';
			if (!empty($user['students_id'])) {
				$avatarFilename = $this->db->query("SELECT avatar FROM students WHERE id = " . $user['students_id'])->fetch_assoc()['avatar'];
			}

			// Delete the user record
			$deleteUser = $this->db->query("DELETE FROM users WHERE id = " . $id);

			if ($deleteUser) {
				// If the user has associated students_id, delete the corresponding record in students
				if (!empty($user['students_id'])) {
					$deleteStudents = $this->db->query("DELETE FROM students WHERE id = " . $user['students_id']);
					if (!$deleteStudents) {
						// Handle any errors in deleting students record
						return '<span style="color: red;">Error deleting associated students record</span>';
					}
				}

				// If an avatar is associated with the user, delete the corresponding file
				if (!empty($avatarFilename)) {
					$avatarPath = $_SERVER['DOCUMENT_ROOT'] . '/afnaams/admin/assets/uploads/' . $avatarFilename;
					if (file_exists($avatarPath)) {
						unlink($avatarPath);
					}
				}

				return 1; // Deletion successful
			} else {
				// Handle any errors in deleting user record
				return '<span style="color: red;">Error deleting user record</span>';
			}
		}
	}



	function update_account()
	{
		extract($_POST);

		// Construct the data for the users table update
		$user_data = "name = '" . $firstname . ' ' . $lastname . "' ";
		$user_data .= ", username = '$email' ";
		if (!empty($password)) {
			$user_data .= ", password = '" . md5($password) . "' ";
		}

		// Update the user data in the users table
		$save_user = $this->db->query("UPDATE users SET $user_data WHERE id = '{$_SESSION['login_id']}' ");
		if ($save_user) {
			// Construct the data for updating student details
			$student_data = '';
			foreach ($_POST as $k => $v) {
				if ($k == 'password')
					continue;
				if (empty($student_data) && !is_numeric($k)) {
					$student_data = " $k = '$v' ";
				} else {
					$student_data .= ", $k = '$v' ";
				}
			}

			// Update student details in the students table
			$save_student = $this->db->query("UPDATE students SET $student_data WHERE id = '{$_SESSION['bio']['id']}' ");
			if ($save_student) {
				// Clear session data
				foreach ($_SESSION as $key => $value) {
					unset($_SESSION[$key]);
				}
				// Re-login
				$login = $this->login2();
				if ($login) {
					return 1; // Return success code 1
				}
			}
		}
		return 0; // Return failure code 0 if update fails
	}
	function update_student_acc()
	{
		extract($_POST);
		$update = $this->db->query("UPDATE students set status = $status where id = $id");
		if ($update)
			return 1;
	}


	function save_attendance()
	{
		extract($_POST);

		// Check if student_id is provided
		if (empty($student_id)) {
			return "Student ID is required.";
		}

		// Check if the student exists in the database and get the corresponding id
		$student_query = $this->db->query("SELECT id FROM students WHERE student_id = '$student_id'");
		if ($student_query->num_rows == 0) {
			return "Invalid Student ID.";
		}

		$student_row = $student_query->fetch_assoc();
		$student_id_int = $student_row['id'];

		// Get the current date
		$attendance_date = date('Y-m-d');

		// Check if attendance already exists for the student on the current date
		$attendance_check = $this->db->query("SELECT * FROM attendance WHERE student_id = '$student_id_int' AND date = '$attendance_date'");
		if ($attendance_check->num_rows > 0) {
			return "You have already present today.";
		}

		// Insert a new attendance record using the student's id
		$insert = $this->db->query("INSERT INTO attendance (student_id, date) VALUES ('$student_id_int', '$attendance_date')");

		if ($insert) {
			return "Attendance recorded successfully.";
		} else {
			return "Error recording attendance: " . $this->db->error;
		}
	}



}
