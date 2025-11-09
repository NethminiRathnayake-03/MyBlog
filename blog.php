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
<header style="display:flex; justify-content:center; margin-top:40px;">
    <div style="background-color:white; color:#007bff; 
                padding:30px 300px 20px 40px; /* top, right, bottom, left */ 
                border-radius:12px; 
                box-shadow:0 8px 20px rgba(0,0,0,0.15); 
                text-align:left; 
                max-width:600px; width:90%;">
        <h2 style="font-size:2.0rem; margin:0; font-weight:bold;">My Blog</h2>
        
    </div>
</header>

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
<?php include 'includes/footer.php'; ?>


