<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";
include "header.php";

if (!isset($_GET['id'])) {
    header("Location: blog_myblog.php");
    exit;
}

$blog_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// Ambil data blog + tag
$query = "
    SELECT b.*, GROUP_CONCAT(t.tag_name SEPARATOR ', ') AS tags
    FROM blog b
    LEFT JOIN blog_tag bt ON bt.blog_id = b.blog_id
    LEFT JOIN tag t ON t.tag_id = bt.tag_id
    WHERE b.blog_id = $blog_id AND b.user_id = $user_id
    GROUP BY b.blog_id
";

$data = $conn->query($query)->fetch_assoc();

if (!$data) {
    echo "Blog tidak ditemukan!";
    exit;
}

$message = '';
if (isset($_GET['status']) && $_GET['status'] === 'success') {
    $message = '<p style="color: green; text-align:center; font-weight:bold;">Blog berhasil diperbarui!</p>';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog</title>
    <link rel="stylesheet" href="blog_add.css">
</head>
<body>

<div class="main-content">
    <div class="form-container">

        <div class="form-header">
            <a href="blog_myblog.php" style="margin-right: 15px; font-size: 24px; text-decoration: none; color: #333;">&leftarrow;</a>
            <h2>Edit Blog</h2>
        </div>

        <?= $message ?>

        <form action="blog_editprocess.php" method="POST" enctype="multipart/form-data">

            <input type="hidden" name="blog_id" value="<?= $data['blog_id'] ?>">

            <div class="form-content">

                <!-- LEFT SIDE -->
                <div class="form-fields">

                    <div class="form-group">
                        <label for="title">Title</label>
                        <input 
                            type="text"
                            id="title"
                            name="title"
                            value="<?= htmlspecialchars($data['title_blog']) ?>"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="keywords">Keyword (Pisahkan dengan koma)</label>
                        <input
                            type="text"
                            id="keywords"
                            name="keywords"
                            value="<?= htmlspecialchars($data['tags']) ?>"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea id="content" name="content_blog" required><?= htmlspecialchars($data['content_blog']) ?></textarea>
                    </div>
                </div>

                <!-- RIGHT SIDE -->
                <div class="image-section">

                    <div class="image-upload-box" id="upload_area">
                        <input
                            type="file"
                            id="image_file"
                            name="image_file"
                            hidden
                            accept="image/*"
                        >

                        <div id="upload_text" style="display: <?= $data['image_path'] ? 'none' : 'block' ?>;">
                            + Upload Image
                        </div>

                        <img
                            id="preview_img"
                            src="<?= $data['image_path'] ?>"
                            style="display: <?= $data['image_path'] ? 'block' : 'none' ?>;"
                        >
                    </div>

                </div>

            </div>

            <div class="form-actions">
                <button type="button" class="cancel-btn" onclick="window.location.href='blog_myblog.php'">Cancel</button>
                <button type="submit" name="update" class="upload-btn">Update</button>
            </div>

        </form>
    </div>
</div>

<script>
    const inputFile = document.getElementById("image_file");
    const previewImg = document.getElementById("preview_img");
    const uploadText = document.getElementById("upload_text");
    const uploadBox = document.getElementById("upload_area");

    uploadBox.onclick = () => inputFile.click();

    inputFile.addEventListener("change", function() {
        const file = this.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewImg.style.display = "block";
            uploadText.style.display = "none";
        };
        reader.readAsDataURL(file);
    });
</script>

</body>
</html>
