<style>

body, html {
    margin: 0;
    padding: 0;
    font-family: 'Manrope', sans-serif; /* Terapkan font Manrope di sini */

.header-wrapper {
    width: 100%;
    height: 75px;
    background-color: #2fa7b8;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 40px;
    box-sizing: border-box;
    position: sticky;
    top: 0;
    z-index: 999;
}

/* Logo */
.header-left {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 26px;
    font-weight: 600;
    color: white;
    white-space: nowrap;
}

.header-nav {
    display: flex;
    gap: 32px;
}

.header-nav a {
    color: white;
    text-decoration: none;
    font-size: 17px;
    font-weight: 500;
    transition: 0.2s;
}

.header-nav a:hover {
    opacity: 0.8;
}

.header-right {
    display: flex;
    align-items: center;
    gap: 25px;
}

.header-icon {
    font-size: 22px;
    color: white;
    cursor: pointer;
    text-decoration: none;
}

.header-icon:hover {
    opacity: 0.8;
}

.header-nav a.active {
    font-weight: 700;
    color: #d5fbffff; /* sedikit lebih terang */
}

body,
html {
  margin: 0;
  padding: 0;
  font-family: 'Manrope', sans-serif;
  background-color: #f4f4f4;
}

.top-bar {
  width: 100%;
  display: flex;
  justify-content: center;
  padding-top: 10px;
  padding-bottom: 10px;
}

.search-wrapper-container {
  width: 100%;
  max-width: 1000px;
  align-items: center;
  background: #ffffff;
  box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
}

.search-wrapper {
  flex: 1;
  padding: 0 0 0 20px;
  border-radius: 8px 0 0 8px; 
}

.search-wrapper form {
  display: flex;
  width: 100%;
  background: #ffffff;
  align-items: center;
}

.search-wrapper input {
  flex: 1;
  border: none;
  outline: none;
  font-size: 16px;
  padding: 0 20px;
  height: 50px;
}

.search-wrapper button {
  background: none;
  border: none;
  font-size: 18px;
  cursor: default;
  color: #888;
  padding: 0 10px;
}

.cart-icon {
  border: none;
  background: none;
  display: flex;
  align-items: center;
  justify-content: center;
  text-decoration: none;

  width: 50px;
  height: 50px;
  background-color: #ffffff;
  border-radius: 0 8px 8px 0;
  color: #3247d5;
  font-size: 22px;
  transition: background-color 0.2s;
  flex-shrink: 0;
  margin-right: 20px;
}

.cart-icon:hover {
  background-color: #eee;
}

.product-section {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 24px;
  padding: 40px 80px;
  box-sizing: border-box;
}

.product-card {
  background-color: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  text-align: center;
  padding-bottom: 10px;
  overflow: hidden;
  transition: 0.2s ease;
}

.product-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.18);
}

.product-card img {
  width: 100%;
  height: 180px;
  object-fit: contain;
  margin-top: 10px;
}

.product-info {
  margin-top: 10px;
  padding: 5px 10px;
  text-align: left;
}

.product-name {
  font-weight: 600;
  margin: 5px 0;
  color: #333;
}

.product-price {
  font-weight: 700;
  color: #3247d5; /* Warna teal */
  margin: 5px 0 0;
}

@media (max-width: 900px) {
  .product-section {
    grid-template-columns: repeat(2, 1fr);
    padding: 25px 30px;
  }
  .search-wrapper-container {
    margin: 0 20px;
  }
}

@media (max-width: 600px) {
  .product-section {
    grid-template-columns: 1fr;
    padding: 20px;
  }
}

.sold-out {
  opacity: 0.6;
  pointer-events: none;
  cursor: not-allowed;
}
.sold-out .product-price {
  text-decoration: line-through;
  color: #999;
}

.product-card {
  min-height: 320px;
}

.product-card img {
  width: 100%;
  height: 180px;
  object-fit: contain;
  padding: 10px;
  background: #fff;
}

.product-section {
  align-items: start;
}

.search-wrapper-container {
  border-radius: 8px 0 0 8px;
}

a {
    text-decoration: none;
}

.footer {
  padding: 50px 80px;
  background: white;
  font-family: 'Manrope', sans-serif;
  color: #222;
}

.footer-container {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 40px;
}

.footer-section {
  max-width: 260px;
}

.footer-logo {
  font-size: 28px;
  font-weight: 700;
  margin-bottom: 10px;
}

.footer-section h3 {
  font-size: 16px;
  margin-bottom: 15px;
  font-weight: 700;
}

.footer-section ul {
  padding: 0;
  list-style: none;
}

.footer-section ul li {
  margin-bottom: 10px;
}

.footer-section a {
  text-decoration: none;
  color: #555;
  font-size: 14px;
}

.footer-section a:hover {
  color: #111;
}

.social-icons a {
  font-size: 22px;
  margin-right: 15px;
  color: #111;
}

.social-icons a:hover {
  opacity: 0.7;
}


@media (max-width: 1024px) {
    .header-nav {
        gap: 20px;
    }

    .header-nav a {
        font-size: 16px;
    }
}

@media (max-width: 768px) {

    .header-wrapper {
        padding: 0 20px;
    }

    .header-nav {
        display: none; 
    }
}
</style>
<div class="header-wrapper">

    <div class="header-left">
        <img src="productlogo.png" width="40" height="40" alt="logo">
        <span>Bllup</span>
    </div>

  <?php
$currentPage = basename($_SERVER['PHP_SELF']); // ambil nama file skrng
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Merchandise</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="merchandise.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  </head>

<div class="header-nav">
    <a href="dashboard.php" class="<?= $currentPage == 'dashboard.php' ? 'active' : '' ?>">Home</a>
    <a href="volunteer.php" class="<?= $currentPage == 'volunteer.php' ? 'active' : '' ?>">Volunteer</a>
    <a href="blog.php" class="<?= $currentPage == 'blog.php' ? 'active' : '' ?>">Blog</a>
    <a href="forum.php" class="<?= $currentPage == 'forum.php' ? 'active' : '' ?>">Forum Diskusi</a>
    <a href="merchandise.php" class="<?= $currentPage == 'merchandise.php' ? 'active' : '' ?>">Merch</a>
    <a href="donasi.php" class="<?= $currentPage == 'donasi.php' ? 'active' : '' ?>">Donasi</a>
</div>


    <div class="header-right">
        <a href="profile.php" class="header-icon">
            <i class="fa-solid fa-user"></i>
        </a>
    </div>

</div>
