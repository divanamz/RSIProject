<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style/css/profile.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
        <?php include_once('views/layouts/header.php'); ?>

<div class="container-fluid profile-container">
  <div class="row">
    
    <!-- Sidebar -->
    <div class="col-lg-3 col-md-4 sidebar d-flex flex-column justify-content-between">
      <div>
        <a href="?c=dashboard&m=index" class="back-arrow mb-3 d-inline-block">
          <i class="bi bi-arrow-left"></i>
        </a>

        <ul class="nav flex-column">
          <li><a class="nav-link active" href="?c=profile&m=index"><i class="bi bi-person"></i> My Profile</a></li>
          <li><a class="nav-link" href="#"><i class="bi bi-bell"></i> Notifications</a></li>
          <li><a class="nav-link" href="#"><i class="bi bi-shield-lock"></i> Security</a></li>
          <li><a class="nav-link" href="#"><i class="bi bi-gear"></i> Settings</a></li>
        </ul>
      </div>
      <div class="logout-section">
        <a href="?c=profile&m=logout" class="logout-btn"><i class="bi bi-box-arrow-left"></i> Logout</a>
      </div>
    </div>

    <!-- Profile Content -->
    <div class="col-lg-9 col-md-8">
      <div class="profile-card">
        <!-- Header Background -->
        <div class="profile-header" style="background-image: url('uploads/<?= htmlspecialchars($profile->foto_header ?: 'default_header.jpg') ?>')"></div>

        <div class="profile-body">
          <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center">
              <img src="uploads/<?= htmlspecialchars($profile->foto_profil ?: 'default.jpg') ?>" alt="Profile Picture" class="profile-photo me-3">
              <div>
                <h5 class="fw-semibold mb-0"><?= htmlspecialchars($profile->nickname ?: 'N/A') ?></h5>
                <p class="text-muted mb-0"><?= htmlspecialchars($profile->email ?: 'Not set') ?></p>
              </div>
            </div>
            <button class="btn btn-primary edit-btn" onclick="window.location.href='?c=profile&m=update'">Edit Profile</button>
          </div>

          <!-- Information -->
          <div class="profile-info text-start">
            <div class="row g-3">
              <div class="col-md-6">
                <label>Fullname</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($profile->fullname ?: '') ?>" readonly>
              </div>
              <div class="col-md-6">
                <label>Nickname</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($profile->nickname ?: '') ?>" readonly>
              </div>

              <div class="col-md-6">
                <label>Email Address</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($profile->email ?: '') ?>" readonly>
              </div>
              <div class="col-md-6">
                <label>Gender</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars(ucfirst($profile->gender ?: '')) ?>" readonly>
              </div>

              <div class="col-12">
                <label>Date of Birth</label>
                <input type="text" class="form-control" value="<?= $profile->date_of_birth ? date('d/m/Y', strtotime($profile->date_of_birth)) : '' ?>" readonly>
              </div>
              <div class="col-md-6">
                <label>Phone</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($profile->phone_number ?: '') ?>" readonly>
              </div>

              <div class="col-md-6">
                <label>Country</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($profile->country ?: '') ?>" readonly>
              </div>
              <div class="col-12">
                <label>Address</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($profile->address ?: '') ?>" readonly>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>