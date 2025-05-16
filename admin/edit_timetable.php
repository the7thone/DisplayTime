<?php
include "auth_check.php";
include "../config.php";

$id = $_GET['id'];
$error = "";
$success = "";

// Fetch current data
$stmt = $conn->prepare("SELECT * FROM timetable WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$timetable = $result->fetch_assoc();

if (!$timetable) {
    die("Entry not found.");
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dept_id = $_POST['department_id'];
    $course = $_POST['course_name'];
    $teacher = $_POST['teacher'];
    $room = $_POST['room'];
    $start = $_POST['start_time'];
    $end = $_POST['end_time'];
    $date = $_POST['date'];

    $update = $conn->prepare("UPDATE timetable SET department_id = ?, course_name = ?, teacher = ?, room = ?, start_time = ?, end_time = ?, date = ? WHERE id = ?");
    $update->bind_param("issssssi", $dept_id, $course, $teacher, $room, $start, $end, $date, $id);

    if ($update->execute()) {
        $success = "Timetable updated successfully!";
        // Refresh data
        $timetable = [
            "department_id" => $dept_id,
            "course_name" => $course,
            "teacher" => $teacher,
            "room" => $room,
            "start_time" => $start,
            "end_time" => $end,
            "date" => $date
        ];
    } else {
        $error = "Failed to update record.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Timetable Entry</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
<div class="container" style="max-width: 700px;">
    <h3>Edit Timetable Entry</h3>
    <a href="manage_timetable.php" class="btn btn-secondary mb-3">← Back to Management</a>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" class="row g-3">
        <div class="col-md-6">
            <label>Department</label>
            <select name="department_id" class="form-select" required>
                <option value="">Select</option>
                <?php
                $depts = $conn->query("SELECT * FROM departments");
                while ($d = $depts->fetch_assoc()) {
                    $selected = $timetable['department_id'] == $d['id'] ? "selected" : "";
                    echo "<option value='{$d['id']}' $selected>{$d['name']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-md-6">
            <label>Course</label>
            <input type="text" name="course_name" class="form-control" value="<?= $timetable['course_name'] ?>" required>
        </div>
        <div class="col-md-6">
            <label>Teacher</label>
            <input type="text" name="teacher" class="form-control" value="<?= $timetable['teacher'] ?>" required>
        </div>
        <div class="col-md-6">
            <label>Room</label>
            <input type="text" name="room" class="form-control" value="<?= $timetable['room'] ?>" required>
        </div>
        <div class="col-md-3">
            <label>Start Time</label>
            <input type="time" name="start_time" class="form-control" value="<?= $timetable['start_time'] ?>" required>
        </div>
        <div class="col-md-3">
            <label>End Time</label>
            <input type="time" name="end_time" class="form-control" value="<?= $timetable['end_time'] ?>" required>
        </div>
        <div class="col-md-6">
            <label>Date</label>
            <input type="date" name="date" class="form-control" value="<?= $timetable['date'] ?>" required>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary w-100">Update Entry</button>
        </div>
    </form>
</div>
</body>
</html>
