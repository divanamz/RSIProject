<?php
session_start();
include "koneksi.php";

$blog_id = intval($_POST['blog_id']);
$issue = mysqli_real_escape_string($conn, $_POST['report_issue']);

// Simpan report
mysqli_query($conn, "INSERT INTO blog_report (blog_id, user_id, report_issue, date_reported)
                     VALUES ($blog_id, ".$_SESSION['user_id'].", '$issue', NOW())");

// BUAT FLASH MESSAGE
$_SESSION['report_success'] = "Blog telah dilaporkan.";

// Redirect kembali ke detail
header("Location: blog_detail.php?id=" . $blog_id);
exit;
