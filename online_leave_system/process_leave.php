<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: admin-dashboard.php");
    exit;
}

$leave_id = $_POST['leave_id'] ?? '';
$action = $_POST['action'] ?? '';  // approve or reject

if ($leave_id === '' || $action === '') {
    die("Invalid request.");
}

$status = ($action === 'approve') ? 'Approved' : 'Rejected';

$sql = "UPDATE leaves SET status = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $status, $leave_id);

if ($stmt->execute()) {
    header("Location: admin-dashboard.php?msg=updated");
    exit;
} else {
    die("Failed to update leave.");
}
?>
