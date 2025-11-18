<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

$user_id = $_SESSION['user_id'];
$query = mysqli_query($conn, "SELECT c.cart_id, m.merch_name, m.merch_pict, m.price, c.quantity, c.subtotal
                              FROM cart c
                              JOIN merchandise m ON c.merch_id = m.merch_id
                              WHERE c.user_id='$user_id'");
$total = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Keranjang</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
  
<link rel="stylesheet" href="cart.css">
</head>

<body>

<div class="cart-container">
  <h2 class="cart-title">Your Cart</h2>
  <div class="cart-box">

    <?php while ($row = mysqli_fetch_assoc($query)) { 
      $total += $row['subtotal'];
    ?>
    
    <div class="cart-item">

      <img src="<?= $row['merch_pict']; ?>" alt="">

      <div class="item-info">
        <h3><?= $row['merch_name']; ?></h3>
        <p>Harga satuan: Rp <?= number_format($row['price'], 0, ',', '.'); ?></p>
        <div class="item-price">Subtotal: Rp <?= number_format($row['subtotal'], 0, ',', '.'); ?></div>
      </div>

      <!-- Qty Controls -->
      <div class="qty-controls">
        <form action="update_cart.php" method="POST" style="display:inline;">
            <input type="hidden" name="cart_id" value="<?= $row['cart_id']; ?>">
            <input type="hidden" name="action" value="minus">
            <button type="submit">-</button>
        </form>

        <span class="qty-number"><?= $row['quantity']; ?></span>

        <form action="update_cart.php" method="POST" style="display:inline;">
            <input type="hidden" name="cart_id" value="<?= $row['cart_id']; ?>">
            <input type="hidden" name="action" value="plus">
            <button type="submit">+</button>
        </form>
      </div>

      <!-- Delete -->
      <form action="update_cart.php" method="POST">
          <input type="hidden" name="cart_id" value="<?= $row['cart_id']; ?>">
          <input type="hidden" name="action" value="delete">
          <button class="delete-btn">🗑️</button>
      </form>

    </div>

    <?php } ?>

  </div>

  <h3 style="text-align:center; margin-top:20px;">
    Total: <b>Rp <?= number_format($total, 0, ',', '.'); ?></b>
  </h3>

  <button class="checkout-btn" onclick="window.location='checkout.php'">
    Checkout Now
  </button>

</div>

</body>
</html>
