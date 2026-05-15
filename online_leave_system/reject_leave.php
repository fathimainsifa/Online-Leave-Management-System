<?php
// --- ERROR REPORTING + SESSION START + ADMIN ROLE CHECK ---
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require 'db.php';

// Only allow Admin users
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'Admin') {
    header('Location: login.php');
    exit;
}

// --- REJECT LEAVE PROCESS ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['leave_id'] ?? 0);

    $stmt = $conn->prepare("UPDATE leaves SET status='Rejected' WHERE id = ?");
    $stmt->bind_param('i', $id);

    if (!$stmt->execute()) {
        echo "Error rejecting leave: " . $stmt->error;
        exit;
    }
}

// Redirect back to admin dashboard
header('Location: admin-dashboard.php');
exit;
