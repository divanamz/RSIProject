<?php
include 'koneksi.php';
session_start();

function log_msg($text) {
    file_put_contents(__DIR__ . '/checkout_debug.log', date("[Y-m-d H:i:s] ") . $text . PHP_EOL, FILE_APPEND);
}

log_msg("=== START REQUEST ===");

if (!isset($_SESSION['user_id'])) {
    log_msg("NO SESSION USER");
    echo "ERROR: not_logged_in";
    exit;
}
log_msg("SESSION OK");

$post = $_POST;
log_msg("POST: " . json_encode($post));

$user_id = $_SESSION['user_id'] ?? null;
$merch_id = isset($_POST['merch_id']) ? intval($_POST['merch_id']) : null;
$qty = isset($_POST['quantity']) ? intval($_POST['quantity']) : null;
$total = isset($_POST['total']) ? floatval($_POST['total']) : null;
$nama = $_POST['nama'] ?? '';
$alamat = $_POST['alamat'] ?? '';
$kota = $_POST['kota'] ?? '';
$provinsi = $_POST['provinsi'] ?? '';
$kodepos = $_POST['kodepos'] ?? '';

if (empty($nama) || empty($alamat) || empty($kota) || empty($provinsi) || empty($kodepos)) {
    log_msg("ERROR: Form incomplete");
    echo "ERROR: Semua field alamat harus diisi";
    exit;
}

if (!$user_id) {
    log_msg("ERROR: session user id empty");
    echo "ERROR: session user id empty";
    exit;
}
if (!$merch_id || $qty <= 0 || $total <= 0) {
    log_msg("ERROR: invalid input - merch_id:$merch_id qty:$qty total:$total");
    echo "ERROR: invalid input";
    exit;
}

$address_full = trim("$nama, $alamat, $kota, $provinsi, $kodepos");
log_msg("Address: $address_full");

$cols = [];
$res = mysqli_query($conn, "SHOW COLUMNS FROM `transactions`");
if (!$res) {
    $err = mysqli_error($conn);
    log_msg("SHOW COLUMNS FAILED: $err");
    echo "SQL ERROR: $err";
    exit;
}
while ($row = mysqli_fetch_assoc($res)) {
    $cols[] = $row['Field'];
}
log_msg("transactions cols: " . implode(',', $cols));

$fields = [];
$values = [];

if (in_array('user_id', $cols)) { $fields[] = 'user_id'; $values[] = "'" . intval($user_id) . "'"; }

if (in_array('merch_id', $cols)) { $fields[] = 'merch_id'; $values[] = "'" . intval($merch_id) . "'"; }

if (in_array('quantity', $cols)) { $fields[] = 'quantity'; $values[] = "'" . intval($qty) . "'"; }

if (in_array('cart_id', $cols)) { $fields[] = 'cart_id'; $values[] = "NULL"; }

if (in_array('transaction_date', $cols)) { $fields[] = 'transaction_date'; $values[] = "NOW()"; }

if (in_array('total_price', $cols)) { $fields[] = 'total_price'; $values[] = "'" . mysqli_real_escape_string($conn, $total) . "'"; }

if (in_array('payment_method', $cols)) { $fields[] = 'payment_method'; $values[] = "'QRIS'"; }

if (in_array('shipping_address', $cols)) { $fields[] = 'shipping_address'; $values[] = "'" . mysqli_real_escape_string($conn, $address_full) . "'"; }

if (in_array('shipping_courier', $cols)) { $fields[] = 'shipping_courier'; $values[] = "'JNE'"; }

if (in_array('tracking_number', $cols)) { $fields[] = 'tracking_number'; $values[] = "NULL"; }

if (count($fields) === 0) {
    log_msg("ERROR: no matching columns to insert");
    echo "ERROR: no matching columns to insert";
    exit;
}

$fields_sql = implode(", ", $fields);
$values_sql = implode(", ", $values);
$query = "INSERT INTO `transactions` ($fields_sql) VALUES ($values_sql)";
log_msg("INSERT QUERY: $query");

if (!mysqli_query($conn, $query)) {
    $err = mysqli_error($conn);
    log_msg("INSERT FAILED: $err");
    echo "SQL ERROR: $err";
    exit;
}

$last_id = mysqli_insert_id($conn);
log_msg("INSERT OK id=$last_id");

if (mysqli_query($conn, "SHOW COLUMNS FROM `merchandise` LIKE 'stock'") && mysqli_num_rows(mysqli_query($conn, "SHOW COLUMNS FROM `merchandise` LIKE 'stock'"))>0) {
    mysqli_query($conn, "UPDATE merchandise SET stock = stock - $qty WHERE merch_id = $merch_id");
    log_msg("STOCK UPDATED");
}

echo "OK";
log_msg("=== END REQUEST (OK) id=$last_id ===");
exit;
