<?php
$host = "localhost";
$dbname = "admin_db";
$user = "root";  // Change this if needed
$pass = "";  // Set your database password

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>