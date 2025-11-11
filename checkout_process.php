<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit;
}

$user_id = $_POST['user_id'];
$merch_id = $_POST['merch_id'];
$quantity = $_POST['quantity'];
$total_price = $_POST['total_price'];
$payment_method = $_POST['payment_method'];
$shipping_address = $_POST['shipping_address'];
$shipping_courier = $_POST['shipping_courier'];
$date = date("Y-m-d H:i:s");

// Buat ID acak untuk cart sementara (opsional)
$cart_id = uniqid("CART");

// Simpan ke transaksi
$query = "INSERT INTO transaction 
(user_id, cart_id, transaction_date, total_price, transaction_status, payment_method, shipping_address, shipping_courier, tracking_number)
VALUES 
('$user_id', '$cart_id', '$date', '$total_price', 'pending', '$payment_method', '$shipping_address', '$shipping_courier', '')";

if (mysqli_query($conn, $query)) {
  echo "<script>alert('Transaksi berhasil dibuat!'); window.location='dashboard.php';</script>";
} else {
  echo "Error: " . mysqli_error($conn);
}
?>
