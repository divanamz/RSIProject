<?php
include __DIR__ . '../db_connect.php';
if(!isset($_GET['id'])) { header('Location: forum.php'); exit; }
$id = intval($_GET['id']);
// NOTE: In production check permission: only allow owner or admin
mysqli_query($conn, "DELETE FROM forum_posts WHERE id = $id");
header('Location: forum.php');
exit;
?>