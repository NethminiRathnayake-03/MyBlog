<?php
require 'includes/db.php';
session_start();

if(!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$stmt = $conn->prepare("DELETE FROM blogPost WHERE id=? AND user_id=?");
$stmt->execute([$_GET['id'], $_SESSION['user_id']]);

header("Location: index.php");
