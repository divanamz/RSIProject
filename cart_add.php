<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "NOT_LOGGED_IN";
    exit;
}

$user_id = $_SESSION['user_id'];

$merch_id = $_POST['merch_id'] ?? 0;
$quantity = (int)($_POST['quantity'] ?? 0);

if ($quantity <= 0) {
    echo "INVALID_QTY";
    exit;
}

$q = mysqli_query($conn, "SELECT price FROM merchandise WHERE merch_id='$merch_id'");
$merch = mysqli_fetch_assoc($q);

if (!$merch) {
    echo "NOT_FOUND";
    exit;
}

$price = $merch['price'];
$subtotal = $price * $quantity;

$check = mysqli_query($conn, "
    SELECT * FROM cart 
    WHERE user_id='$user_id' AND merch_id='$merch_id'
");

if (mysqli_num_rows($check) > 0) {
    mysqli_query($conn, "
        UPDATE cart 
        SET quantity = quantity + $quantity,
            subtotal = (quantity + quantity) * $price
        WHERE user_id='$user_id' AND merch_id='$merch_id'
    ");
} else {
    mysqli_query($conn, "
        INSERT INTO cart (user_id, merch_id, quantity, subtotal)
        VALUES ('$user_id', '$merch_id', '$quantity', '$subtotal')
    ");
}

echo "SUCCESS";
?>
