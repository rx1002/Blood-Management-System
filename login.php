<?php
require_once '../config/db.php';
require_once '../includes/functions.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

$error = "";
$email = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!validateCSRF($_POST['csrf_token'])) {
        $error = "Invalid request!";
    } else {
        $email    = cleanInput($_POST['email']);
        $password = cleanInput($_POST['password']);

        if (empty($email) || empty($password)) {
            $error = "Email and password are required!";
        } elseif (!validateEmail($email)) {
            $error = "Invalid email format!";
        } elseif (!loginUser($pdo, $email, $password)) {
            $error = "Invalid email or password!";
        } else {
            header("Location: dashboard.php");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login – Blood Management System</title>
    <link rel="stylesheet" href="auth.css">
</head>
<body class="login-page">

<div class="container">

    <!-- Left Panel -->
    <div class="left-panel">
        <h1>Welcome</h1>

        <!-- Blood drop icon
        <svg class="blood-icon" viewBox="0 0 100 130" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M50 8C50 8 12 58 12 82C12 107 29 124 50 124C71 124 88 107 88 82C88 58 50 8 50 8Z"
                  fill="rgba(255,255,255,0.2)" stroke="rgba(255,255,255,0.5)" stroke-width="3"/>
            <polyline points="22,84 32,84 38,68 44,98 50,74 56,90 62,80 70,80 78,80"
                      stroke="rgba(255,255,255,0.9)" stroke-width="3.5"
                      stroke-linecap="round" stroke-linejoin="round" fill="none"/>
        </svg> -->

        <p>To Blood Management System</p>
    </div>

    <!-- Right Panel -->
    <div class="right-panel">
        <div class="form-box">
            <h2>Login</h2>

            <?php if ($error): ?>
                <div class="error-msg"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST">

                <label>Email</label>
                <input type="text" name="email" value="<?= htmlspecialchars($email) ?>">

                <label>Password</label>
                <input type="password" name="password">

                <a href="forget_password.php" class="forgot-link">Forgot Password?</a>

                <input type="hidden" name="csrf_token" value="<?= generateCSRF() ?>">

                <button type="submit" class="btn-primary">Login</button>

                <hr class="divider">

                <p class="form-footer">Don't have an account?</p>
                <a href="register.php" class="btn-primary" style="display:block; text-align:center; text-decoration:none;">Signup</a>

            </form>

            <p class="copyright">© 2026 Blood Donation System</p>
        </div>
    </div>

</div>

</body>
</html>