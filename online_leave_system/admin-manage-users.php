<?php
// ERROR REPORTING + SESSION START + ADMIN ROLE CHECK
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require 'db.php';

// Only allow Admin users
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
    <title>Manage Users - Online Leave System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
    <div class="logo">Online Leave System - Admin</div>
    <div class="menu">
        <a href="#">Dashboard</a><br>
        <a href="#">Manage Users</a><br>
        <a href="#">Manage Leaves</a><br>
        <a href="#">Logout</a>
    </div>
</nav>

<div class="container">
    <h2>Manage Users</h2>

    <!-- Add User Form -->
    <div class="apply-form">
        <h3>Add New User</h3>
        <form action="add_user.php" method="POST">
            <label>Name</label>
            <input type="text" name="name" class="form-input" placeholder="Enter name" required>

            <label>Email</label>
            <input type="email" name="email" class="form-input" placeholder="Enter email" required>

            <label>Password</label>
            <input type="password" name="password" class="form-input" placeholder="Enter password" required>

            <label>Role</label>
            <select name="role" class="form-input">
                <option value="User">User</option>
                <option value="Admin">Admin</option>
            </select>

            <button type="submit" class="form-btn">Add User</button>
        </form>
    </div>

    <!-- User List Table -->
    <div class="apply-form" style="margin-top: 30px;">
        <h3>All Users</h3>

        <table class="user-table">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $result = $conn->query("SELECT * FROM users");
                while($user = $result->fetch_assoc()):
                ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['name']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['role']; ?></td>
                    <td>
                        <!-- Update Form -->
                        <form action="update_user.php" method="POST" style="display:inline-block;">
                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                            <input type="text" name="name" value="<?php echo $user['name']; ?>" required>
                            <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
                            <select name="role">
                                <option value="User" <?php if($user['role']=="User") echo 'selected'; ?>>User</option>
                                <option value="Admin" <?php if($user['role']=="Admin") echo 'selected'; ?>>Admin</option>
                            </select>
                            <button type="submit">Update</button>
                        </form>

                        <!-- Delete Form -->
                        <form action="delete_user.php" method="POST" style="display:inline-block;">
                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                            <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>

                        <!-- Reset Password Form -->
                        <form action="reset_password.php" method="POST" style="display:inline-block;">
                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                            <button type="submit">Reset Password</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>
