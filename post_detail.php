<?php
include __DIR__ . '../db_connect.php';
include 'header.php';
if(!isset($_GET['id'])) { header('Location: forum.php'); exit; }
$id = intval($_GET['id']);

// increment views
mysqli_query($conn, "UPDATE forum_posts SET views = views + 1 WHERE id = $id");

$sql = "SELECT p.*, u.fullname, u.foto_profil, c.name as category_name
        FROM forum_posts p
        JOIN user_profiles u ON p.user_id = u.id
        LEFT JOIN forum_categories c ON p.category_id = c.id
        WHERE p.id = $id";
$res = mysqli_query($conn, $sql);
$post = mysqli_fetch_assoc($res);
if(!$post){ header('Location: forum.php'); exit; }

// handle comment submit
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $content = mysqli_real_escape_string($conn, $_POST['comment']);
    $user_id = 1; // replace with session user id
    mysqli_query($conn, "INSERT INTO forum_comments (post_id, user_id, content) VALUES ($id, $user_id, '$content')");
    header('Location: post_detail.php?id='.$id);
    exit;
}

// Get post detail
$sqlt = $pdo->prepare("
    SELECT p.*, u.nama, u.foto_profil,
           (SELECT COUNT(*) FROM forum_comments WHERE post_id = p.id) as jumlah_jawaban,
    FROM forum_posts p
    JOIN user_profiles u ON c.user_id = u.id
    WHERE c.post_id = $id
");
// $sqlt->execute([$id]);
// $post = $sqlt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    header('Location: forum.php');
    exit;
}

// Handle answer submission
$error = '';
$success = isset($_GET['success']) ? true : false;
$commentsRes = mysqli_query($conn, "SELECT c.*, u.fullname, u.foto_profil FROM forum_comments c JOIN user_profiles u ON c.user_id = u.id WHERE c.post_id = $id ORDER BY c.created_at ASC");
// Helper function
function time_elapsed($datetime) {
    $now = new DateTime();
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    if ($diff->d == 0) {
        if ($diff->h == 0) {
            return $diff->i . ' menit yang lalu';
        }
        return $diff->h . ' jam yang lalu';
    } elseif ($diff->d < 30) {
        return $diff->d . ' hari yang lalu';
    } elseif ($diff->m < 12) {
        return $diff->m . ' bulan yang lalu';
    } else {
        return $diff->y . ' tahun yang lalu';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($post['title']) ?> - Life Below Water</title>
    <link rel="stylesheet" href="./assets/css/forum.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .breadcrumb {
            padding: 20px 0;
            margin-left: 200px;
            font-size: 14px;
            color: #666;
        }
        
        .breadcrumb a {
            color: #1041a0;
            text-decoration: none;
        }
        
        .breadcrumb a:hover {
            text-decoration: underline;
        }
        
        .post-detail-container {
            max-width: 900px;
            margin: 0 auto 40px;
        }
        
        .post-detail {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .post-detail-header {
            border-bottom: 1px solid #f3f4f6;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        
        .post-category-badge {
            display: inline-block;
            padding: 6px 12px;
            background-color: #eff6ff;
            color: #1041a0;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        .post-detail h1 {
            font-size: 28px;
            font-weight: 700;
            color: #111;
            line-height: 1.4;
            margin-bottom: 15px;
        }
        
        .post-detail-content {
            font-size: 15px;
            line-height: 1.8;
            color: #333;
            margin-bottom: 20px;
        }
        
        .answers-section {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .answers-header {
            border-bottom: 1px solid #f3f4f6;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        
        .answers-header h2 {
            font-size: 20px;
            font-weight: 600;
            color: #111;
        }
        
        .answer-card {
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .answer-card.accepted {
            border-color: #10b981;
            background-color: #f0fdf4;
        }
        
        .accepted-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            background-color: #10b981;
            color: white;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .answer-form {
            background: #f9fafb;
            border-radius: 10px;
            padding: 25px;
            margin-top: 30px;
        }
        
        .answer-form h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #111;
        }
        
        .answer-form textarea {
            width: 100%;
            min-height: 150px;
            padding: 15px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-family: inherit;
            font-size: 14px;
            resize: vertical;
            margin-bottom: 15px;
        }
        
        .answer-form textarea:focus {
            outline: none;
            border-color: #1041a0;
        }
        
        .answer-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .login-prompt {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin-top: 30px;
        }
        
        .login-prompt p {
            margin-bottom: 15px;
            color: #1e40af;
        }
        
        .btn-link {
            color: #1041a0;
            text-decoration: none;
            font-weight: 600;
        }
        
        .btn-link:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 768px) {
            .post-detail, .answers-section {
                padding: 20px;
            }
            
            .post-detail h1 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="forum.php">Forum</a> 
            <span> / </span>
            <a href="forum.php?kategori=<?= urlencode($post['category_name']) ?>">
                <?= htmlspecialchars($post['category_name']) ?>
            </a>
            <span> / </span>
            <span><?= htmlspecialchars(string: substr($post['title'], 0, 50)) ?>...</span>
        </div>

        <div class="post-detail-container">
            <!-- Post Detail -->
            <div class="post-detail">
                <div class="post-detail-header">
                    <div class="post-category-badge">
                        <?= htmlspecialchars($post['category_name']) ?>
                    </div>
                    
                    <h1><?= htmlspecialchars($post['title']) ?></h1>
                    
                    <div class="post-header">
                        <img src="<?= htmlspecialchars($post['foto_profil'] ?: 'default-avatar.png') ?>" 
                             alt="<?= htmlspecialchars($post['fullname']) ?>" 
                             >
                        <div class="post-meta">
                            <div class="user-info">
                                <span class="post-time"><?= time_elapsed($post['created_at']) ?></span>
                              </div>
                        </div>
                    </div>
                </div>

                <div class="post-detail-content">
                    <?= nl2br(htmlspecialchars($post['content'])) ?>
                </div>

                <div class="post-footer">
                    <div class="post-stats">
                        <span><i class="fas fa-comment"></i> <?php
                            $cRes = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM forum_comments WHERE post_id = " . intval($post['id']));
                            echo mysqli_fetch_assoc($cRes)['cnt'];
                        ?> answers</span>
                        <span><i class="fas fa-eye"></i> <?= $post['views'] ?> views</span>
                    </div>
                </div>
            </div>

            <!-- Answers Section -->
            <div class="answers-section" id="jawaban">
                <div class="answers-header">
                    <h2><?php
                            $cRes = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM forum_comments WHERE post_id = " . intval($post['id']));
                            echo mysqli_fetch_assoc($cRes)['cnt'];
                        ?> Jawaban</h2>
                </div>

                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        Jawaban berhasil dikirim!
                    </div>
                <?php endif; ?>

                <?php if ($error): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <?php if (empty($jawaban)): ?>
                    <div class="no-posts">
                        <i class="fas fa-comments"></i>
                        <p>Belum ada jawaban. Jadilah yang pertama menjawab!</p>
                    </div>
                <?php else: ?>
                    <?php foreach($jawaban as $j): ?>
                        <article class="answer-card <?= $j['is_accepted'] ? 'accepted' : '' ?>">
                            <?php if ($j['is_accepted']): ?>
                                <span class="accepted-badge">
                                    <i class="fas fa-check"></i> Jawaban Terpilih
                                </span>
                            <?php endif; ?>
                            
                            <div class="post-header">
                                <img src="<?= htmlspecialchars($j['foto_profil'] ?: 'default-avatar.png') ?>" 
                                     alt="<?= htmlspecialchars($j['nama']) ?>" 
                                     class="user-avatar">
                                <div class="post-meta">
                                    <div class="user-info">
                                        <span class="username"><?= htmlspecialchars($j['nama']) ?></span>
                                        <span class="user-badge"><?= htmlspecialchars($j['role']) ?></span>
                                        <span class="post-time"><?= time_elapsed($j['created_at']) ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="post-detail-content">
                                <?= nl2br(htmlspecialchars($j['content'])) ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>

                <!-- Answer Form -->
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="answer-form">
                        <h3>Tulis Jawaban Anda</h3>
                        <form method="POST" action="">
                            <textarea 
                                name="jawaban" 
                                placeholder="Bagikan pengetahuan atau pengalaman Anda..."
                                required
                                minlength="10"
                            ></textarea>
                            <div class="answer-actions">
                                <div class="form-hint">
                                    <i class="fas fa-info-circle"></i>
                                    Minimal 10 karakter
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i> Kirim Jawaban
                                </button>
                            </div>
                        </form>
                    </div>
                <?php else: ?>
                    <div class="login-prompt">
                        <p><i class="fas fa-lock"></i> Anda harus login untuk menjawab pertanyaan ini</p>
                        <a href="login.php" class="btn btn-primary">Login Sekarang</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="post-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <img src="logo.png" alt="Logo">
                    <span>brix templates</span>
                </div>
                <nav class="footer-nav">
                    <a href="#">Home</a>
                    <a href="#">About</a>
                    <a href="#">Pricing</a>
                    <a href="#">Blog</a>
                    <a href="#">Contact</a>
                </nav>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
            <div class="copyright">
                <p>Copyright © 2023 BRIX Templates | All Rights Reserved</p>
            </div>
        </div>
    </footer>

</body>
</html>
