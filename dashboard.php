<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}
include 'koneksi.php'; // file koneksi ke DB

// 3 volunteer terbaru
$volunteer = $conn->query("
    SELECT * FROM program 
    LIMIT 3
")->fetch_all(MYSQLI_ASSOC);

// 3 blog terbaru
$blogs = $conn->query("
    SELECT 
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
        GROUP BY b.blog_id
        ORDER BY b.date_posted DESC
    LIMIT 3
")->fetch_all(MYSQLI_ASSOC);

// 3 forum terbaru
$forums = $conn->query("
    SELECT id, title, content
    FROM forum_posts
    ORDER BY created_at DESC 
    LIMIT 3
")->fetch_all(MYSQLI_ASSOC);

// 3 merch terbaru
$merch = $conn->query("
    SELECT merch_id, merch_name, merch_pict, price 
    FROM merchandise
    LIMIT 3
")->fetch_all(MYSQLI_ASSOC);

include "header.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard </title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>

    <!-- HERO SECTION -->
    <section class="hero">
        <div class="overlay"></div>
        <div class="hero-content">
            <h1>Your Best Word</h1>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                Proin maximus justo neque, ac scelerisque urna lobortis et.
            </p>
            <button class="btn">Button Text</button>

             <div class="stats">
            <div class="stat-box">
                <h2>100+</h2>
                <p>Volunteers</p>
            </div>
            <div class="stat-box">
                <h2>100+</h2>
                <p>Activities</p>
            </div>
            <div class="stat-box">
                <h2>100+</h2>
                <p>Donations</p>
            </div>
        </div>
        </div>
    </section>

    <section class="dashboard-sections">

    <!-- VOLUNTEER -->
    <div class="section-block">
        <div class="section-header">
            <h2>Kegiatan Volunteer Terbaru</h2>
            <a href="volunteer.php" class="more-link">Jelajahi lebih jauh →</a>
        </div>
        <div class="card-list">
            <?php foreach ($volunteer as $v): ?>
                <a href="volunteer_detail.php?id=<?= $v['activity_id'] ?>" class="card">
                    <img src="vol.png" class="card-img">
                    <div class="card-title">
                        <h3 class="title"><?= htmlspecialchars($v['program_name']); ?></h3>
                    </div>
                    <p>📅 <?= htmlspecialchars($v['date']); ?></p>
                    <p>📍 <?= htmlspecialchars($v['location']); ?></p>
                </a>
            <?php endforeach; ?>
        </div>

    </div>

    <!-- BLOG -->
    <div class="section-block">
        <div class="section-header">
            <h2>Blog Terbaru</h2>
            <a href="blog.php" class="more-link">Jelajahi lebih jauh →</a>
        </div>
        <div class="card-list">
            <?php foreach ($blogs as $b): ?>
                <a href="blog_detail.php?id=<?= $b['blog_id'] ?>" class="card">
                    <img src="<?= htmlspecialchars($b['image_path']) ?>" class="card-img"
                        alt="Gambar Blog ID: <?= htmlspecialchars($b['blog_id']) ?>">
                    <div class="card-title">
                        <p class="meta">(<?= htmlspecialchars($b['tags']) ?>) - <?= date('d/m/Y', strtotime($b['date_posted'])) ?></p>
                        <?= htmlspecialchars($b['title_blog']) ?>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- MERCH -->
    <div class="section-block">
        <div class="section-header">
            <h2>Merch Terbaru</h2>
            <a href="merch.php" class="more-link">Jelajahi lebih jauh →</a>
        </div>
        <div class="card-list">
            <?php foreach ($merch as $m): ?>
                <a href="merch_detail.php?id=<?= $m['merch_id'] ?>" class="card">
                    <img src="merch_img/<?= htmlspecialchars($m['merch_pict']) ?>"  class="card-img"
                         alt="<?= htmlspecialchars($m['merch_name']) ?>">
                    <div class="card-title">
                        <?= htmlspecialchars($m['merch_name']) ?>
                        <p class="product-price">Rp <?= number_format($m['price'], 0, ',', '.') ?></p>
                    </div>
                    
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- FORUM -->
    <div class="section-block">
        <div class="section-header">
            <h2>Forum Terbaru</h2>
            <a href="forum.php" class="more-link">Jelajahi lebih jauh →</a>
        </div>
        <div class="card-list">
            <?php foreach ($forums as $f): ?>
                <a href="forum_detail.php?id=<?= $f['id'] ?>" class="card">
                    <?= htmlspecialchars($f['title']) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

</section>


</body>
</html>
<?php
    include 'footer.php';
?>