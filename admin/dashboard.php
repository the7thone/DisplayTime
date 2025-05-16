<?php
include "auth_check.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard | DisplayTime</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .card:hover {
            transform: scale(1.02);
            transition: 0.3s;
        }
    </style>
</head>
<body class="p-4 bg-light">
<div class="container">
    <h2 class="mb-4">Welcome to the Admin Dashboard</h2>

    <div class="row g-4">
        <div class="col-md-3">
            <a href="manage_timetable.php" class="text-decoration-none">
                <div class="card text-white bg-primary">
                    <div class="card-body text-center">
                        <h5 class="card-title">🗓️ Timetable</h5>
                        <p class="card-text">Manage Timetable</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="manage_departments.php" class="text-decoration-none">
                <div class="card text-white bg-success">
                    <div class="card-body text-center">
                        <h5 class="card-title">🏫 Departments</h5>
                        <p class="card-text">Manage Departments</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="../public/index.php" target="_blank" class="text-decoration-none">
                <div class="card text-white bg-warning">
                    <div class="card-body text-center">
                        <h5 class="card-title">🌐 Public View</h5>
                        <p class="card-text">Student Timetable</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="logout.php" class="text-decoration-none">
                <div class="card text-white bg-danger">
                    <div class="card-body text-center">
                        <h5 class="card-title">🚪 Logout</h5>
                        <p class="card-text">Sign Out</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
</body>
</html>
