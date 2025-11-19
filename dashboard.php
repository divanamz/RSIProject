<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include "header.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h2>Selamat datang, <?php echo $_SESSION['user_id']['email']; ?>!</h2>
    <p>Anda berhasil login ke sistem RSIDB.</p>

    <h3>Menu Navigasi</h3>
    <ul>
        <li><a href="merchandise.php">Kelola Merchandise</a></li>
    </ul>

    <a href="logout.php">Logout</a>
</body>
</html>
