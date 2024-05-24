<?php
include ('db_connect.php');

$date = isset($_GET['date']) ? $_GET['date'] : '';
$showAll = isset($_GET['showAll']) ? $_GET['showAll'] === 'true' : false;

if ($showAll || empty($date)) {
    $query = "SELECT
		s.id,
		s.firstname,
		s.lastname,
		s.email,
		s.gender,
		s.age,
		s.student_id
	FROM students s
	WHERE s.status = 1
	ORDER BY s.id ASC";
} else {
    $query = "SELECT
		s.id,
		s.firstname,
		s.lastname,
		s.email,
		s.gender,
		s.age,
		s.student_id
	FROM students s
	JOIN attendance a ON s.id = a.student_id
	WHERE s.status = 1 AND a.date = '$date'
	ORDER BY s.id ASC";
}

$students = $conn->query($query);
$output = '';
$i = 1;
while ($row = $students->fetch_assoc()) {
    $output .= '<tr>
		<td class="text-center">' . $i++ . '</td>
		<td class="text-center">' . ucwords($row['lastname']) . '</td>
		<td class="text-center">' . ucwords($row['firstname']) . '</td>
		<td class="text-center">' . $row['email'] . '</td>
		<td class="text-center">' . $row['gender'] . '</td>
		<td class="text-center">' . $row['age'] . '</td>
		<td class="text-center">' . $row['student_id'] . '</td>
	</tr>';
}
echo $output;
?>