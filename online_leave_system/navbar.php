<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<nav style="background:#333; padding:15px;">
    <a href="admin-dashboard.php" style="color:white; margin-right:20px;">Dashboard</a>
    <a href="manage-users.php" style="color:white; margin-right:20px;">Users</a>
    <a href="manage-leaves.php" style="color:white; margin-right:20px;">Leaves</a>
    <a href="manage-holidays.php" style="color:white; margin-right:20px;">Holidays</a>
    <a href="logout.php" style="color:white;">Logout</a>
</nav>
