<?php
session_start();

// Only logged-in users
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Dummy leave balance (you can fetch from DB if dynamic)
$leave_balance = [
    'Casual Leave' => 7,
    'Sick Leave' => 5,
    'Earned Leave' => 10
];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Balance - Online Leave System</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .balance-container { max-width: 500px; margin: 50px auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; background: #f9f9f9; }
        h2 { text-align: center; margin-bottom: 20px; }
        .balance p { font-size: 16px; margin: 10px 0; }
    </style>
</head>
<body>

    <div class="balance-container">
        <h2>Your Leave Balance</h2>
        <div class="balance">
            <p><strong>Casual Leave:</strong> <?php echo $leave_balance['Casual Leave']; ?> days</p>
            <p><strong>Sick Leave:</strong> <?php echo $leave_balance['Sick Leave']; ?> days</p>
            <p><strong>Earned Leave:</strong> <?php echo $leave_balance['Earned Leave']; ?> days</p>
        </div>
    </div>

</body>
</html>
