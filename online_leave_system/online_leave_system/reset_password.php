<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'Admin') { header('Location: login.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $newpass = $_POST['new_password'] ?? 'password123';
    $hash = password_hash($newpass, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->bind_param('si', $hash, $id);
    $stmt->execute();
}
header('Location: admin-manage-users.php'); exit;
