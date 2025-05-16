<?php
include "auth_check.php";
include "../config.php";

// Add Department
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add'])) {
    $name = trim($_POST['name']);
    if ($name !== "") {
        $stmt = $conn->prepare("INSERT INTO departments (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        $stmt->execute();
    }
}

// Delete Department
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM departments WHERE id = $id");
}

// Fetch departments
$departments = $conn->query("SELECT * FROM departments ORDER BY name ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Departments</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
<div class="container">
    <h3>Manage Departments</h3>
    <a href="dashboard.php" class="btn btn-secondary mb-3">← Back to Dashboard</a>

    <form method="POST" class="row g-3 mb-4" style="max-width: 500px;">
        <div class="col-8">
            <input type="text" name="name" class="form-control" placeholder="New Department Name" required>
        </div>
        <div class="col-4">
            <button type="submit" name="add" class="btn btn-success w-100">Add Department</button>
        </div>
    </form>

    <table class="table table-bordered table-sm">
        <thead class="table-light">
        <tr>
            <th>#</th>
            <th>Department Name</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1; while($d = $departments->fetch_assoc()): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= htmlspecialchars($d['name']) ?></td>
                <td>
                    <a href="edit_department.php?id=<?= $d['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="?delete=<?= $d['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this department?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
