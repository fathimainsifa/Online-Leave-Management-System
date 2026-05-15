<?php
session_start();
require 'db.php';

// Admin login check
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'Admin') {
    header('Location: login.php');
    exit;
}

// Add Holiday
if (isset($_POST['add'])) {
    $date = $_POST['date'];
    $description = $_POST['description'];
    $stmt = $conn->prepare("INSERT INTO holidays (date, description) VALUES (?, ?)");
    $stmt->bind_param("ss", $date, $description);
    $stmt->execute();
    $stmt->close();
    header("Location: manage-holidays.php");
    exit;
}

// Delete Holiday
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM holidays WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: manage-holidays.php");
    exit;
}

// Update Holiday
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $date = $_POST['date'];
    $description = $_POST['description'];
    $stmt = $conn->prepare("UPDATE holidays SET date=?, description=? WHERE id=?");
    $stmt->bind_param("ssi", $date, $description, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: manage-holidays.php");
    exit;
}

// Fetch Holidays
$result = $conn->query("SELECT * FROM holidays ORDER BY date ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Holidays</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container">
    <h2>Manage Holidays</h2>

    <!-- Add Holiday Form -->
    <form method="post">
        <input type="date" name="date" required>
        <input type="text" name="description" placeholder="Holiday Description" required>
        <button type="submit" name="add">Add Holiday</button>
    </form>

    <!-- Holidays Table -->
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['date']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td>
                <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                <!-- Edit Form Inline -->
                <form method="post" style="display:inline-block;">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <input type="date" name="date" value="<?php echo $row['date']; ?>" required>
                    <input type="text" name="description" value="<?php echo $row['description']; ?>" required>
                    <button type="submit" name="update">Update</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
