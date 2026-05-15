<?php
session_start();

// Dummy login session (for testing)
// Remove this block if actual login system is implemented
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1;
    $_SESSION['role'] = 'User';
    $_SESSION['name'] = 'Fathima';
}

// Only allow logged-in users
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'User') {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Online Leave System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <nav class="navbar">
        <div class="logo">Online Leave System</div>
        <div class="menu">
            <a href="user-dashboard.php">Dashboard</a><br>
            <a href="apply-leave.php">Apply Leave</a><br>
            <a href="my-leaves.php">My Leaves</a><br>
            <a href="logout.php">Logout</a>
        </div>
    </nav>

    <div class="container">
        <h2>Welcome, <?php echo $_SESSION['name']; ?></h2>

        <div class="cards">
            <!-- Apply Leave -->
            <div class="card">
                <h3>Apply for Leave</h3>
                <p>Submit a new leave request.</p>
                <a href="apply-leave.php" class="btn">Apply Now</a>
            </div>

            <!-- Other cards -->
        </div>
    </div>

</body>
</html>
