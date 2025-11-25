<?php
session_start();
include 'koneksi.php';
include 'header.php';

if (!isset($_GET['id'])) {
    header("Location: blog.php");
    exit;
}

if (!empty($_SESSION['report_success'])): ?>
    <div class="alert-report success">
        <?= $_SESSION['report_success']; ?>
    </div>
<?php 
    unset($_SESSION['report_success']);
endif;

$blog_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'] ?? 0;

// Cek apakah blog difavoritkan user
$checkFav = $conn->query("
    SELECT * FROM blog_fav
    WHERE user_id = $user_id AND blog_id = $blog_id
");
$isFavorite = $checkFav->num_rows > 0;

// Toggle favorit
if (isset($_POST['toggle_fav'])) {
    if ($isFavorite) {
        $conn->query("DELETE FROM blog_fav WHERE user_id = $user_id AND blog_id = $blog_id");
    } else {
        $conn->query("INSERT INTO blog_fav (user_id, blog_id) VALUES ($user_id, $blog_id)");
    }
    header("Location: blog_detail.php?id=" . $blog_id);
    exit;
}

// Data blog
$query = "
    SELECT b.*, p.fullname,
    GROUP_CONCAT(t.tag_name SEPARATOR ', ') AS tags
    FROM blog b
    JOIN users u ON b.user_id = u.id
    JOIN user_profiles p ON p.user_id = u.id
    LEFT JOIN blog_tag bt ON bt.blog_id = b.blog_id
    LEFT JOIN tag t ON t.tag_id = bt.tag_id
    WHERE b.blog_id = $blog_id
    GROUP BY b.blog_id
";
$data = $conn->query($query)->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title><?= $data['title_blog'] ?></title>
<style>
    body {
        font-family: Arial;
        background: #f5f5f5;
    }
    .container {
        width: 70%;
        margin: 40px auto;
        background: white;
        padding: 25px;
        border-radius: 10px;
    }
    .header-actions {
        float: right;
        margin-top: -15px;
    }
    .header-actions button,
    .header-actions a {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 22px;
        margin-left: 10px;
        text-decoration: none;
    }
    .fav.red {
        color: red;
    }
    .fav {
        font-size: 25px;
    }
    .report {
        color: #555;
        font-size: 22px;
    }
    .blog-img {
        width: 100%;
        border-radius: 8px;
        margin: 20px 0;
    }
    .tags {
        margin-top: 15px;
        color: #666;
        font-size: 15px;
    }
    .alert-report {
        width: 90%;
        max-width: 800px;
        margin: 20px auto;
        padding: 15px 20px;
        border-radius: 8px;
        font-weight: bold;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        animation: fadeSlide 0.5s ease;
    }

    .alert-report.success {
        background: #d4edda;
        color: #155724;
        border-left: 5px solid #28a745;
    }

    @keyframes fadeSlide {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }


</style>
</head>
<body>

<div class="container">
    <a href="javascript:history.back()" style="margin-right: 15px; font-size: 24px; text-decoration: none; color: #333;"class="back-btn">&leftarrow;</a>
    <!-- Aksi kanan atas -->
    <div class="header-actions">

        <!-- FAVORITE BUTTON -->
        <form method="POST" style="display:inline;">
            <button type="submit" name="toggle_fav" class="fav <?= $isFavorite ? 'red' : '' ?>">
                <?= $isFavorite ? "❤️" : "🤍" ?>
            </button>
        </form>

        <!-- REPORT BUTTON -->
        <a href="blog_report.php?id=<?= $blog_id ?>" class="report" title="Laporkan">⚠️</a>
    </div>

    <h1><?= $data['title_blog'] ?></h1>
    <small>
        Ditulis oleh <b><?= $data['fullname'] ?></b> |
        <?= date("d M Y", strtotime($data['date_posted'])) ?>
    </small>

    <img src="<?= $data['image_path'] ?>" class="blog-img">

    <p><?= nl2br($data['content_blog']) ?></p>

    <div class="tags">
        <b>Tags:</b> <?= $data['tags'] ?>
    </div>

</div>

</body>
</html>
