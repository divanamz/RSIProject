<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$cart_id = $_POST['cart_id'];
$action = $_POST['action'];

$data = mysqli_query($conn, "SELECT * FROM cart WHERE cart_id='$cart_id'");
$row = mysqli_fetch_assoc($data);

if (!$row) { exit("Cart not found"); }

$qty = $row['quantity'];

if ($action == "plus") {
    $qty++;
}
if ($action == "minus") {
    if ($qty > 1) $qty--;
}
if ($action == "delete") {
    mysqli_query($conn, "DELETE FROM cart WHERE cart_id='$cart_id'");
    header("Location: cart.php");
    exit;
}

$merch_id = $row['merch_id'];
$m = mysqli_fetch_assoc(mysqli_query($conn, "SELECT price FROM merchandise WHERE merch_id='$merch_id'"));
$newSubtotal = $qty * $m['price'];

mysqli_query($conn, "UPDATE cart SET quantity='$qty', subtotal='$newSubtotal' WHERE cart_id='$cart_id'");

header("Location: cart.php");
exit;
?>
<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$cart_id = $_POST['cart_id'];
$action = $_POST['action'];

$data = mysqli_query($conn, "SELECT * FROM cart WHERE cart_id='$cart_id'");
$row = mysqli_fetch_assoc($data);

if (!$row) { exit("Cart not found"); }

$qty = $row['quantity'];

if ($action == "plus") {
    $qty++;
}
if ($action == "minus") {
    if ($qty > 1) $qty--;
}
if ($action == "delete") {
    mysqli_query($conn, "DELETE FROM cart WHERE cart_id='$cart_id'");
    header("Location: cart.php");
    exit;
}

$merch_id = $row['merch_id'];
$m = mysqli_fetch_assoc(mysqli_query($conn, "SELECT price FROM merchandise WHERE merch_id='$merch_id'"));
$newSubtotal = $qty * $m['price'];

mysqli_query($conn, "UPDATE cart SET quantity='$qty', subtotal='$newSubtotal' WHERE cart_id='$cart_id'");

header("Location: cart.php");
exit;
?>
