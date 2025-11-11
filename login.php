<?php
include 'koneksi.php';
session_start();

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $row = mysqli_fetch_assoc($result);

    if ($row && password_verify($password, $row['password'])) {
        $_SESSION['user'] = $row['email'];
        header("Location: dashboard.php");
        exit;
    } else {
        echo "<script>alert('Email atau password salah!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link rel="stylesheet" href="login.css" />
</head>
<body>
  <div class="container">
    <div class="login-card">
      <div class="image-side">
        <img src="loginpict.png" alt="Beach Cleanup" />
      </div>

      <div class="form-side">
        <h2>Login</h2>
        <p>Bersama kita jaga birunya laut Indonesia.</p>

        <!-- FORM SUDAH TERHUBUNG KE PHP -->
        <form action="" method="POST">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="Masukkan email" required />

          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Masukkan password" required />

          <div class="forgot">
            <a href="register.php">Lupa password?</a>
          </div>

          <button type="submit" name="login" class="login-btn">Login</button>
          <button type="button" class="register-btn" onclick="window.location.href='register.php'">Register</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
