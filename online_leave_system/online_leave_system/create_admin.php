<?php
require 'db.php';
$hash = password_hash('admin123', PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO users (name,email,password,role) VALUES (?, ?, ?, ?)");
$name='Admin'; $email='admin@example.com'; $role='Admin';
$stmt->bind_param('ssss', $name, $email, $hash, $role);
$stmt->execute();
echo "Admin created";
