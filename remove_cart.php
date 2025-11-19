<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM cart WHERE cart_id='$id'");
header("Location: cart.php");
exit;
?>
