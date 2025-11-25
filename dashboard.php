<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}
include "header.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard </title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>

    <!-- HERO SECTION -->
    <section class="hero">
        <div class="overlay"></div>
        <div class="hero-content">
            <h1>Your Best Word</h1>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                Proin maximus justo neque, ac scelerisque urna lobortis et.
            </p>
            <button class="btn">Button Text</button>

            <div class="stats">
                <div class="stat-box">
                    <h2>100+</h2>
                    <p>Volunteers</p>
                </div>
                <div class="stat-box">
                    <h2>100+</h2>
                    <p>Activities</p>
                </div>
                <div class="stat-box">
                    <h2>100+</h2>
                    <p>Donations</p>
                </div>
            </div>
        </div>
    </section>

    <!-- HELP SECTION -->
    <section class="help-section">
        <h2>They Need Your Help!</h2>

        <div class="help-cards">
            <div class="card"></div>
            <div class="card"></div>
            <div class="card"></div>
            <div class="card"></div>
        </div>
    </section>

</body>
</html>
