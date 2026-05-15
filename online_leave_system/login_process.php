<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $_SESSION['error'] = "Enter email and password.";
        header('Location: login.php'); exit;
    }

    $stmt = $conn->prepare("SELECT id, name, email, password, role FROM users WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($row = $res->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['role'] = $row['role'];

 // --- DEBUG START ---
            echo '<pre>';
            print_r($_SESSION);  // இப்போ session properly set ஆகிறதா பார்ப்போம்
            echo '</pre>';
            exit;  // redirect skip பண்ணி session output பார்க்க
    // --- DEBUG END ---






            if ($row['role'] === 'Admin') {
                header('Location: admin-dashboard.php');
            } else {
                header('Location: user-dashboard.php');
            }
            exit;
        } else {
            $_SESSION['error'] = "Invalid credentials.";
            header('Location: login.php'); exit;
        }
    } else {
        $_SESSION['error'] = "User not found.";
        header('Location: login.php'); exit;
    }
}
header('Location: login.php'); exit;
