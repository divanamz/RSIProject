<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link rel="stylesheet" href="style/css/login.css" />
</head>
<body>
  <div class="container">
    <div class="login-card">
      <div class="image-side">
        <img src="style/assets/loginpict.png" alt="Beach Cleanup" />
      </div>

      <div class="form-side">
        <h2>Login</h2>
        <p>Bersama kita jaga birunya laut Indonesia.</p>

        <!-- FORM SUDAH TERHUBUNG KE PHP -->
        <form action="?c=auth&m=loginProcess" method="POST">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="Masukkan email" required />

          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Masukkan password" required />

          <button type="submit" name="login" class="login-btn">Login</button>
          <button type="button" class="register-btn" onclick="window.location.href='?c=auth&m=register'">Register</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>