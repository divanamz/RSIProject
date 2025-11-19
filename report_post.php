<?php
include __DIR__ . '../db_connect.php';
if(!isset($_GET['id'])) { header('Location: forum.php'); exit; }
$id = intval($_GET['id']);
// in real app, show a form to pick reason. for now we auto-insert a generic reason by current user
$user_id = 1;
$reason = mysqli_real_escape_string($conn, 'Dilaporkan oleh pengguna dari UI');
mysqli_query($conn, "INSERT INTO forum_reports (post_id, user_id, reason) VALUES ($id, $user_id, '$reason')");
header('Location: post_detail.php?id='.$id);
exit;
?>