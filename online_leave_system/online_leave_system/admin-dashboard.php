<?php
// ERROR REPORTING + SESSION START + ADMIN ROLE CHECK
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'Admin') {
    header('Location: login.php');
    exit;
}
?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Online Leave System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <nav class="navbar">
        <div class="logo">Online Leave System - Admin</div>
        <div class="menu">
            <a href="#">Dashboard</a><br>
            <a href="#">Users</a><br>
            <a href="#">Leave Requests</a><br>
            <a href="#">Holidays</a><br>
            <a href="#">Logout</a>
        </div>
    </nav>

    <div class="container">

        <h2>Admin Dashboard</h2>

        <div class="admin-grid">

            <!-- User Details -->
            <div class="admin-card">
                <h3>User Details</h3>
                <p>Manage all registered users.</p>
                <a href="#" class="btn">Manage Users</a>
            </div>

            <!-- Leave Requests -->
            <div class="admin-card">
                <h3>Leave Requests</h3>
                <p>View and manage leave applications.</p>
                <a href="#" class="btn">View Requests</a>
            </div>

            <!-- Holiday Management -->
            <div class="admin-card">
                <h3>Holiday Management</h3>
                <p>Add or edit holiday list.</p>
                <a href="#" class="btn">Manage Holidays</a>
            </div>

            <!-- Notifications -->
            <div class="admin-card">
                <h3>Notifications</h3>
                <p>Send alerts or announcements.</p>
                <a href="#" class="btn">Send Notification</a>
            </div>

        </div>

        <!-- Pending Leave Table -->
        <h3 style="margin-top: 40px;">Pending Leave Requests</h3>

        <table class="admin-table">
            <tr>
                <th>User</th>
                <th>Type</th>
                <th>From</th>
                <th>To</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <tr>
                <td>Fathima</td>
                <td>Sick Leave</td>
                <td>2025-11-20</td>
                <td>2025-11-22</td>
                <td>Fever</td>
                <td>Pending</td>
                <td>
                    
                        <form action="approve_leave.php" method="POST" style="display:inline">
                            <input type="hidden" name="leave_id" value="1">
                            <button class="approve">Approve</button>
                        </form>

                        <form action="reject_leave.php" method="POST" style="display:inline">
                            <input type="hidden" name="leave_id" value="1">
                            <button class="reject">Reject</button>
                        </form>
                    

                </td>
            </tr>

            <tr>
                <td>pooja</td>
                <td>Casual Leave</td>
                <td>2025-11-25</td>
                <td>2025-11-26</td>
                <td>Family Function</td>
                <td>Pending</td>
                <td>
                    
                        <form action="approve_leave.php" method="POST" style="display:inline">
                            <input type="hidden" name="leave_id" value="2">
                            <button class="approve">Approve</button>
                        </form>

                       <form action="reject_leave.php" method="POST" style="display:inline">
                           <input type="hidden" name="leave_id" value="2">
                           <button class="reject">Reject</button>
                       </form>
                

                </td>
            </tr>

        </table>

    </div>

</body>
</html>
