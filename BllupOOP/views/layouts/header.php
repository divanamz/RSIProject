<style>
body, html {
    margin: 0;
    padding: 0;
    font-family: 'Manrope', sans-serif;
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

.header-nav a.active {
    font-weight: 700;
    color: #d5fbffff;
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

@media (max-width: 768px) {
    .header-nav {
        display: none;
    }
}
</style>

<?php 
$currentPage = $_GET['c'] ?? 'dashboard';
?>

<div class="header-wrapper">

    <div class="header-left">
        <a href="index.php?c=dashboard&m=index">
            <img src="style/assets/productlogo.png" width="40" height="40" alt="logo">
        </a>
        <span>Bllup</span>
    </div>

    <div class="header-nav">
        <a href="index.php?c=dashboard&m=index" class="<?= $currentPage == 'dashboard' ? 'active' : '' ?>">Home</a>
        <a href="index.php?c=volunteer&m=index" class="<?= $currentPage == 'volunteer' ? 'active' : '' ?>">Volunteer</a>
        <a href="index.php?c=donate&m=index" class="<?= $currentPage == 'donate' ? 'active' : '' ?>">Donate</a>
    </div>

    <div class="header-right">
      <a href="?c=profile&m=index" class="header-icon">
          <i class="fa-solid fa-user"></i>
      </a>

    </div>

</div>
