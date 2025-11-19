<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
  header("Location: merchandise.php");
  exit;
}

$query = "SELECT * FROM merchandise WHERE merch_id = $id";
$result = mysqli_query($conn, $query);
$merch = mysqli_fetch_assoc($result);

if (!$merch) {
  echo "Produk tidak ditemukan!";
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($merch['merch_name']) ?></title>

  <!-- CSS Detail Merch -->
  <link rel="stylesheet" href="detail_merch.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
  <!-- ICON FONT AWESOME -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    /* ICON CART DI POJOK KANAN */
    .cart-icon {
        position: fixed;
        top: 20px;
        right: 20px;
        background: white;
        padding: 10px 14px;
        border-radius: 10px;
        border: 1px solid #ccc;
        z-index: 2000;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .cart-icon i {
        font-size: 20px;
        color: #3247d5;
        cursor: pointer;
    }

    .cart-icon:hover {
        background: #f1f1f1;
    }
  </style>
</head>
<body>

  <!-- 🛒 ICON CART -->
  <div class="cart-icon">
      <a href="cart.php"><i class="fa fa-shopping-cart"></i></a>
  </div>

  <div class="detail-container">
    <img src="merch_img/<?= htmlspecialchars($merch['merch_pict']) ?>" 
         alt="<?= htmlspecialchars($merch['merch_name']) ?>">

    <div class="detail-info">
      <h2><?= htmlspecialchars($merch['merch_name']) ?></h2>
      <p><?= nl2br(htmlspecialchars($merch['description'])) ?></p>
      <h3>Rp <?= number_format($merch['price'], 0, ',', '.') ?></h3>

      <?php if ($merch['status'] == 'habis'): ?>
        <button disabled class="disabled-btn">Stok Habis</button>

      <?php else: ?>
        <div class="quantity-control">
          <button type="button" id="minus">-</button>
          <span id="quantity">0</span>
          <button type="button" id="plus">+</button>
        </div>

        <form id="cartForm" method="POST">
            <input type="hidden" name="merch_id" value="<?= $merch['merch_id'] ?>">
            <input type="hidden" id="qty_input" name="quantity" value="0">

            <button type="button" id="addToCart" class="cart-btn">Add to Cart</button>
            <button type="button" id="buyNow" class="buy-btn">Buy Now</button>
        </form>
      <?php endif; ?>
    </div>
  </div>

<script>
  const plus = document.getElementById('plus');
  const minus = document.getElementById('minus');
  const qtyDisplay = document.getElementById('quantity');
  const qtyInput = document.getElementById('qty_input');
  const addToCart = document.getElementById('addToCart');
  const buyNow = document.getElementById('buyNow');

  let qty = 0;

  plus.addEventListener('click', () => {
    qty++;
    qtyDisplay.textContent = qty;
    qtyInput.value = qty;
  });

  minus.addEventListener('click', () => {
    if (qty > 0) qty--;
    qtyDisplay.textContent = qty;
    qtyInput.value = qty;
  });

  // AJAX Add to Cart tanpa reload
  addToCart.addEventListener('click', function() {
    const formData = new FormData(document.getElementById('cartForm'));

    fetch('cart_add.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.text())
    .then(data => {
      alert('Produk berhasil ditambahkan ke keranjang!');
    })
    .catch(error => {
      alert('Terjadi kesalahan saat menambahkan ke keranjang.');
      console.error(error);
    });
  });

  // BUY NOW langsung ke checkout
  buyNow.addEventListener('click', function() {
    const merchId = document.querySelector('input[name="merch_id"]').value;
    const qty = document.getElementById('qty_input').value;

    if (qty <= 0) {
      alert('Jumlah tidak boleh 0!');
      return;
    }

    window.location.href = `checkout.php?merch_id=${merchId}&qty=${qty}`;
  });
</script>

</body>
</html>
