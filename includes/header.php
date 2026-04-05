<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blood Donation System</title>
    <link rel="stylesheet" href="/BloodDonationManagementSystem/assets/style.css">
</head>
<body>
    <div>
        <a href="/BloodDonationManagementSystem/index.php">Home</a> |
        <a href="/BloodDonationManagementSystem/public/login.php">Login</a> |
        <a href="/BloodDonationManagementSystem/public/register.php">Register</a>

        <?php if (isset($_SESSION['user_id'])): ?>
            | <a href="/BloodDonationManagementSystem/public/dashboard.php">Dashboard</a>
            | <a href="/BloodDonationManagementSystem/public/logout.php">Logout</a>
        <?php endif; ?>
    </div>

    <hr>