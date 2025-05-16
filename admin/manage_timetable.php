<?php
include "auth_check.php";
include "../config.php";

// Handle Add
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $dept_id = $_POST['department_id'];
    $course = $_POST['course_name'];
    $teacher = $_POST['teacher'];
    $room = $_POST['room'];
    $start = $_POST['start_time'];
    $end = $_POST['end_time'];
    $date = $_POST['date'];

    $stmt = $conn->prepare("INSERT INTO timetable (department_id, course_name, teacher, room, start_time, end_time, date)
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssss", $dept_id, $course, $teacher, $room, $start, $end, $date);
    $stmt->execute();
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM timetable WHERE id = $id");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Timetable - Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
<div class="container">
    <h3 class="mb-4">Manage Timetable</h3>
    <a href="dashboard.php" class="btn btn-secondary mb-3">← Back to Dashboard</a>

    <form method="POST" class="row g-3 mb-4">
        <div class="col-md-2">
            <select name="department_id" class="form-select" required>
                <option value="">Department</option>
                <?php
                $depts = $conn->query("SELECT * FROM departments");
                while ($d = $depts->fetch_assoc()) {
                    echo "<option value='{$d['id']}'>{$d['name']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-md-2">
            <input type="text" name="course_name" class="form-control" placeholder="Course" required>
        </div>
        <div class="col-md-2">
            <input type="text" name="teacher" class="form-control" placeholder="Teacher" required>
        </div>
        <div class="col-md-1">
            <input type="text" name="room" class="form-control" placeholder="Room" required>
        </div>
        <div class="col-md-1">
            <input type="time" name="start_time" class="form-control" required>
        </div>
        <div class="col-md-1">
            <input type="time" name="end_time" class="form-control" required>
        </div>
        <div class="col-md-2">
            <input type="date" name="date" class="form-control" required>
        </div>
        <div class="col-md-1">
            <button type="submit" name="add" class="btn btn-success w-100">Add</button>
        </div>
    </form>

    <table class="table table-bordered table-sm">
        <thead class="table-light">
        <tr>
            <th>#</th>
            <th>Department</th>
            <th>Course</th>
            <th>Teacher</th>
            <th>Room</th>
            <th>Start</th>
            <th>End</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $result = $conn->query("SELECT t.*, d.name AS dept_name 
                                        FROM timetable t 
                                        JOIN departments d ON t.department_id = d.id 
                                        ORDER BY t.date DESC, t.start_time");
        $i = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                        <td>{$i}</td>
                        <td>{$row['dept_name']}</td>
                        <td>{$row['course_name']}</td>
                        <td>{$row['teacher']}</td>
                        <td>{$row['room']}</td>
                        <td>{$row['start_time']}</td>
                        <td>{$row['end_time']}</td>
                        <td>{$row['date']}</td>
                        <td>
                        <a href='edit_timetable.php?id={$row['id']}' class='btn btn-sm btn-warning'>Edit</a>
                        <a href='?delete={$row['id']}' class='btn btn-sm btn-danger'
                        onclick=\"return confirm('Delete this entry?')\">Delete</a>
                        </td>
                    </tr>";
            $i++;
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
