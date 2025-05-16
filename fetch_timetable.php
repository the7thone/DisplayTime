<?php
include "config.php";

$dept_id = $_POST['department_id'];
$date = $_POST['date'];

$sql = "SELECT t.*, d.name AS dept_name 
        FROM timetable t
        JOIN departments d ON t.department_id = d.id
        WHERE t.department_id = ? AND t.date = ?
        ORDER BY t.start_time";

$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $dept_id, $date);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<h4 class='mb-3'>Timetable for " . date("d M Y", strtotime($date)) . "</h4>";
    echo "<table class='table table-bordered'>";
    echo "<thead><tr><th>Course</th><th>Teacher</th><th>Room</th><th>Start</th><th>End</th></tr></thead><tbody>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row['course_name']}</td>
            <td>{$row['teacher']}</td>
            <td>{$row['room']}</td>
            <td>{$row['start_time']}</td>
            <td>{$row['end_time']}</td>
        </tr>";
    }
    echo "</tbody></table>";
} else {
    echo "<div class='alert alert-warning'>No timetable found for the selected date and department.</div>";
}
?>
