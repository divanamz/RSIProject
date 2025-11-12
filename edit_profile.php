<?php
include 'db_connect.php';
session_start();

$user_id = $_SESSION['user_id'] ?? 1;

$query = "SELECT * FROM user_profiles WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Profile</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="css/profile.css">
</head>
<body>
<div class="container-fluid profile-container">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-lg-3 col-md-4 sidebar d-flex flex-column justify-content-between">
      <div>
        <a href="profile.php" class="back-arrow mb-3 d-inline-block">
          <i class="bi bi-arrow-left"></i>
        </a>
        <ul class="nav flex-column">
          <li><a class="nav-link active" href="#"><i class="bi bi-person"></i> My Profile</a></li>
          <li><a class="nav-link" href="#"><i class="bi bi-bell"></i> Notifications</a></li>
          <li><a class="nav-link" href="#"><i class="bi bi-shield-lock"></i> Security</a></li>
          <li><a class="nav-link" href="#"><i class="bi bi-gear"></i> Settings</a></li>
        </ul>
      </div>
      <div class="logout-section">
        <a href="logout.php" class="logout-btn"><i class="bi bi-box-arrow-left"></i> Logout</a>
      </div>
    </div>

    <!-- Edit Profile Card -->
    <div class="col-lg-9 col-md-8">
      <div class="profile-card">
        <form action="update_profile.php" method="POST" enctype="multipart/form-data">
          <div class="profile-header" 
               style="background-image: url('uploads/<?php echo $user['foto_header'] ?: "default_header.jpg"; ?>');">
            <label for="foto_header" class="edit-header-icon">
              <i class="bi bi-camera"></i>
            </label>
            <input type="file" id="foto_header" name="foto_header" accept="image/*" hidden>
          </div>

          <div class="profile-body text-center">
            <div class="profile-photo-container">
              <img src="uploads/<?php echo $user['foto_profil'] ?: "default.jpg"; ?>" 
                   alt="Profile Picture" class="profile-photo">
              <label for="foto_profil" class="edit-photo-icon">
                <i class="bi bi-camera-fill"></i>
              </label>
              <input type="file" id="foto_profil" name="foto_profil" accept="image/*" hidden>
            </div>

            <h5 class="mt-3 mb-0 fw-semibold"><?php echo $user['nickname']; ?></h5>
            <p class="text-muted mb-4"><?php echo $user['email']; ?></p>

            <div class="profile-info text-start">
              <div class="row">
                <div class="col-md-6">
                  <label>Fullname</label>
                  <input type="text" class="form-control" name="fullname" value="<?php echo $user['fullname']; ?>">
                </div>
                <div class="col-md-6">
                  <label>Nickname</label>
                  <input type="text" class="form-control" name="nickname" value="<?php echo $user['nickname']; ?>">
                </div>

                <div class="col-md-6">
                  <label>Email Address</label>
                  <input type="email" class="form-control" name="email" value="<?php echo $user['email']; ?>">
                </div>
                <div class="col-md-6">
                  <label>Gender</label>
                  <select name="gender" class="form-select">
                    <option value="male" <?php if($user['gender']=='male') echo 'selected'; ?>>Male</option>
                    <option value="female" <?php if($user['gender']=='female') echo 'selected'; ?>>Female</option>
                    <option value="other" <?php if($user['gender']=='other') echo 'selected'; ?>>Other</option>
                  </select>
                </div>

                <div class="col-12">
                  <label>Date of Birth</label>
                  <input type="date" class="form-control" name="date_of_birth" 
                         value="<?php echo $user['date_of_birth']; ?>">
                </div>
                <div class="col-md-6">
                  <label>Phone</label>
                  <input type="text" class="form-control" name="phone_number" value="<?php echo $user['phone_number']; ?>">
                </div>

                <div class="col-md-6">
                  <label>Country</label>
                  <input type="text" class="form-control" name="country" value="<?php echo $user['country']; ?>">
                </div>
                <div class="col-12">
                  <label>Address</label>
                  <input type="text" class="form-control" name="address" value="<?php echo $user['address']; ?>">
                </div>
              </div>

              <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="profile.php" class="btn btn-outline-primary px-4">Cancel</a>
                <button type="submit" class="btn btn-primary px-4">Save</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  // Preview Foto Profil
  const fotoProfilInput = document.getElementById('foto_profil');
  const fotoProfilImg = document.querySelector('.profile-photo');
  fotoProfilInput.addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        fotoProfilImg.src = e.target.result;
      }
      reader.readAsDataURL(file);
    }
  });

  // Preview Header
  const headerInput = document.getElementById('foto_header');
  const headerDiv = document.querySelector('.profile-header');
  headerInput.addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        headerDiv.style.backgroundImage = `url(${e.target.result})`;
      }
      reader.readAsDataURL(file);
    }
  });
</script>

</body>
</html>
