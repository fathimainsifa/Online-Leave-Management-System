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

// --- Update user process ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = $_POST['role'] ?? 'User';

    $stmt = $conn->prepare("UPDATE users SET name=?, email=?, role=? WHERE id=?");
    $stmt->bind_param('sssi', $name, $email, $role, $id);

    if (!$stmt->execute()) {
        echo "Update failed: " . $stmt->error;
        exit;
    }
}

header('Location: admin-manage-users.php');
exit;
