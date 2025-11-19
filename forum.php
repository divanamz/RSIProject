<?php
include 'koneksi.php';
include 'header.php';

// Pagination
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$perPage = 6;
$offset = ($page - 1) * $perPage;

// Categories
$catRes = mysqli_query($conn, "SELECT * FROM forum_categories ORDER BY name ASC");
$categories = [];
while($r = mysqli_fetch_assoc($catRes)) {
    $categories[] = $r;
}

// Get category stats
$category_stats = [];
foreach($categories as $cat) {
    $countQuery = mysqli_query($conn, "SELECT COUNT(*) as jumlah FROM forum_posts WHERE category_id = " . $cat['id']);
    $countData = mysqli_fetch_assoc($countQuery);
    $category_stats[] = [
        'id' => $cat['id'],
        'name' => $cat['name'],
        'jumlah' => $countData['jumlah']
    ];
}

// Filter & Search
$where = [];
$kategori_filter = isset($_GET['category']) && $_GET['category'] !== '' && $_GET['category'] !== 'all' ? $_GET['category'] : '';
$search_query = isset($_GET['q']) && $_GET['q'] !== '' ? trim($_GET['q']) : '';

if($kategori_filter) {
    $cid = intval($kategori_filter);
    $where[] = "p.category_id = $cid";
}

if($search_query) {
    $q = mysqli_real_escape_string($conn, $search_query);
    $where[] = "(p.title LIKE '%$q%' OR p.content LIKE '%$q%')";
}

$whereSql = count($where) ? 'WHERE ' . implode(' AND ', $where) : '';

// Filter tab
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'terbaru';

// Build query dengan subqueries untuk jawaban dan views
$sql = "SELECT p.*, u.fullname, u.foto_profil, c.name AS category_name,
        (SELECT COUNT(*) FROM forum_comments WHERE post_id = p.id) as jumlah_jawaban,
        p.views as jumlah_views
        FROM forum_posts p
        JOIN user_profiles u ON p.user_id = u.id
        LEFT JOIN forum_categories c ON p.category_id = c.id
        $whereSql";

// Sorting berdasarkan filter
switch ($filter) {
    case 'populer':
        $sql .= " ORDER BY p.views DESC, p.created_at DESC";
        break;
    case 'belum_dijawab':
        $sql .= " HAVING jumlah_jawaban = 0 ORDER BY p.created_at DESC";
        break;
    default: // terbaru
        $sql .= " ORDER BY p.created_at DESC";
}

$sql .= " LIMIT $perPage OFFSET $offset";

// Total count
$countSql = "SELECT COUNT(*) as total FROM forum_posts p $whereSql";
if($filter === 'belum_dijawab') {
    $countSql = "SELECT COUNT(*) as total FROM (
        SELECT p.id FROM forum_posts p $whereSql
        HAVING (SELECT COUNT(*) FROM forum_comments WHERE post_id = p.id) = 0
    ) as subq";
}
$countRes = mysqli_query($conn, $countSql);
$total = mysqli_fetch_assoc($countRes)['total'];
$totalPages = ceil($total / $perPage);

$res = mysqli_query($conn, $sql);

// Popular questions
$popular_query = "SELECT title, id, views
                  FROM forum_posts
                  ORDER BY views DESC
                  LIMIT 5";
$popular_res = mysqli_query($conn, $popular_query);
$popular_questions = [];
while($pq = mysqli_fetch_assoc($popular_res)) {
    $popular_questions[] = $pq;
}

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

// Build URL params helper
function build_url($params) {
    $current = $_GET;
    foreach($params as $key => $value) {
        if($value === null) {
            unset($current[$key]);
        } else {
            $current[$key] = $value;
        }
    }
    return '?' . http_build_query($current);
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Forum Diskusi - SDGs: Life Below Water</title>
    <link rel="stylesheet" href="./assets/css/forum.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Additional inline styles untuk search bar */
        .search-container {
            position: relative;
            margin-bottom: 25px;
        }
        
/* Ikon search kecil di kanan seperti screenshot */
.search-button-wrapper {
    position: relative;
    display: inline-block;
}

.search-icon-only {
    background: transparent;
    border: none;
    cursor: pointer;
    font-size: 16px;
    color: #6b7280;
    padding: 6px;
    transition: color 0.2s;
}

.search-icon-only:hover {
    color: #111;
}

/* Box input kecil yang muncul saat ikon diklik */
.search-box-hidden {
    display: none;
    margin-top: 10px;
}

.search-box-hidden input {
    width: 260px;
    padding: 10px 14px;
    font-size: 14px;
    border-radius: 10px;
    border: 1px solid #d1d5db;
}



        
        .btn-search {
            padding: 10px 20px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 0 8px 8px 0;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .btn-search:hover {
            background: #1d4ed8;
        }
        
        .btn-clear-search {
            padding: 8px 12px;
            background: #f3f4f6;
            color: #666;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-right: 10px;
        }
        
        .btn-clear-search:hover {
            background: #e5e7eb;
            color: #333;
        }
        
        .search-results-info {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 15px;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            color: #1e40af;
        }
        
        .search-results-info i {
            color: #2563eb;
        }
        
        .search-highlight {
            background-color: #fef08a;
            padding: 2px 4px;
            border-radius: 3px;
            font-weight: 600;
        }
        
        .forum-header {
            margin-bottom: 0;
        }
        
        .forum-header h2 {
            font-size: 28px;
            font-weight: 700;
            color: #111;
            margin-bottom: 25px;
        }
        
        .filter-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            border-bottom: 2px solid #f3f4f6;
            padding-bottom: 0;
        }
        
        .filter-tabs .tab {
            padding: 10px 20px;
            text-decoration: none;
            color: #666;
            font-weight: 500;
            border-bottom: 2px solid transparent;
            margin-bottom: -2px;
            transition: all 0.2s;
            font-size: 14px;
        }
        
        .filter-tabs .tab:hover {
            color: #2563eb;
        }
        
        .filter-tabs .tab.active {
            color: #2563eb;
            border-bottom-color: #2563eb;
        }
        
        .search-sort {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        
        .search-form {
            flex: 1;
            display: flex;
            gap: 10px;
        }
        
        .search-form select {
            flex: 1;
            padding: 10px 15px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            color: #333;
            cursor: pointer;
            background-color: white;
        }
        
        .search-form select:focus {
            outline: none;
            border-color: #2563eb;
        }
        
        .post-card {
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .post-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .category-list .count {
            background-color: #e5e7eb;
            color: #666;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 600;
            margin-left: auto;
        }
        
        .category-list a {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        /* ========== HEADER ROW (sesuai screenshot) ========== */
.forum-header-row {
    display: flex;
    align-items: center;
    gap: 24px;
    margin-bottom: 22px;
    margin-top: -10px;
}

.forum-header-row h2 {
    font-size: 26px;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
}

/* Search icon */
.header-search-btn {
    background: transparent;
    border: none;
    font-size: 18px;
    color: #6b7280;
    cursor: pointer;
    padding: 6px;
}

.header-search-btn:hover {
    color: #374151;
}

/* Tabs like screenshot */
.header-tabs {
    display: flex;
    align-items: center;
    gap: 10px;
}

.htab {
    padding: 8px 22px;
    border-radius: 12px;
    background: #eef2ff;
    color: #52525b;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
}

.htab.active {
    background: #3b5bfd;
    color: white;
}

/* Dropdown kategori */
.header-select {
    padding: 10px 15px;
    border-radius: 12px;
    border: 1px solid #d1d5db;
    font-size: 14px;
    color: #111;
    background: #fff;
}

        @media (max-width: 768px) {
            .search-container {
                margin-bottom: 20px;
            }
            
            .btn-search {
                padding: 10px 15px;
            }
            
            .search-results-info {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
        }
    </style>
</head>
<body>

<div class="forum-container">
    <aside class="sidebar">
        <button class="btn-primary btn-ask" onclick="window.location.href='create_post.php'">
            <i class="fas fa-plus"></i> Ask your question
        </button>

        <div class="sidebar-section">
            <h3>Kategori</h3>
            <ul class="category-list">
                <li>
                    <a href="?" class="<?= empty($kategori_filter) ? 'active' : '' ?>">
                        Semua Kategori
                        <span class="count"><?= $total ?></span>
                    </a>
                </li>
                <?php foreach($category_stats as $kat): ?>
                <li>
                    <a href="?category=<?= $kat['id'] ?>&filter=<?= $filter ?><?= $search_query ? '&q='.urlencode($search_query) : '' ?>" 
                       class="<?= $kategori_filter == $kat['id'] ? 'active' : '' ?>">
                        <?= htmlspecialchars($kat['name']) ?>
                        <span class="count"><?= $kat['jumlah'] ?></span>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="sidebar-section">
            <h3>Popular Questions</h3>
            <ul class="popular-list">
                <?php foreach($popular_questions as $pq): ?>
                <li>
                    <a href="post_detail.php?id=<?= $pq['id'] ?>">
                        <?= htmlspecialchars($pq['title']) ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </aside>

    <main class="main">
        <div class="forum-header">
<div class="forum-header-row">
    
    <h2>Forum Diskusi</h2>

    <!-- ICON SEARCH -->
    <button class="header-search-btn">
        <i class="fas fa-search"></i>
        
    </button>
    <!-- SEARCH BOX (hidden by default) -->
<form id="searchForm" method="GET" class="search-box-hidden">
    <input type="text" name="q" id="searchInput" placeholder="Cari diskusi..." />
    <?php if($kategori_filter): ?>
        <input type="hidden" name="category" value="<?= $kategori_filter ?>">
    <?php endif; ?>
    <?php if($filter): ?>
        <input type="hidden" name="filter" value="<?= $filter ?>">
    <?php endif; ?>
</form>


    <!-- FILTER TABS -->
    <div class="header-tabs">
        <a href="<?= build_url(['filter' => 'terbaru']) ?>" 
           class="htab <?= $filter === 'terbaru' ? 'active' : '' ?>">Terbaru</a>

        <a href="<?= build_url(['filter' => 'populer']) ?>" 
           class="htab <?= $filter === 'populer' ? 'active' : '' ?>">Populer</a>

        <a href="<?= build_url(['filter' => 'belum_dijawab']) ?>" 
           class="htab <?= $filter === 'belum_dijawab' ? 'active' : '' ?>">Belum Dijawab</a>
    </div>

    <!-- DROPDOWN -->
    <form method="GET" id="kategoriForm">
        <select name="category" class="header-select" onchange="document.getElementById('kategoriForm').submit()">
            <option value="all">Semua Kategori</option>
            <?php foreach($categories as $c): ?>
                <option value="<?= $c['id'] ?>" 
                    <?= $kategori_filter == $c['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($c['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="hidden" name="filter" value="<?= $filter ?>">
        <?php if($search_query): ?>
            <input type="hidden" name="q" value="<?= $search_query ?>">
        <?php endif; ?>
    </form>

</div>

</div>

            
            <!-- Search Results Info -->
            <?php if($search_query): ?>
                <div class="search-results-info">
                    <i class="fas fa-info-circle"></i>
                    <span>
                        Menampilkan <strong><?= $total ?></strong> hasil untuk 
                        "<strong><?= htmlspecialchars($search_query) ?></strong>"
                    </span>
                    <a href="?<?= http_build_query(array_diff_key($_GET, ['q' => ''])) ?>" 
                       class="btn-clear-search">
                        <i class="fas fa-times"></i>
                        Hapus Pencarian
                    </a>
                </div>
            <?php endif; ?>
            


        <div id="postList">
            <?php if(mysqli_num_rows($res) == 0): ?>
                <div class="no-posts">
                    <i class="fas fa-search"></i>
                    <?php if($search_query): ?>
                        <p>Tidak ada hasil untuk "<?= htmlspecialchars($search_query) ?>"</p>
                        <p style="font-size: 14px; color: #666; margin-top: 10px;">
                            Coba gunakan kata kunci lain atau <a href="?" style="color: #2563eb;">hapus filter pencarian</a>
                        </p>
                    <?php else: ?>
                        <p>Belum ada diskusi. Jadilah yang pertama bertanya!</p>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <?php while($post = mysqli_fetch_assoc($res)): ?>
                <div class="post-card" onclick="window.location='post_detail.php?id=<?= $post['id'] ?>'">
                    <div class="post-header">
                        <img src="./uploads_forum/<?= $post['foto_profil'] ?: 'default-avatar.png' ?>" 
                             alt="<?= htmlspecialchars($post['fullname']) ?>" 
                             class="post-avatar">
                        <div>
                            <div class="post-author"><?= htmlspecialchars($post['fullname']) ?></div>
                            <div class="post-time"><?= time_elapsed($post['created_at']) ?></div>
                        </div>
                        <?php if($post['category_name']): ?>
                            <span class="post-category"><?= htmlspecialchars($post['category_name']) ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="post-title">
                        <?php 
                        $title = htmlspecialchars($post['title']);
                        if($search_query) {
                            $title = preg_replace('/(' . preg_quote($search_query, '/') . ')/i', '<span class="search-highlight">$1</span>', $title);
                        }
                        echo $title;
                        ?>
                    </div>
                    <div class="post-desc">
                        <?php 
                        $content = htmlspecialchars(substr($post['content'], 0, 200));
                        if($search_query) {
                            $content = preg_replace('/(' . preg_quote($search_query, '/') . ')/i', '<span class="search-highlight">$1</span>', $content);
                        }
                        echo $content;
                        echo strlen($post['content']) > 200 ? '...' : '';
                        ?>
                    </div>

                    <div class="post-footer">
                        <span>
                            <i class="fas fa-comment"></i> 
                            <?= $post['jumlah_jawaban'] ?> jawaban
                        </span>
                        <span>
                            <i class="fas fa-eye"></i> 
                            <?= $post['jumlah_views'] ?> views
                        </span>
                        <span class="btn-balas">Balas</span>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>

        <?php if($totalPages > 1): ?>
        <div class="pagination">
            <?php if($page > 1): ?>
                <a class="page-btn" href="?page=<?= $page-1 ?>&filter=<?= $filter ?><?= $kategori_filter ? '&category='.$kategori_filter : '' ?>">
                    <i class="fas fa-chevron-left"></i>
                </a>
            <?php endif; ?>

            <?php for($i = 1; $i <= $totalPages; $i++): ?>
                <?php if($i == $page): ?>
                    <span class="page-btn active"><?= $i ?></span>
                <?php else: ?>
                    <a class="page-btn" 
                       href="?page=<?= $i ?>&filter=<?= $filter ?><?= $kategori_filter ? '&category='.$kategori_filter : '' ?>">
                        <?= $i ?>
                    </a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if($page < $totalPages): ?>
                <a class="page-btn" href="?page=<?= $page+1 ?>&filter=<?= $filter ?><?= $kategori_filter ? '&category='.$kategori_filter : '' ?>">
                    <i class="fas fa-chevron-right"></i>
                </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </main>
</div>

<script src="./assets/js/forum.js"></script>
<script>
const btn = document.querySelector('.search-icon-btn');
const popup = document.getElementById('searchBox');

btn.addEventListener('click', () => {
    popup.style.display = popup.style.display === 'block' ? 'none' : 'block';

    const input = popup.querySelector('input');
    setTimeout(() => input.focus(), 100);
});

// Close when clicking outside
document.addEventListener('click', function(e) {
    if (!popup.contains(e.target) && !btn.contains(e.target)) {
        popup.style.display = 'none';
    }
});
</script>



</body>
</html>