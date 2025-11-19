<?php
include __DIR__ . '../db_connect.php';
include 'header.php';

// 1. Ambil data kategori
$cats_result = mysqli_query($conn, "SELECT id, name FROM forum_categories ORDER BY name");
// Periksa jika query berhasil dan ambil semua baris ke dalam array
$categories = [];
if ($cats_result) {
    while ($cat = mysqli_fetch_assoc($cats_result)) {
        $categories[] = $cat;
    }
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    // === PERBAIKAN PENTING DI SINI ===
    
    // Ambil data dari $_POST dengan nama yang benar (sesuai 'name' HTML)
    $judul_post = $_POST['judul'] ?? ''; // Ambil dari input name="judul"
    $kategori_id_post = $_POST['category'] ?? 0;
    $konten_post = $_POST['konten'] ?? ''; // Ambil dari textarea name="konten"
    
    // Sanitasi/validasi data sebelum digunakan
    $title = mysqli_real_escape_string($conn, $judul_post);
    $category_id = intval($kategori_id_post);
    $content = mysqli_real_escape_string($conn, $konten_post);

    // TODO: Replace with logged-in user id
    $user_id = 1;

    // Pastikan variabel $title, $category_id, dan $content yang disiapkan yang digunakan di query
    $ins = mysqli_query($conn, "INSERT INTO forum_posts (user_id, category_id, title, content) VALUES ($user_id, $category_id, '$title', '$content')");
    
    if($ins) {
        header('Location: forum.php');
        exit;
    } else {
        $error = mysqli_error($conn);
    }
}

$error = '';
$success = '';

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Pertanyaan - Life Below Water</title>
    <!-- <link rel="stylesheet" href="./assets/css/forum.css"> -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .create-post-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .create-post-card {
            background: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .create-post-header {
            margin-bottom: 30px;
        }
        
        .create-post-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: #111;
            margin-bottom: 10px;
        }
        
        .create-post-header p {
            color: #666;
            font-size: 14px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .form-group label .required {
            color: #ef4444;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.2s;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        
        textarea.form-control {
            min-height: 200px;
            resize: vertical;
        }
        
        .char-count {
            text-align: right;
            font-size: 12px;
            color: #999;
            margin-top: 5px;
        }
        
        .form-select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            background-color: white;
            cursor: pointer;
            transition: border-color 0.2s;
        }
        
        .form-select:focus {
            outline: none;
            border-color: #2563eb;
        }
        
        .form-hint {
            font-size: 13px;
            color: #666;
            margin-top: 5px;
        }
        
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .alert-error {
            background-color: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }
        
        .alert-success {
            background-color: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }
        
        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #f3f4f6;
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-primary {
            background-color: #2563eb;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #1d4ed8;
        }
        
        .btn-secondary {
            background-color: #f3f4f6;
            color: #333;
        }
        
        .btn-secondary:hover {
            background-color: #e5e7eb;
        }
        
        .tips-box {
            background-color: #eff6ff;
            border-left: 4px solid #2563eb;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        
        .tips-box h3 {
            font-size: 16px;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 10px;
        }
        
        .tips-box ul {
            list-style: none;
            padding-left: 0;
        }
        
        .tips-box li {
            padding: 5px 0;
            color: #1e40af;
            font-size: 14px;
        }
        
        .tips-box li:before {
            content: "✓ ";
            font-weight: bold;
            margin-right: 8px;
        }
        
        @media (max-width: 768px) {
            .create-post-card {
                padding: 25px;
            }
            
            .form-actions {
                flex-direction: column-reverse;
            }
            
            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <!-- Create Post Form -->
    <div class="create-post-container">
        <div class="create-post-card">
            <div class="create-post-header">
                <h1>Ajukan Pertanyaan</h1>
                <p>Bagikan pertanyaan Anda dengan komunitas Life Below Water</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <div class="tips-box">
                <h3><i class="fas fa-lightbulb"></i> Tips untuk pertanyaan yang baik:</h3>
                <ul>
                    <li>Buat judul yang spesifik dan deskriptif</li>
                    <li>Jelaskan konteks dan detail masalah Anda</li>
                    <li>Pilih kategori yang sesuai</li>
                    <li>Gunakan bahasa yang sopan dan mudah dipahami</li>
                </ul>
            </div>

            <form method="POST" action="" id="createPostForm">
                <div class="form-group">
                    <label for="judul">
                        Judul Pertanyaan <span class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="judul" 
                        name="judul" 
                        class="form-control" 
                        placeholder="Contoh: Bagaimana cara bergabung menjadi volunteer konservasi terumbu karang?"
                        value="<?= htmlspecialchars($_POST['title'] ?? '') ?>"
                        required
                        maxlength="200"
                    >
                    <div class="char-count">
                        <span id="judulCount">0</span>/200
                    </div>
                </div>

                <div class="form-group">
                    <label for="category">
                        Kategori <span class="required">*</span>
                    </label>
                    <select id="category" name="category" class="form-select" required>
                        <option value="">Pilih kategori...</option>
                        <?php foreach($categories as $cat):
                          $cat_id = htmlspecialchars($cat['id']);
                          $cat_name = htmlspecialchars($cat['name']);
                          $selected_category = isset($_POST['category']) ? intval($_POST['category']) : null;
                        ?>
                            <option value="<?= htmlspecialchars($cat_id) ?>" 
                                    <?= ($selected_category === $cat['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat_name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="form-hint">Pilih kategori yang paling sesuai dengan pertanyaan Anda</div>
                </div>

                <div class="form-group">
                    <label for="konten">
                        Detail Pertanyaan <span class="required">*</span>
                    </label>
                    <textarea 
                        id="konten" 
                        name="konten" 
                        class="form-control" 
                        placeholder="Jelaskan pertanyaan Anda dengan detail. Sertakan konteks, apa yang sudah Anda coba, dan informasi relevan lainnya..."
                        required
                        maxlength="5000"
                    ><?= htmlspecialchars($_POST['content'] ?? '') ?></textarea>
                    <div class="char-count">
                        <span id="kontenCount">0</span>/5000
                    </div>
                </div>

                <div class="form-actions">
                    <a href="forum.php" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Posting Pertanyaan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
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

    <script>
        // Character counter
        const judulInput = document.getElementById('judul');
        const kontenTextarea = document.getElementById('konten');
        const judulCount = document.getElementById('judulCount');
        const kontenCount = document.getElementById('kontenCount');

        function updateCharCount(input, counter, max) {
            const length = input.value.length;
            counter.textContent = length;
            
            if (length > max * 0.9) {
                counter.style.color = '#ef4444';
            } else if (length > max * 0.7) {
                counter.style.color = '#f59e0b';
            } else {
                counter.style.color = '#999';
            }
        }

        judulInput.addEventListener('input', function() {
            updateCharCount(this, judulCount, 200);
        });

        kontenTextarea.addEventListener('input', function() {
            updateCharCount(this, kontenCount, 5000);
        });

        // Initialize counts
        updateCharCount(judulInput, judulCount, 200);
        updateCharCount(kontenTextarea, kontenCount, 5000);

        // Form validation
        document.getElementById('createPostForm').addEventListener('submit', function(e) {
            const judul = judulInput.value.trim();
            const konten = kontenTextarea.value.trim();
            const kategori = document.getElementById('category').value;

            if (judul.length < 10) {
                e.preventDefault();
                alert('Judul harus minimal 10 karakter');
                judulInput.focus();
                return false;
            }

            if (konten.length < 20) {
                e.preventDefault();
                alert('Konten harus minimal 20 karakter');
                kontenTextarea.focus();
                return false;
            }

            if (!kategori) {
                e.preventDefault();
                alert('Silakan pilih kategori');
                return false;
            }
        });
    </script>
</body>
</html>
