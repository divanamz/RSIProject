<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: blog_myblog.php");
    exit;
}

$blog_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// Hapus relasi tag dulu
$stmt = $conn->prepare("DELETE FROM blog_tag WHERE blog_id=?");
$stmt->bind_param("i", $blog_id);
$stmt->execute();

// Hapus blog
$stmt = $conn->prepare("DELETE FROM blog WHERE blog_id=? AND user_id=?");
$stmt->bind_param("ii", $blog_id, $user_id);
$stmt->execute();

header("Location: blog_myblog.php");
exit;
