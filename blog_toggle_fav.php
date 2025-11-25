<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['user_id']) || !isset($_GET['blog_id'])) {
    header("Location: blog.php");
    exit;
}

$userId = intval($_SESSION['user_id']);
$blogId = intval($_GET['blog_id']);

// Cek apakah sudah difavoritkan
$cek = mysqli_query($conn, "SELECT * FROM blog_fav WHERE user_id=$userId AND blog_id=$blogId");

if (mysqli_num_rows($cek) > 0) {
    // Jika sudah ada → hapus
    mysqli_query($conn, "DELETE FROM blog_fav WHERE user_id=$userId AND blog_id=$blogId");
} else {
    // Jika belum → tambah
    mysqli_query($conn, "INSERT INTO blog_fav (user_id, blog_id) VALUES ($userId, $blogId)");
}

if (isset($_GET['return']) && $_GET['return'] === 'fav') {
    header("Location: blog_favblog.php");
} else {
    header("Location: blog.php");
}
exit;
