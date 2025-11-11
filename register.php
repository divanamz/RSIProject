<?php 
include 'koneksi.php';

if (isset($_POST['register'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    // Cek konfirmasi password
    if ($password !== $confirm) {
        echo "<script>alert('Konfirmasi password tidak cocok!');</script>";
    } else {
        // Enkripsi password
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        // Cek apakah email sudah terdaftar
        $cek = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        if (mysqli_num_rows($cek) > 0) {
            echo "<script>alert('Email sudah terdaftar!');</script>";
        } else {
            // Insert ke database
            $query = "INSERT INTO users (email, password) VALUES ('$email', '$hashed')";
            $result = mysqli_query($conn, $query);

            if ($result) {
                echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location='login.php';</script>";
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register</title>
  <link rel="stylesheet" href="register.css" />
</head>
<body>
  <div class="container">
    <div class="register-card">
      <div class="image-side">
        <img src="regpict.png" alt="Beach Cleanup" />
      </div>

      <div class="form-side">
        <h2>Register</h2>
        <p>Bergabunglah dan bantu jaga kebersihan laut Indonesia.</p>

        <!-- FORM SUDAH TERHUBUNG -->
        <form action="" method="POST">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="Masukkan email" required />

          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Masukkan password" required />

          <label for="confirm">Konfirmasi Password</label>
          <input type="password" id="confirm" name="confirm" placeholder="Ulangi password" required />

          <button type="submit" name="register" class="register-btn">Register</button>
          <p class="login-link">
            Sudah punya akun? <a href="login.php">Login di sini</a>
          </p>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
