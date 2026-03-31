<?php
require_once '../config/db.php';
require_once '../includes/functions.php';

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = cleanInput($_POST['email']);
    $new_password = cleanInput($_POST['new_password']);
    $confirm_password = cleanInput($_POST['confirm_password']);

    if (
        !isset($_POST['csrf_token']) ||
        !validateCSRF($_POST['csrf_token'])
    ) {
        $error = "Invalid request!";
    } elseif (empty($email) || empty($new_password) || empty($confirm_password)) {
        $error = "All fields are required!";
    } elseif (!validateEmail($email)) {
        $error = "Invalid email format!";
    } elseif (!validatePassword($new_password)) {
        $error = "Password must be at least 6 characters!";
    } elseif ($new_password !== $confirm_password) {
        $error = "Password and Confirm Password do not match!";
    } else {

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {

            $hashedPassword = password_hash($new_password, PASSWORD_BCRYPT);

            $update = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
            $update->execute([$hashedPassword, $email]);

            $success = "Password updated successfully! You can now login.";
        } else {
            $error = "Email not found!";
        }
    }
}
?>

<?php include '../includes/header.php'; ?>

<h2>Forgot Password</h2>

<?php if ($success): ?>
    <p style="color:green;"><?php echo $success; ?></p>
<?php endif; ?>

<?php if ($error): ?>
    <p style="color:red;"><?php echo $error; ?></p>
<?php endif; ?>

<form method="POST">

    <label>Email:</label><br>
    <input type="text" name="email"><br><br>

    <label>New Password:</label><br>
    <input type="password" name="new_password"><br><br>

    <label>Confirm Password:</label><br>
    <input type="password" name="confirm_password"><br><br>

    <!-- CSRF Token -->
    <input type="hidden" name="csrf_token" value="<?php echo generateCSRF(); ?>">

    <button type="submit">Reset Password</button>
</form>

<br>
<a href="login.php">Back to Login</a>

<?php include '../includes/footer.php'; ?>