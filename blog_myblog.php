<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit;
}

include "koneksi.php";
include "header.php";

$search = "";
if (isset($_GET['search'])) {
  $search = mysqli_real_escape_string($conn, $_GET['search']);
  $query = "SELECT 
                b.blog_id, b.title_blog, LEFT(b.content_blog, 150) AS excerpt, b.date_posted, 
                a.fullname as author_name, b.image_path
                FROM blog b 
                JOIN users u ON b.user_id = u.id 
                JOIN user_profiles a ON a.user_id = u.id
                WHERE title_blog LIKE '%$search%'
                ORDER BY b.date_posted DESC";
} else {
  $query = "SELECT 
                b.blog_id, b.title_blog, LEFT(b.content_blog, 150) AS excerpt, b.date_posted, 
                a.fullname as author_name, b.image_path
                FROM blog b 
                JOIN users u ON b.user_id = u.id 
                JOIN user_profiles a ON a.user_id = u.id 
                ORDER BY b.date_posted DESC";
}

$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Blog</title>
    <link rel="stylesheet" href="blog.css">
</head>
<body>

    <div class="main-content">
        <div class="tabs-bar">
            <a href="blog_myblog.php" class="tab active">My Blog</a> 
            <a href="blog_favblog.php" class="tab">Favorite Blog</a>
            <div class="search-box">
                🔍 Search...
            </div>
        </div>
        <div class="tambah-baru">
            <a href="blog_addform.php" class="tambah-baru-button">+ Tambah Baru</a>
        </div>

        <div class="blog-grid-container">
            <?php if (!empty($result)): ?>
                <?php foreach ($result as $blog): ?>
                    <div class="blog-card">
                        <div class="image-wrapper">
                            <img src="<?= htmlspecialchars($blog['image_path']) ?>" 
                                alt="Gambar Blog ID: <?= htmlspecialchars($blog['blog_id']) ?>">
                        </div>
                        <div class="card-body">
                            <p class="meta">(<?= htmlspecialchars($blog['tags']) ?>) - <?= date('d/m/Y', strtotime($blog['date_posted'])) ?></p>
                            <h3 class="title"><?= htmlspecialchars($blog['title_blog']) ?></h3>
                            <p class="excerpt"><?= htmlspecialchars($blog['excerpt']) ?>...</p>
                            <div class="action-buttons">
                                <a href="edit_blog.php?id=<?= htmlspecialchars($blog['blog_id']) ?>">Edit</a> | 
                                <a href="delete_blog.php?id=<?= htmlspecialchars($blog['blog_id']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus blog ini?');">Hapus</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Anda belum memiliki postingan blog. Silakan buat yang baru!</p>
            <?php endif; ?>
        </div>

        <div class="pagination">
            <a href="#">&lt;</a>
            <a href="#" class="active">1</a>
            <a href="#">2</a>
            <a href="#">3</a>
            <span>...</span>
            <a href="#">&gt;</a>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-content">
            <div class="logo">
                <span class="dot-text">..</span> brix **templates**
            </div>
            <nav class="footer-links">
                <a href="#">Home</a>
                <a href="#">About</a>
                <a href="#">Pricing</a>
                <a href="blog.php">Blog</a>
                <a href="#">Contact</a>
            </nav>
            <div class="social-icons">
                <span>f</span>
                <span>t</span>
                <span>i</span>
                <span>l</span>
            </div>
        </div>
        <p class="copyright">Copyright © 2023 BRIX Templates | All Rights Reserved</p>
    </footer>
</body>
</html>