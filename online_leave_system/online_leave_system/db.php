<?php
// db.php
$host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'leave_system';

$conn = new mysqli($host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("DB Connect Error: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
