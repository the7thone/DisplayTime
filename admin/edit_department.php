<?php
include "auth_check.php";
include "../config.php";

$id = $_GET['id'];
$error = "";
$success = "";

// Get current name
$stmt = $conn->prepare("SELECT * FROM departments WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$dept = $stmt->get_result()->fetch_assoc();

if (!$dept) die("Department not found.");

// Handle update
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $newName = trim($_POST['name']);
    if ($newName !== "") {
        $stmt = $conn->prepare("UPDATE departments SET name = ? WHERE id = ?");
        $stmt->bind_param("si", $newName, $id);
        if ($stmt->execute()) {
            $success = "Updated successfully.";
            $dept['name'] = $newName;
        } else {
            $error = "Update failed.";
        }
    } else {
        $error = "Name cannot be empty.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Department</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
<div class="container" style="max-width: 500px;">
    <h3>Edit Department</h3>
    <a href="manage_departments.php" class="btn btn-secondary mb-3">← Back to Management</a>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label>Department Name</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($dept['name']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Update</button>
    </form>
</div>
</body>
</html>
