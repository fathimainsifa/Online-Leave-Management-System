<?php
session_start();

// USER ROLE CHECK
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
    <title>Apply Leave - Online Leave System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- NAVBAR -->
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

        <h2>Apply for Leave</h2>

        <!-- Leave Balance Box -->
        <div class="leave-balance-card">
            <h3>Your Leave Balance</h3>
            <p>Casual Leave: <strong>7 days</strong></p>
            <p>Sick Leave: <strong>5 days</strong></p>
            <p>Earned Leave: <strong>10 days</strong></p>
        </div>

        <!-- Apply Leave Form -->
        <div class="apply-form">

            <form action="submit_leave.php" method="POST">

                <!-- Leave Type -->
                <label for="leaveType">Leave Type</label>
                <select id="leaveType" name="leaveType" class="form-input" required>
                    <option value="">-- Select Leave Type --</option>
                    <option value="Casual Leave">Casual Leave</option>
                    <option value="Sick Leave">Sick Leave</option>
                    <option value="Earned Leave">Earned Leave</option>
                </select>

                <!-- From Date -->
                <label for="fromDate">From Date</label>
                <input type="date" id="fromDate" name="fromDate" class="form-input" required>

                <!-- To Date -->
                <label for="toDate">To Date</label>
                <input type="date" id="toDate" name="toDate" class="form-input" required>

                <!-- Reason -->
                <label for="reason">Reason for Leave</label>
                <textarea id="reason" name="reason" class="form-input" rows="4" placeholder="Enter your reason here..." required></textarea>

                <!-- Submit Button -->
                <button type="submit" class="form-btn">Submit Leave Request</button>

            </form>
        </div>

    </div>

</body>
</html>
