<?php
// --- ERROR REPORTING + SESSION START ---
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Online Leave System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="login-container">
    <h2>Login</h2>

    <!-- Display error or success messages -->
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="error-msg"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="success-msg"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <form action="login_process.php" method="POST">
        <label for="email">Email / Username</label>
        <input type="text" id="email" name="email" placeholder="Enter your email" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>

        <label>User Role</label>
        <select class="role-select" name="role">
            <option value="User">User</option>
            <option value="Admin">Admin</option>
        </select>

        <button type="submit">Login</button>

        <p class="footer-text">
            Forgot password? <a href="#">Click here</a>
        </p>
    </form>
</div>

</body>
</html>
