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
                b.blog_id, 
                b.title_blog, 
                LEFT(b.content_blog, 150) AS excerpt, 
                b.date_posted, 
                a.fullname AS author_name,
                b.image_path,
                GROUP_CONCAT(t.tag_name SEPARATOR ', ') AS tags
            FROM blog b 
            JOIN users u ON b.user_id = u.id 
            JOIN user_profiles a ON a.user_id = u.id
            LEFT JOIN blog_tag bt ON bt.blog_id = b.blog_id
            LEFT JOIN tag t ON t.tag_id = bt.tag_id
            WHERE 
                (b.title_blog LIKE '%$search%' 
                OR t.tag_name LIKE '%$search%')
                AND b.user_id = ". intval($_SESSION['user_id']) ."
            GROUP BY b.blog_id
            ORDER BY b.date_posted DESC";
} else {
  $query = "SELECT 
                b.blog_id, 
                b.title_blog, 
                LEFT(b.content_blog, 150) AS excerpt, 
                b.date_posted, 
                a.fullname AS author_name,
                b.image_path,
                GROUP_CONCAT(t.tag_name SEPARATOR ', ') AS tags
                FROM blog b
                JOIN users u ON b.user_id = u.id
                JOIN user_profiles a ON a.user_id = u.id
                LEFT JOIN blog_tag bt ON bt.blog_id = b.blog_id
                LEFT JOIN tag t ON t.tag_id = bt.tag_id
                WHERE b.user_id = " . intval($_SESSION['user_id']) . "
                GROUP BY b.blog_id
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
            <form method="GET" action="blog.php" class="search-box">
                <span>🔍</span>
                <input type="text" name="search" placeholder="Search..." value="<?= htmlspecialchars($search) ?>">
                <button type="submit">Search</button>
            </form>
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
                            <a href="blog_detail.php?id=<?= $blog['blog_id'] ?>" class="read-more">Baca Selengkapnya</a>
                            <div class="action-buttons">
                                <a class="btn-edit" href="blog_edit.php?id=<?= htmlspecialchars($blog['blog_id']) ?>">✏️ Edit</a>
                                <a class="btn-delete" 
                                href="blog_delete.php?id=<?= htmlspecialchars($blog['blog_id']) ?>" 
                                onclick="return confirm('Apakah Anda yakin ingin menghapus postingan ini?');">
                                🗑️ Hapus
                                </a>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Anda belum memiliki postingan blog. Silakan buat yang baru!</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>