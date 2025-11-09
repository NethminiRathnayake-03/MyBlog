<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Blog</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js" defer></script>
</head>
<body>

<!-- Unified Blue Header + Navigation -->
<header class="top-bar">
    <div class="header-container">
        <h1>My Blog</h1>
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
    </div>
</header>
