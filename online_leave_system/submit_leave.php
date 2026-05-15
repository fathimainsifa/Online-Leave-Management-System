<?php
// ERROR REPORTING ON (Very important)
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $user_id = $_SESSION['user_id'];
    $leave_type = $_POST['leaveType'] ?? '';
    $from = $_POST['fromDate'] ?? '';
    $to = $_POST['toDate'] ?? '';
    $reason = trim($_POST['reason'] ?? '');

    // Prepare insert query
    $stmt = $conn->prepare("INSERT INTO leaves (user_id, leave_type, from_date, to_date, reason) 
                            VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('issss', $user_id, $leave_type, $from, $to, $reason);
    $ok = $stmt->execute();

    if ($ok) {
        $_SESSION['success'] = "Leave submitted successfully.";
    } else {
        $_SESSION['error'] = "Failed to submit leave. Error: " . $stmt->error;
    }
}

header('Location: my-leaves.php');
exit;
