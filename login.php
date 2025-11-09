<?php
require 'includes/db.php';
include 'includes/header.php';

if(isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$error = "";

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM user WHERE email=?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: index.php');
        exit;
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<div class="container">
    <h2>Login</h2>
    <?php if($error) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post">
        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a></p>
</div>

<?php include 'includes/footer.php'; ?>
