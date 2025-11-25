<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$blog_id = intval($_GET['blog_id']);

// Insert ignore biar kalau sudah pernah difavoritkan, tidak error
$query = "INSERT IGNORE INTO favorite_blog (user_id, blog_id) VALUES (?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $user_id, $blog_id);

if ($stmt->execute()) {
    header("Location: blog.php?id=$blog_id&fav=success");
} else {
    header("Location: blog.php?id=$blog_id&fav=failed");
}
exit;
?>
