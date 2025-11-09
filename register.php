<?php 
require 'includes/db.php';
include 'includes/header.php';

if(isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$error = "";

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Basic validation
    if($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT * FROM user WHERE email=?");
        $stmt->execute([$email]);
        if($stmt->fetch()) {
            $error = "Email already registered.";
        } else {
            // Hash password and insert
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $hashed]);
            header('Location: login.php');
            exit;
        }
    }
}
?>

<div class="container">
    <h2>Register</h2>
    <?php if($error) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post">
        <label>Username</label>
        <input type="text" name="username" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <label>Confirm Password</label>
        <input type="password" name="confirm_password" required>

        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
</div>

<?php include 'includes/footer.php'; ?>
