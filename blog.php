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
                WHERE title_blog LIKE '%$search%' and b.user_id = " . intval($_SESSION['user_id']) . "
                ORDER BY b.date_posted DESC";
} else {
  $query = "SELECT 
                b.blog_id, b.title_blog, LEFT(b.content_blog, 150) AS excerpt, b.date_posted, 
                a.fullname as author_name, b.image_path
                FROM blog b 
                JOIN users u ON b.user_id = u.id 
                JOIN user_profiles a ON a.user_id = u.id 
                WHERE b.user_id = " . intval($_SESSION['user_id']) . "
                ORDER BY b.date_posted DESC";
}

$result = mysqli_query($conn, $query);
?> 

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link rel="stylesheet" href="blog.css">
</head>
<body>

    <div class="main-content">
        <div class="tabs-bar">
            <a href="blog_myblog.php" class="tab">My Blog</a> <a href="blog_favblog.php" class="tab">Favorite Blog</a>
            <div class="search-box">
                🔍 Search...
            </div>
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
                            <a href="detail_blog.php?id=<?= htmlspecialchars($blog['blog_id']) ?>">Baca Selengkapnya</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Belum ada postingan blog saat ini.</p>
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
</body>
</html>