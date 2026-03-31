<?php
require_once '../config/db.php';
require_once '../includes/functions.php';

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

        $email = cleanInput($_POST['email']);
        $password = cleanInput($_POST['password']);

        if (empty($email) || empty($password)) {
            $error = "Email and password are required!";
        } elseif (!validateEmail($email)) {
            $error = "Invalid email format!";
        } else {
            if (loginUser($pdo, $email, $password)) {
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Invalid email or password!";
            }
        }
    }
}
?>

<?php include '../includes/header.php'; ?>

<h2>Login</h2>

<?php if ($error): ?>
    <p style="color:red;"><?= $error ?></p>
<?php endif; ?>

<form method="POST">

    <label>Email:</label><br>
    <input type="text" name="email" value="<?= htmlspecialchars($email) ?>">
    <br><br>

    <label>Password:</label><br>
    <input type="password" name="password">
    <br><br>

    <input type="hidden" name="csrf_token" value="<?= generateCSRF() ?>">

    <button type="submit">Login</button>
</form>

<br>

<a href="forget_password.php">Forgot Password?</a>

<br><br>

<a href="register.php">Create Account</a>

<?php include '../includes/footer.php'; ?>