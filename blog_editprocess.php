<?php
session_start();
include "koneksi.php";

if (!isset($_POST['update'])) {
    header("Location: blog_myblog.php");
    exit;
}

$blog_id = intval($_POST['blog_id']);
$user_id = $_SESSION['user_id'];

$title = $_POST['title'];
$content = $_POST['content_blog'];
$keywords = $_POST['keywords'];

// Update blog
if (!empty($_FILES['image_file']['name'])) {

    $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp'];
    $file_extension = strtolower(pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION));

    if (!in_array($file_extension, $allowed_extensions)) {
        header("Location: edit_blog.php?id=$blog_id&status=error&message=" . urlencode("Format gambar tidak valid."));
        exit;
    }

    // Folder WAJIB sama dengan blog_addprocess.php
    $upload_dir = "uploads/blog_images/";

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Nama file mengikuti ADD BLOG (uniqid)
    $new_filename = uniqid('blog_', true) . "." . $file_extension;

    // Path final (HARUS SAMA)
    $target_file = $upload_dir . $new_filename;

    // Upload file
    if (!move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file)) {
        header("Location: edit_blog.php?id=$blog_id&status=error&message=" . urlencode("Gagal mengupload gambar."));
        exit;
    }

    $imageName = $target_file;   // path ke DB sama seperti ADD

    $stmt = $conn->prepare("
        UPDATE blog 
        SET title_blog=?, content_blog=?, image_path=? 
        WHERE blog_id=? AND user_id=?
    ");
    $stmt->bind_param("sssii", $title, $content, $imageName, $blog_id, $user_id);
}else {

    // UPDATE tanpa image_path
    $stmt = $conn->prepare("
        UPDATE blog 
        SET title_blog=?, content_blog=? 
        WHERE blog_id=? AND user_id=?
    ");
    $stmt->bind_param("ssii", $title, $content, $blog_id, $user_id);
}

$stmt->execute();

// Update tag
$conn->query("DELETE FROM blog_tag WHERE blog_id=$blog_id");

$tagList = explode(",", $keywords);
foreach ($tagList as $tag) {
    $tag = trim($tag);
    if ($tag == "") continue;

    // cek kalau tag sudah ada
    $check = $conn->query("SELECT tag_id FROM tag WHERE tag_name='$tag'");
    if ($check->num_rows > 0) {
        $tag_id = $check->fetch_assoc()['tag_id'];
    } else {
        $conn->query("INSERT INTO tag (tag_name) VALUES ('$tag')");
        $tag_id = $conn->insert_id;
    }

    $conn->query("INSERT INTO blog_tag (blog_id, tag_id) VALUES ($blog_id, $tag_id)");
}

header("Location: blog_edit.php?id=$blog_id&status=success");
exit;
