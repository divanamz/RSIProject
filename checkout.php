<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$merch_id = $_GET['merch_id'] ?? null;
$qty      = $_GET['qty'] ?? null;

if ($merch_id && $qty) {

    $merch_id = intval($merch_id);
    $qty = intval($qty);

    $sql = mysqli_query($conn, "SELECT * FROM merchandise WHERE merch_id = $merch_id");
    $merch = mysqli_fetch_assoc($sql);

    if (!$merch) {
        echo "Produk tidak ditemukan!";
        exit;
    }

    $items = [
        [
            "name" => $merch['merch_name'],
            "price" => $merch['price'],
            "qty" => $qty,
            "pict" => $merch['merch_pict'],
            "merch_id" => $merch['merch_id']
        ]
    ];

}

else {

    $sql = mysqli_query($conn,
    "SELECT c.quantity, m.price, m.merch_name, m.merch_pict, m.merch_id
     FROM cart c
     JOIN merchandise m ON c.merch_id = m.merch_id
     WHERE c.user_id = $user_id");

    if (mysqli_num_rows($sql) == 0) {
        echo "Keranjang kamu kosong!";
        exit;
    }

    $items = [];
    while ($row = mysqli_fetch_assoc($sql)) {
        $items[] = [
            "name" => $row['merch_name'],
            "price" => $row['price'],
            "qty" => $row['quantity'],
            "pict" => $row['merch_pict'],
            "merch_id" => $row['merch_id']
        ];
    }
}

$total_price = 0;
foreach ($items as $i) {
    $total_price += $i['price'] * $i['qty'];
}

$ongkir = 15000;
$grand_total = $total_price + $ongkir;
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Checkout</title><link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
  
<link rel="stylesheet" href="checkout.css">

<style>
.popup-bg {
  position: fixed;
  top:0; left:0;
  width:100%; height:100%;
  background: rgba(0,0,0,0.7);
  display:none;
  justify-content:center;
  align-items:center;
  z-index:999;
}
.popup-box {
  background:white;
  padding:20px;
  border-radius:10px;
  text-align:center;
  width:350px;
}
.popup-box img {
  width:100%;
  border-radius:8px;
  margin-bottom:15px;
}
.pay-now { cursor:pointer; }
</style>
</head>

<body>

<div class="checkout-container">

    <form id="checkoutForm">

        <h2>Informasi Pengiriman</h2>

        <label>Nama Lengkap</label>
        <input type="text" name="nama" required>

        <label>Alamat Lengkap</label>
        <textarea name="alamat" required></textarea>

        <label>Kota</label>
        <input type="text" name="kota" required>

        <label>Provinsi</label>
        <select name="provinsi" required>
            <option value="">Pilih Provinsi</option>
            <option>Jawa Timur</option>
            <option>Jawa Barat</option>
            <option>Jawa Tengah</option>
            <option>DKI Jakarta</option>
            <option>Bali</option>
        </select>

        <label>Kode Pos</label>
        <input type="text" name="kodepos" required>

        <label>Metode Pembayaran</label>
        <input type="text" value="QRIS" readonly style="background:#eee">

        <?php foreach ($items as $i): ?>
            <input type="hidden" name="merch_id[]" value="<?= $i['merch_id'] ?>">
            <input type="hidden" name="quantity[]" value="<?= $i['qty'] ?>">
        <?php endforeach; ?>

        <input type="hidden" name="total" value="<?= $grand_total ?>">

    </form>

    <div class="order-summary">
        <h3>Ringkasan Pesanan</h3>

        <?php foreach ($items as $i): ?>
        <div class="checkout-item">
            <img src="merch_img/<?= $i['pict'] ?>">
            <div>
                <h3><?= htmlspecialchars($i['name']) ?></h3>
                <p>Jumlah: <?= $i['qty'] ?></p>
                <p>Rp <?= number_format($i['price'], 0, ',', '.') ?></p>
            </div>
        </div>
        <?php endforeach; ?>

        <div class="summary-item">
            <span>Subtotal</span>
            <span>Rp <?= number_format($total_price, 0, ',', '.') ?></span>
        </div>

        <div class="summary-item">
            <span>Ongkir</span>
            <span>Rp <?= number_format($ongkir, 0, ',', '.') ?></span>
        </div>

        <div class="summary-item summary-total">
            <span>Total</span>
            <span>Rp <?= number_format($grand_total, 0, ',', '.') ?></span>
        </div>

        <button class="pay-now">Bayar Sekarang</button>
    </div>
</div>

<div class="popup-bg" id="qrisPopup">
  <div class="popup-box">
    <h3>Scan QRIS untuk Membayar</h3>
    <img src="qris.png" alt="QRIS">
    <p>Menunggu pembayaran...</p>
  </div>
</div>

<script>
const payBtn = document.querySelector('.pay-now');
const popup = document.getElementById('qrisPopup');

payBtn.addEventListener('click', () => {

    popup.style.display = "flex";

    setTimeout(() => {

        const form = document.getElementById('checkoutForm');
        const data = new FormData(form);

        fetch("checkout_process.php", {
            method: "POST",
            body: data
        })
        .then(res => res.text())
        .then(res => {
            console.log("Server response:", res);

            if (res.trim() === "OK") {
                alert("Transaksi berhasil!");
                window.location.href = "dashboard.php";
            } else {
                alert("Terjadi kesalahan:\n" + res);
            }
        })
        .catch(err => {
            alert("Fetch error: " + err);
        });

    }, 5000);
});
</script>

</body>
</html>
