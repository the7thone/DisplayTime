<?php
include "./config.php";

// Get departments
$departments = $conn->query("SELECT * FROM departments ORDER BY name ASC");

$timetable = [];
$selectedDept = null;
$selectedDate = null;

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['department_id']) && isset($_GET['date'])) {
    $selectedDept = intval($_GET['department_id']);
    $selectedDate = $_GET['date'];

    $stmt = $conn->prepare("SELECT t.*, d.name AS department FROM timetable t
                            JOIN departments d ON t.department_id = d.id
                            WHERE t.department_id = ? AND t.date = ?
                            ORDER BY t.start_time ASC");
    $stmt->bind_param("is", $selectedDept, $selectedDate);
    $stmt->execute();
    $timetable = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Timetable | DisplayTime</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
<div class="container">
    <h2 class="mb-4">📅 View Timetable</h2>

    <form method="GET" class="row g-3 mb-4" style="max-width: 700px;">
        <div class="col-md-5">
            <select name="department_id" class="form-select" required>
                <option value="">-- Select Department --</option>
                <?php while ($dept = $departments->fetch_assoc()): ?>
                    <option value="<?= $dept['id'] ?>" <?= ($dept['id'] == $selectedDept) ? "selected" : "" ?>>
                        <?= htmlspecialchars($dept['name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-4">
            <input type="date" name="date" class="form-control" value="<?= htmlspecialchars($selectedDate) ?>" required>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary w-100">Search</button>
        </div>
    </form>

    <?php if ($timetable && $timetable->num_rows > 0): ?>
        <table class="table table-bordered table-striped">
            <thead class="table-light">
            <tr>
                <th>Time</th>
                <th>Course</th>
                <th>Teacher</th>
                <th>Room</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = $timetable->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['start_time'] ?> - <?= $row['end_time'] ?></td>
                    <td><?= htmlspecialchars($row['course_name']) ?></td>
                    <td><?= htmlspecialchars($row['teacher']) ?></td>
                    <td><?= htmlspecialchars($row['room']) ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php elseif ($selectedDept && $selectedDate): ?>
        <div class="alert alert-warning">No classes found for selected department and date.</div>
    <?php endif; ?>
</div>
</body>
</html>