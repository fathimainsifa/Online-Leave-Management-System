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

// --- Delete user process ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);

    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param('i', $id);

    if (!$stmt->execute()) {
        echo "Delete failed: " . $stmt->error;
        exit;
    }
}

header('Location: admin-manage-users.php');
exit;
