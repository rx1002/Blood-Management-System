<?php
require_once '../includes/functions.php';
require_once '../config/db.php';

$error   = "";
$success = "";
$email   = "";
$role    = "donor";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email            = cleanInput($_POST['email']);
    $password         = cleanInput($_POST['password']);
    $confirm_password = cleanInput($_POST['confirm_password']);
    $role             = $_POST['role'] ?? 'donor';

    if (!isset($_POST['csrf_token']) || !validateCSRF($_POST['csrf_token'])) {
        $error = "Invalid request!";
    } elseif (empty($email) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required!";
    } elseif (!validateEmail($email)) {
        $error = "Invalid email format!";
    } elseif (!validatePassword($password)) {
        $error = "Password must be at least 6 characters!";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } elseif (!registerUser($pdo, $email, $password, $role)) {
        $error = "Email may already exist!";
    } else {
        $success = "Signup successful! You can now login.";
        $email = "";
        $role  = "donor";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up – Blood Management System</title>
    <link rel="stylesheet" href="auth.css">
</head>
<body class="signup-page">

<div class="container">

    <!-- Left Panel -->
    <div class="left-panel">
        <h1>Sign Up</h1>

        <!-- Blood drop icon
        <svg class="blood-icon" viewBox="0 0 100 130" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M50 8C50 8 12 58 12 82C12 107 29 124 50 124C71 124 88 107 88 82C88 58 50 8 50 8Z"
                  fill="rgba(255,255,255,0.2)" stroke="rgba(255,255,255,0.5)" stroke-width="3"/>
            <polyline points="22,84 32,84 38,68 44,98 50,74 56,90 62,80 70,80 78,80"
                      stroke="rgba(255,255,255,0.9)" stroke-width="3.5"
                      stroke-linecap="round" stroke-linejoin="round" fill="none"/>
        </svg> -->

        <p>Provide your details to help connect donors and save lives</p>
    </div>

    <!-- Right Panel -->
    <div class="right-panel">
        <div class="form-box">
            <h2>Create your account</h2>

            <?php if ($success): ?>
                <div class="success-msg"><?= $success ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="error-msg"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-grid">

                    <!-- Row 1 -->
                    <div>
                        <label>First Name</label>
                        <input type="text" name="first_name"
                            value="<?= isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : '' ?>">
                    </div>
                    <div>
                        <label>Last Name</label>
                        <input type="text" name="last_name"
                            value="<?= isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : '' ?>">
                    </div>

                    <!-- Row 2 -->
                    <div>
                        <label>Contact Number</label>
                        <input type="text" name="contact_number"
                            value="<?= isset($_POST['contact_number']) ? htmlspecialchars($_POST['contact_number']) : '' ?>">
                    </div>
                    <div>
                        <label>Address</label>
                        <input type="text" name="address"
                            value="<?= isset($_POST['address']) ? htmlspecialchars($_POST['address']) : '' ?>">
                    </div>

                    <!-- Row 3: Email (wide) | Gender | Age -->
                    <div>
                        <label>Email</label>
                        <input type="text" name="email" value="<?= htmlspecialchars($email) ?>">
                    </div>
                    <div style="display:flex; gap:8px;">
                        <div style="flex:1;">
                            <label>Gender</label>
                            <select name="gender">
                                <option value="male"   <?= (isset($_POST['gender']) && $_POST['gender']=='male')   ? 'selected':'' ?>>Male</option>
                                <option value="female" <?= (isset($_POST['gender']) && $_POST['gender']=='female') ? 'selected':'' ?>>Female</option>
                                <option value="other"  <?= (isset($_POST['gender']) && $_POST['gender']=='other')  ? 'selected':'' ?>>Other</option>
                            </select>
                        </div>
                        <div style="flex:1;">
                            <label>Age</label>
                            <input type="number" name="age" min="18" max="100"
                                value="<?= isset($_POST['age']) ? htmlspecialchars($_POST['age']) : '' ?>">
                        </div>
                    </div>

                    <!-- Password full width -->
                    <div class="full-col">
                        <label>Password</label>
                        <input type="password" name="password">
                    </div>

                    <!-- Confirm Password full width -->
                    <div class="full-col">
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_password">
                    </div>

                    <!-- Role full width -->
                    <div class="full-col">
                        <label>Role</label>
                        <select name="role">
                            <option value="donor" <?= $role=='donor' ? 'selected':'' ?>>Donor</option>
                            <option value="admin" <?= $role=='admin' ? 'selected':'' ?>>Admin</option>
                        </select>
                    </div>

                </div><!-- end .form-grid -->

                <input type="hidden" name="csrf_token" value="<?= generateCSRF() ?>">

                <!-- Back + Signup buttons -->
                <div class="btn-row">
                    <button type="button" class="btn-outline" onclick="history.back()">Back</button>
                    <button type="submit" class="btn-primary">Signup</button>
                </div>

            </form>

            <p class="copyright">© 2026 Blood Donation Systems</p>
        </div>
    </div>

</div>

</body>
</html>