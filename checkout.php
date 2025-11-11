<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit;
}

// Ambil data dari parameter GET
$merch_id = $_GET['merch_id'] ?? null;
$qty = $_GET['qty'] ?? 1;

// Ambil data merchandise
$query = "SELECT * FROM merchandise WHERE merch_id = $merch_id";
$result = mysqli_query($conn, $query);
$merch = mysqli_fetch_assoc($result);

if (!$merch) {
  echo "Produk tidak ditemukan!";
  exit;
}

$total_price = $merch['price'] * $qty;
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout - <?= htmlspecialchars($merch['merch_name']) ?></title>
  <link rel="stylesheet" href="checkout.css">
</head>
<body>

  <div class="checkout-container">

    <!-- ========== KIRI: FORM PENGIRIMAN ========== -->
    <form method="POST" action="checkout_proses.php">
      <h2>Informasi Pengiriman</h2>

      <label for="nama">Nama Lengkap</label>
      <input type="text" id="nama" name="nama" placeholder="Nama lengkap penerima" required>

      <label for="alamat">Alamat Lengkap</label>
      <textarea id="alamat" name="alamat" placeholder="Masukkan alamat lengkap penerima" required></textarea>

      <label for="kota">Kota / Kabupaten</label>
      <input type="text" id="kota" name="kota" placeholder="Nama kota atau kabupaten" required>

      <label for="provinsi">Provinsi</label>
      <select id="provinsi" name="provinsi" required>
        <option value="">Pilih Provinsi</option>
        <option>DKI Jakarta</option>
        <option>Jawa Barat</option>
        <option>Jawa Tengah</option>
        <option>Jawa Timur</option>
        <option>Bali</option>
        <option>Sumatera Utara</option>
      </select>

      <label for="kodepos">Kode Pos</label>
      <input type="text" id="kodepos" name="kodepos" placeholder="Masukkan kode pos" required>

      <label for="metode">Metode Pembayaran</label>
      <select id="metode" name="metode" required>
        <option value="">Pilih Metode</option>
        <option>Transfer Bank</option>
        <option>COD (Bayar di Tempat)</option>
        <option>QRIS</option>
      </select>

      <input type="hidden" name="merch_id" value="<?= $merch_id ?>">
      <input type="hidden" name="quantity" value="<?= $qty ?>">
      <input type="hidden" name="total" value="<?= $total_price ?>">

      <button type="submit" class="confirm-btn">Konfirmasi Pesanan</button>
    </form>

    <!-- ========== KANAN: RINGKASAN PESANAN ========== -->
    <div class="order-summary">
      <h3>Ringkasan Pesanan</h3>

      <div class="checkout-item">
        <img src="merch_img/<?= htmlspecialchars($merch['merch_pict']) ?>" alt="<?= htmlspecialchars($merch['merch_name']) ?>">
        <div>
          <h3><?= htmlspecialchars($merch['merch_name']) ?></h3>
          <p>Jumlah: <?= $qty ?></p>
          <p>Rp <?= number_format($merch['price'], 0, ',', '.') ?></p>
        </div>
      </div>

      <div class="summary-item">
        <span>Subtotal</span>
        <span>Rp <?= number_format($merch['price'] * $qty, 0, ',', '.') ?></span>
      </div>
      <div class="summary-item">
        <span>Ongkir</span>
        <span>Rp 15.000</span>
      </div>
      <div class="summary-item">
        <span>Pajak</span>
        <span>Rp 0</span>
      </div>

      <div class="summary-item summary-total">
        <span>Total</span>
        <span>Rp <?= number_format($total_price + 15000, 0, ',', '.') ?></span>
      </div>

      <button class="pay-now">Bayar Sekarang</button>
    </div>

  </div>

</body>
</html>
