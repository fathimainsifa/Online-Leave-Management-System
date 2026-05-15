<?php
// Error reporting ON
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require 'db.php';

// User login check
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user's leaves
$stmt = $conn->prepare("SELECT * FROM leaves WHERE user_id = ? ORDER BY id DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Leaves - Online Leave System</title>
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
        <h2>My Leave Applications</h2>

        <?php if (isset($_SESSION['success'])): ?>
            <p class="success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></p>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <p class="error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php endif; ?>

        <table border="1" cellpadding="10" width="100%">
            <tr>
                <th>Type</th>
                <th>From</th>
                <th>To</th>
                <th>Reason</th>
                <th>Status</th>
            </tr>

            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['leave_type']); ?></td>
                <td><?= htmlspecialchars($row['from_date']); ?></td>
                <td><?= htmlspecialchars($row['to_date']); ?></td>
                <td><?= htmlspecialchars($row['reason']); ?></td>
                <td>
                    <?php
                        if ($row['status'] === 'Pending') echo "<span style='color: orange;'>Pending</span>";
                        else if ($row['status'] === 'Approved') echo "<span style='color: green;'>Approved</span>";
                        else if ($row['status'] === 'Rejected') echo "<span style='color: red;'>Rejected</span>";
                    ?>
                </td>
            </tr>
            <?php endwhile; ?>

        </table>
    </div>

</body>
</html>
