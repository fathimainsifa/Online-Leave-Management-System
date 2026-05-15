<?php
// ERROR REPORTING + SESSION START + ADMIN ROLE CHECK
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require 'db.php';

// Only allow Admin users
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'Admin') {
    header('Location: login.php');
    exit;
}

// --- Add new user process ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'User';

    // Hash password
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssss', $name, $email, $hash, $role);

    if (!$stmt->execute()) {
        echo "Insert failed: " . $stmt->error;
        exit;
    }
}

header('Location: admin-manage-users.php');
exit;
