<?php
require 'includes/db.php';
include 'includes/header.php';

if(!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$title = $content = "";
$editing = false;

if(isset($_GET['id'])) {
    $editing = true;
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM blogpost WHERE id=? AND user_id=?");
    $stmt->execute([$id, $_SESSION['user_id']]);
    $blog = $stmt->fetch();
    if(!$blog) {
        echo "<div class='container'><p>Blog not found or you don't have permission to edit.</p></div>";
        exit;
    }
    $title = $blog['title'];
    $content = $blog['content'];
}

// Handle form submission
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    if($editing) {
        $stmt = $conn->prepare("UPDATE blogpost SET title=?, content=?, updated_at=NOW() WHERE id=? AND user_id=?");
        $stmt->execute([$title, $content, $id, $_SESSION['user_id']]);
    } else {
        $stmt = $conn->prepare("INSERT INTO blogpost (user_id, title, content, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$_SESSION['user_id'], $title, $content]);
    }
    header('Location: index.php');
    exit;
}
?>

<header><div style="text-align: center; margin: 20px 0;">
    <h3 style="display: inline-block; margin: 0; vertical-align: middle;">Share your story with the world !</h3>
    <div style="display: inline-block; background-color: #5ddee2ff; color: black; 
                text-align: center; padding: 10px 20px; border-radius: 8px; 
                font-size: 16px; vertical-align: middle; margin-left: 15px;">
        Start your New Blog here
    </div>
</div>

<header>
<div class="container">
    
    <h2><?= $editing ? "Edit Blog" : "New Blog" ?></h2>
    <form method="post">
        <label>Title</label>
        <input type="text" name="title" value="<?= htmlspecialchars($title) ?>" required>

        <label>Content</label>
        <textarea name="content" rows="10" required><?= htmlspecialchars($content) ?></textarea>

        <button type="submit"><?= $editing ? "Update Blog" : "Create Blog" ?></button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
