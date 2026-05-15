<?php
session_start();
require 'db.php';

// ADMIN CHECK
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'Admin') {
    header('Location: login.php');
    exit;
}

// Fetch all users
$result = $conn->query("SELECT * FROM users ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
    <div class="logo">Admin Panel</div>
    <div class="menu">
        <a href="admin-dashboard.php">Dashboard</a><br>
        <a href="manage-users.php">Users</a><br>
        <a href="admin-leave-requests.php">Leave Requests</a><br>
        <a href="logout.php">Logout</a>
    </div>
</nav>

<div class="container">

    <h2>Manage Users</h2>

    <!-- ADD USER -->
    <div class="admin-card">
        <h3>Add New User</h3>

        <form action="manage-users.php" method="POST">
            <input type="hidden" name="action" value="add">

            <label>Name</label>
            <input type="text" name="name" required class="form-input">

            <label>Email</label>
            <input type="email" name="email" required class="form-input">

            <label>Password</label>
            <input type="password" name="password" required class="form-input">

            <label>Role</label>
            <select name="role" class="form-input" required>
                <option value="User">User</option>
                <option value="Admin">Admin</option>
            </select>

            <button class="form-btn">Add User</button>
        </form>
    </div>

    <hr><br>

    <h3>All Users</h3>

    <table class="admin-table">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) : ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['role'] ?></td>
            <td><?= $row['created_at'] ?></td>
            <td>

                <!-- UPDATE ROLE -->
                <form method="POST" action="manage-users.php" style="display:inline;">
                    <input type="hidden" name="action" value="role">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <select name="role" onchange="this.form.submit()">
                        <option <?= $row['role'] == 'User' ? 'selected' : '' ?>>User</option>
                        <option <?= $row['role'] == 'Admin' ? 'selected' : '' ?>>Admin</option>
                    </select>
                </form>

                <!-- UPDATE PASSWORD -->
                <form method="POST" action="manage-users.php" style="display:inline;">
                    <input type="hidden" name="action" value="password">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <input type="password" name="password" placeholder="New Password" required>
                    <button class="approve">Update</button>
                </form>

                <!-- DELETE USER -->
                <form method="POST" action="manage-users.php" style="display:inline;">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <button class="reject" onclick="return confirm('Delete this user?')">Delete</button>
                </form>

            </td>
        </tr>
        <?php endwhile; ?>

    </table>

</div>

</body>
</html>

<?php
// HANDLE ACTIONS (ADD / DELETE / PASSWORD / ROLE)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $action = $_POST['action'];

    // ADD USER
    if ($action === "add") {

        $name = $_POST['name'];
        $email = $_POST['email'];
        $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role = $_POST['role'];

        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $pass, $role);
        $stmt->execute();

        header("Location: manage-users.php");
        exit;
    }

    // UPDATE ROLE
    if ($action === "role") {
        $id = $_POST['id'];
        $role = $_POST['role'];

        $stmt = $conn->prepare("UPDATE users SET role=? WHERE id=?");
        $stmt->bind_param("si", $role, $id);
        $stmt->execute();

        header("Location: manage-users.php");
        exit;
    }

    // UPDATE PASSWORD
    if ($action === "password") {
        $id = $_POST['id'];
        $newPass = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE users SET password=? WHERE id=?");
        $stmt->bind_param("si", $newPass, $id);
        $stmt->execute();

        header("Location: manage-users.php");
        exit;
    }

    // DELETE USER
    if ($action === "delete") {
        $id = $_POST['id'];

        $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        header("Location: manage-users.php");
        exit;
    }
}
?>
