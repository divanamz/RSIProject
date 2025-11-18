<style>

body, html {
    margin: 0;
    padding: 0;
    font-family: 'Manrope', sans-serif; /* Terapkan font Manrope di sini */
}
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
  </head>

<div class="header-nav">
    <a href="dashboard.php" class="<?= $currentPage == 'dashboard.php' ? 'active' : '' ?>">Home</a>
    <a href="volunteer.php" class="<?= $currentPage == 'volunteer.php' ? 'active' : '' ?>">Volunteer</a>
    <a href="blog.php" class="<?= $currentPage == 'blog.php' ? 'active' : '' ?>">Blog</a>
    <a href="forum.php" class="<?= $currentPage == 'forum.php' ? 'active' : '' ?>">Forum Diskusi</a>
    <a href="merchandise.php" class="<?= $currentPage == 'merchandise.php' ? 'active' : '' ?>">Merch</a>
    <a href="donate.php" class="<?= $currentPage == 'donate.php' ? 'active' : '' ?>">Donate</a>
</div>


    <div class="header-right">
        <a href="profile.php" class="header-icon">
            <i class="fa-solid fa-user"></i>
        </a>
    </div>

</div>
