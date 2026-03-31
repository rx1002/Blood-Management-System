<?php
require_once '../includes/functions.php';

checkSessionTimeout();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];
?>

<?php include '../includes/header.php'; ?>

<h2>Dashboard</h2>

<p>Welcome! Role: <?= htmlspecialchars($role) ?></p>

<?php if ($role === 'admin'): ?>
    <h3>Admin Panel</h3>
    <ul>
        <li><a href="#">Manage Users</a></li>
        <li><a href="#">View Reports</a></li>
    </ul>
<?php elseif ($role === 'donor'): ?>
    <h3>Donor Panel</h3>
    <ul>
        <li><a href="#">View Donation Requests</a></li>
        <li><a href="#">My Donations</a></li>
    </ul>
<?php endif; ?>

<br>
<a href="logout.php">Logout</a>

<?php include '../includes/footer.php'; ?>