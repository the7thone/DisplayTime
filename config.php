<?php
$host = "localhost";
$dbname = "displaytime";
$user = "basit";
$pass = "1104";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
