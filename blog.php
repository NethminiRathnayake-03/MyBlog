<?php
require 'includes/db.php';
include 'includes/header.php';

if(!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT blogPost.*, user.username FROM blogPost JOIN user ON blogPost.user_id = user.id WHERE blogPost.id = ?");
$stmt->execute([$id]);
$blog = $stmt->fetch();

if(!$blog) {
    echo "<div class='container'><p>Blog not found.</p></div>";
    exit;
}
?>

<header>
    <h1>My Blog</h1>
</header>

<nav>
    <a href="index.php">Home</a>
    <?php if(isset($_SESSION['user_id'])): ?>
        <a href="editor.php">New Blog</a>
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
    <?php endif; ?>
</nav>

<div class="container">
    <h2><?= htmlspecialchars($blog['title']) ?></h2>
    <p>by <?= htmlspecialchars($blog['username']) ?> on <?= $blog['created_at'] ?></p>
    <div><?= nl2br($blog['content']) ?></div>

    <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $blog['user_id']): ?>
        <p>
            <a href="editor.php?id=<?= $blog['id'] ?>">Edit</a> |
            <a href="delete.php?id=<?= $blog['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </p>
    <?php endif; ?>
</div>

<footer style="text-align:center; padding:15px; background:#343a40; color:white; margin-top:20px;">

</footer>
