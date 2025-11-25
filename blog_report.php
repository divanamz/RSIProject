<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";
include "header.php";

$blog_id = intval($_GET['id']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Report Blog</title>
    <link rel="stylesheet" href="blog_report.css">
</head>
<body>

<div class="report-container">

    <div class="report-header">
        <h2>Laporkan Blog</h2>
    </div>

    <form action="blog_reportprocess.php" method="POST">
        <input type="hidden" name="blog_id" value="<?= $blog_id ?>">

        <div class="report-group">
            <label>Alasan Report:</label>
            <textarea name="report_issue" required></textarea>
        </div>

        <div class="report-actions">
            <a href="blog_detail.php?id=<?= $blog_id ?>" class="cancel-report-btn" style="text-decoration:none; padding:10px 20px; border-radius:4px;">Batal</a>
            <button type="submit" class="submit-report-btn">Kirim Report</button>
        </div>
    </form>

</div>

</body>
</html>
