
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register</title>
  <link rel="stylesheet" href="style/css/register.css" />
</head>
<body>
  <div class="container">
    <div class="register-card">
      <div class="image-side">
        <img src="style/assets/regpict.png" alt="Beach Cleanup" />
      </div>

      <div class="form-side">
        <h2>Register</h2>
        <?= $error ?? NULL ?>
        <p>Bergabunglah dan bantu jaga kebersihan laut Indonesia.</p>

        <!-- FORM SUDAH TERHUBUNG -->
        <form action="?c=auth&m=registerProcess" method="POST">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="Masukkan email" required />

          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Masukkan password" required />

          <label for="confirm">Konfirmasi Password</label>
          <input type="password" id="confirm" name="confirm" placeholder="Ulangi password" required />

                <?php if (!empty($error_message)) : ?>
                    <div class="error-message">
                    <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>

          <button type="submit" name="register" class="register-btn">Register</button>
          <p class="login-link">
            Sudah punya akun? <a href="?c=auth&m=login">Login di sini</a>
          </p>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
