<?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php"); 
        exit;
    }

    include "koneksi.php";
    include "header.php";
    $message = '';
    if (isset($_GET['status'])) {
        if ($_GET['status'] === 'success') {
            $message = '<p style="color: green; font-weight: bold; text-align: center;">Blog berhasil diunggah!</p>';
        } elseif ($_GET['status'] === 'error') {
            $message = '<p style="color: red; font-weight: bold; text-align: center;">Gagal mengunggah blog. Silakan coba lagi.</p>';
        } elseif (isset($_GET['message'])) {
            $message = '<p style="color: red; font-weight: bold; text-align: center;">Error: ' . htmlspecialchars($_GET['message']) . '</p>';
        }
    }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Blog Baru</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="blog_add.css">
</head>
<body>
    <div class="main-content">
        <div class="form-container">
            <div class="form-header">
                <a href="blog_myblog.php" style="margin-right: 15px; font-size: 24px; text-decoration: none; color: #333;">&leftarrow;</a>
                <h2>Unggah Blog Baru</h2>
            </div>

            <?= $message ?>
            
            <form action="upload_process.php" method="POST" enctype="multipart/form-data">
                <div class="form-content">
                    
                    <div class="form-fields">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" id="title" name="title" placeholder="Put your Title here" required>
                        </div>

                        <div class="form-group">
                            <label for="keywords">Keyword (Pisahkan dengan koma)</label>
                            <input type="text" id="keywords" name="keywords" placeholder="Keyword1, Keyword2, Keyword3,..." required>
                        </div>
                        
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea id="content" name="content" placeholder="Here is where you type your blog contents" required></textarea>
                        </div>
                    </div>

                    <div class="image-section">
                        <div class="image-upload-box" id="upload_area">
                            <input type="file" id="image_file" name="image_file" hidden accept="image/*">

                            <div id="upload_text">+ Upload Image</div>

                            <img id="preview_img" style="display:none;">
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="cancel-btn" onclick="window.location.href='blog_myblog.php'">Cancel</button>
                    <button type="submit" name="upload" class="upload-btn">Upload</button>
                </div>
            </form>
        </div>
    </div>

    <footer class="footer">
    </footer>
    <script>
        const inputFile = document.getElementById("image_file");
        const previewImg = document.getElementById("preview_img");
        const uploadText = document.getElementById("upload_text");
        const uploadBox = document.getElementById("upload_area");

        uploadBox.onclick = () => inputFile.click();

        inputFile.addEventListener("change", function() {
            const file = this.files[0];

            if (!file) return;

            // VALIDASI TYPE
            const allowedTypes = ["image/jpeg", "image/png", "image/webp"];
            if (!allowedTypes.includes(file.type)) {
                alert("Format hanya boleh JPG, PNG, atau WEBP.");
                this.value = "";
                return;
            }

            // VALIDASI SIZE (max 3MB)
            if (file.size > 3 * 1024 * 1024) {
                alert("Ukuran gambar maksimal 3MB!");
                this.value = "";
                return;
            }

            // PREVIEW GAMBAR
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewImg.style.display = "block";
                uploadText.style.display = "none";
            }
            reader.readAsDataURL(file);
        });
    </script>


</body>
</html>