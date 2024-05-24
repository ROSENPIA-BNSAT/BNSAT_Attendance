<?php

$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'db_student_attendance';

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
  die("Could not connect to MySQL: " . $conn->connect_error);
}
