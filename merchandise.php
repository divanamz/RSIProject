<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: yyylogin.php"); 
    exit;
}

include "koneksi.php";
include "header.php";

$search = "";
if (isset($_GET['search'])) {
  $search = mysqli_real_escape_string($conn, $_GET['search']);
  $query = "SELECT * FROM merchandise WHERE merch_name LIKE '%$search%'";
} else {
  $query = "SELECT * FROM merchandise";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Merchandise</title>
  <link rel="stylesheet" href="merchandise.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    .sold-out {
      opacity: 0.5;
      pointer-events: none;
      cursor: not-allowed;
    }
  </style>
</head>
<body>

<div class="top-bar">
    <div class="search-wrapper">
        <form action="" method="GET">
            <input type="text" name="search" placeholder="Search merchandise..." 
                   value="<?= htmlspecialchars($search) ?>">
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>
    </div>

    <a href="cart.php" class="cart-icon">
        <i class="fa fa-shopping-cart"></i>
    </a>
</div>


  <main class="product-section">
    <?php if (mysqli_num_rows($result) > 0): ?>
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <?php 
          $status = strtolower($row['status']);
          $isAvailable = ($status === 'available' || $status === 'tersedia');
        ?>

        <?php if ($isAvailable): ?>

          <a href="detail_merch.php?id=<?= $row['merch_id'] ?>" class="product-card">
            <img src="merch_img/<?= htmlspecialchars($row['merch_pict']) ?>" alt="<?= htmlspecialchars($row['merch_name']) ?>">
            <div class="product-info">
              <p class="product-name"><?= htmlspecialchars($row['merch_name']) ?></p>
              <p class="product-price">Rp <?= number_format($row['price'], 0, ',', '.') ?></p>
            </div>
          </a>
        <?php else: ?>

          <div class="product-card sold-out">
            <img src="merch_img/<?= htmlspecialchars($row['merch_pict']) ?>" alt="<?= htmlspecialchars($row['merch_name']) ?>">
            <div class="product-info">
              <p class="product-name"><?= htmlspecialchars($row['merch_name']) ?></p>
              <p class="product-price">Rp <?= number_format($row['price'], 0, ',', '.') ?></p>
            </div>
          </div>
        <?php endif; ?>

      <?php endwhile; ?>
    <?php else: ?>
      <p style="text-align:center; margin-top: 30px;">Tidak ada merchandise ditemukan.</p>
    <?php endif; ?>
  </main>
</body>
</html>
