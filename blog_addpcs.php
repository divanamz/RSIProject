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

if (isset($_POST['upload'])) {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $keywords_string = trim($_POST['keywords']); 
    
    if (empty($title) || empty($content) || empty($keywords_string)) {
        header('Location: blog_addform.php?status=error&message=' . urlencode('Judul, konten, dan keywords tidak boleh kosong.'));
        exit;
    }

    // LOGIKA UPLOAD GAMBAR DIBIARKAN SAMA (Ini akan mengisi $image_path_to_db)
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
        $file_tmp_name = $_FILES['image_file']['tmp_name'];
        $file_name = $_FILES['image_file']['name'];
        $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array($file_extension, $allowed_extensions)) {
            header('Location: tambahblog.php?status=error&message=' . urlencode('Hanya file JPG, JPEG, PNG, & WEBP yang diizinkan.'));
            exit;
        }

        $upload_dir = 'uploads/blog_images/'; 
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true); 
        }
        
        $new_file_name = uniqid('blog_', true) . '.' . $file_extension;
        $destination_path = $upload_dir . $new_file_name;

        if (move_uploaded_file($file_tmp_name, $destination_path)) {
            $image_path_to_db = $destination_path; 
        } else {
            header('Location: tambahblog.php?status=error&message=' . urlencode('Gagal memindahkan file upload.'));
            exit;
        }
    }

    $db->begin_transaction();
    
    try {
        // PERBAIKAN DI SINI: TAMBAHKAN KOLOM IMAGE_PATH KE QUERY INSERT
        $stmt = $db->prepare("INSERT INTO blog (user_id, title_blog, content_blog, image_path, date_posted) VALUES (?, ?, ?, ?, NOW())");
        
        // Tipe bind_param: i = integer, sss = 3 string (title, content, image_path)
        $stmt->bind_param("isss", $current_account_id, $title, $content, $image_path_to_db);
        
        if (!$stmt->execute()) {
            throw new Exception("Gagal insert blog: " . $stmt->error);
        }
        
        $blog_id = $db->insert_id; 
        $stmt->close();

        // ... (Logika INSERT TAGS dan COMMIT/ROLLBACK selanjutnya tetap sama)
        // Pastikan logika ROLLBACK juga menghapus file yang terlanjur diupload
        
        $keywords = array_unique(array_filter(array_map('trim', explode(',', $keywords_string))));
        
        if (!empty($keywords)) {
            $stmt_tag = $db->prepare("INSERT IGNORE INTO tag (tag_name) VALUES (?)"); 
            $stmt_blog_tag = $db->prepare("INSERT INTO blog_tag (blog_id, tag_id) VALUES (?, ?)");
            
            foreach ($keywords as $tag_name) {
                if (empty($tag_name)) continue;
                $stmt_tag->bind_param("s", $tag_name);
                $stmt_tag->execute();
                
                $tag_id_query = $db->prepare("SELECT tag_id FROM tag WHERE tag_name = ?");
                $tag_id_query->bind_param("s", $tag_name);
                $tag_id_query->execute();
                $result = $tag_id_query->get_result();
                $tag_row = $result->fetch_assoc();
                $tag_id = $tag_row['tag_id'];
                $tag_id_query->close();
                
                $stmt_blog_tag->bind_param("ii", $blog_id, $tag_id);
                if (!$stmt_blog_tag->execute()) {
                    if ($db->errno !== 1062) { 
                        throw new Exception("Gagal insert blog_tag: " . $db->error);
                    }
                }
            }
            $stmt_tag->close();
            $stmt_blog_tag->close();
        }
        
        $db->commit();
        header('Location: myblog.php?status=success');
        exit;

    } catch (Exception $e) {
        $db->rollback();
        // Hapus file yang terlanjur diupload jika terjadi error database
        if (isset($image_path_to_db) && file_exists($image_path_to_db)) {
            unlink($image_path_to_db);
        }
        
        header('Location: tambahblog.php?status=error&message=' . urlencode('Proses gagal: ' . $e->getMessage()));
        exit;
    }

} else {
    header('Location: tambahblog.php');
    exit;
}
?>