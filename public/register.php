<?php
require_once '../includes/functions.php';
require_once '../config/db.php';

$error = "";
$success = "";

$email = "";
$role = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = cleanInput($_POST['email']);
    $password = cleanInput($_POST['password']);
    $confirm_password = cleanInput($_POST['confirm_password']);
    $role = $_POST['role'];

    if (
        !isset($_POST['csrf_token']) ||
        !validateCSRF($_POST['csrf_token'])
    ) {
        $error = "Invalid request!";
    } elseif (empty($email) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required!";
    } elseif (!validateEmail($email)) {
        $error = "Invalid email format!";
    } elseif (!validatePassword($password)) {
        $error = "Password must be at least 6 characters!";
    } elseif ($password !== $confirm_password) {
        $error = "Password and Confirm Password do not match!";
    } else {
        if (registerUser($pdo, $email, $password, $role)) {
            $success = "Signup successful! You can now login.";
            $email = "";
            $role = "";
        } else {
            $error = "Error: Email may already exist!";
        }
    }
}
?>

<?php include '../includes/header.php'; ?>

<h2>Signup</h2>

<?php if ($success): ?>
    <p style="color:green;"><?php echo $success; ?></p>
<?php endif; ?>

<?php if ($error): ?>
    <p style="color:red;"><?php echo $error; ?></p>
<?php endif; ?>

<form method="POST">

    <label>Email:</label><br>
    <input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>">
    <br><br>

    <label>Password:</label><br>
    <input type="password" name="password">
    <br><br>

    <label>Confirm Password:</label><br>
    <input type="password" name="confirm_password">
    <br><br>

    <label>Role:</label>
    <select name="role">
        <option value="donor" <?php if ($role == 'donor')
            echo 'selected'; ?>>Donor</option>
        <option value="admin" <?php if ($role == 'admin')
            echo 'selected'; ?>>Admin</option>
    </select>

    <br><br>

    <input type="hidden" name="csrf_token" value="<?php echo generateCSRF(); ?>">

    <button type="submit">Signup</button>

</form>

<br>

<a href="login.php">Go to Login</a>

<?php include '../includes/footer.php'; ?>