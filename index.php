<?php 
require 'includes/db.php'; 
include 'includes/header.php'; 
?>

<div class="container">

    <?php if(isset($_SESSION['username'])): ?>
        <p>Welcome, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>!</p>
    <?php endif; ?>

    <!-- Search Form -->
    <form method="get" action="index.php" style="margin-bottom:20px;">
        <input type="text" name="search" placeholder="Search blogs by title..." style="width:80%; padding:8px;">
        <button type="submit">Search</button>
    </form>

    <h1>All Blogs</h1>

    <?php 
    if(isset($_GET['search']) && !empty($_GET['search'])) {
        $search = "%" . $_GET['search'] . "%";
        $stmt = $conn->prepare("
            SELECT blogpost.*, user.username 
            FROM blogpost 
            JOIN user ON blogpost.user_id = user.id 
            WHERE blogpost.title LIKE ? 
            ORDER BY created_at DESC
        ");
        $stmt->execute([$search]);
    } else {
        $stmt = $conn->query("
            SELECT blogpost.*, user.username 
            FROM blogpost 
            JOIN user ON blogpost.user_id = user.id 
            ORDER BY created_at DESC
        ");
    }

    $blogs = $stmt->fetchAll();

    if(count($blogs) == 0) {
        echo "<p>No blogs found yet.</p>";
    }
    ?>

    <?php foreach($blogs as $blog): ?>
        <div class="blog-box">
            <h2>
                <a href="blog.php?id=<?= $blog['id'] ?>">
                    <?= htmlspecialchars($blog['title']) ?>
                </a>
            </h2>
            <p>
                by <?= htmlspecialchars($blog['username']) ?> 
                on <?= $blog['created_at'] ?>
            </p>
            <p>
                <?= substr(strip_tags($blog['content']), 0, 150) ?>...
            </p>

            <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $blog['user_id']): ?>
                <a href="editor.php?id=<?= $blog['id'] ?>">Edit</a> | 
                <a href="delete.php?id=<?= $blog['id'] ?>" onclick="return confirm('Are you sure you want to delete this blog?')">Delete</a>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

</div>
<?php include 'includes/footer.php'; ?>


</body>
</html>
