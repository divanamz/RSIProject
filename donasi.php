<?php
$pageTitle = "Donasi";
include 'koneksi.php';
include 'header.php';

// ====== Hanya untuk POST insert donasi ======
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['action'])) {

    header("Content-Type: application/json; charset=UTF-8");

    $firstname = $_POST['firstname'] ?? '';
    $lastname  = $_POST['lastname'] ?? '';
    $email     = $_POST['email'] ?? '';
    $country   = $_POST['country'] ?? '';
    $phone     = $_POST['phone'] ?: null;
    $amount    = $_POST['donation_amount'] ?? '0';
    $method    = $_POST['payment_method'] ?? '';
    $anon      = isset($_POST['anonymous_donation']) ? 1 : 0;

    // Pastikan kolom anonymous_donation sudah ada di tabel
    $query = $conn->prepare("
        INSERT INTO donasi 
        (firstname, lastname, email, country, phone, donation_amount, payment_method, anonymous_donation, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')
    ");

    if (!$query) {
        echo json_encode(["status" => "fail", "error" => $conn->error]);
        exit;
    }

    $query->bind_param("sssssisi", 
        $firstname, 
        $lastname, 
        $email, 
        $country, 
        $phone, 
        $amount, 
        $method,
        $anon
    );

    if ($query->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "fail", "error" => $query->error]);
    }
    exit;
}

// ===== Hanya GET → tampil halaman HTML ======
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

  <!-- ==================== HERO SECTION ==================== -->
  <header class="hero">
    <div class="overlay"></div>
    <div class="hero-container">
      <div class="hero-text">
        <h1>Harapan Baru</h1>
        <p>
          Mari bersama-sama memberikan bantuan darurat kepada mereka yang membutuhkan.Donasi Anda saat ini juga akan menyediakan makanan, air bersih, dan tempat tinggal sementara.
        </p>
        <button id="donateBtn" class="btn-primary">Donate Now</button>
      </div>

      <div class="donation-card">
        <p class="amount">Rp. 50.000.000</p>
        <div class="progress-container">
          <div class="progress">
            <div class="progress-bar" style="width: 60%;"></div>
          </div>
        </div>
        <div class="card-bottom">
          <span>30.000.000 investor</span>
          <span>60%</span>
        </div>
      </div>
    </div>
  </header>

  <!-- ==================== INFO SECTION ==================== -->
  <section class="py-5 text-center">
    <div class="container">
      <div class="row justify-content-center align-items-center">
        <div class="col-md-6">
          <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f"
               class="img-fluid rounded" alt="Donasi" />
        </div>
        <div class="col-md-6">
          <h3 class="fw-bold">Your Donation is Really Powerful!</h3>
          <p class="text-muted">
            Every donation you make directly contributes to cleaning the ocean and preserving coral reefs.
            Let’s act now to ensure a better future for marine ecosystems!
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- ==================== COMMUNITY SECTION ==================== -->
  <section class="community text-center py-3 bg-light">
  <div class="container">
    <h4 class="fw-semibold mb-2">Be The Part of Fundraisers With Over</h4>
    <h2 class="fw-bold display-6 mb-2">52K,+&nbsp;&nbsp;52K,+&nbsp;&nbsp;52K,+</h2>
    <p class="fw-medium mb-4">People From Around The World Joined</p>

    <button id="donateBtn2" class="btn btn-p mb-4 px-4 py-2">Donate Now</button>

    <!-- Gallery grid -->
   <div class="gallery">
  <div class="row g-3 justify-content-center">
<div class="row g-3 justify-content-between mt-2">

  <!-- Foto kiri -->
  <div class="col-6 col-sm-4 col-md-3 col-lg-2">
    <img src="gallery.jpg" class="img-fluid rounded-4 shadow-sm" alt="Gallery image">
  </div>

  <!-- Foto kanan -->
  <div class="col-6 col-sm-4 col-md-3 col-lg-2">
    <img src="gallery.jpg" class="img-fluid rounded-4 shadow-sm" alt="Gallery image">
  </div>

</div>

    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
      <img src="gallery.jpg" class="img-fluid rounded-4 shadow-sm" alt="Gallery image">
    </div>
    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
      <img src="gallery.jpg" class="img-fluid rounded-4 shadow-sm" alt="Gallery image">
    </div>
    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
      <img src="gallery.jpg" class="img-fluid rounded-4 shadow-sm" alt="Gallery image">
    </div>
    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
      <img src="gallery.jpg" class="img-fluid rounded-4 shadow-sm" alt="Gallery image">
    </div>
    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
      <img src="gallery.jpg" class="img-fluid rounded-4 shadow-sm" alt="Gallery image">
    </div>
    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
      <img src="gallery.jpg" class="img-fluid rounded-4 shadow-sm" alt="Gallery image">
    </div>
</div>

</section>

  <!-- ==================== FOOTER ==================== -->
  <footer class="text-center py-4 bg-dark text-white">
    <p class="mb-1 fw-semibold">© 2025 BRIX Templates - All Rights Reserved</p>
    <div class="footer-links">
      <a href="#" class="text-white mx-2">Home</a> |
      <a href="#" class="text-white mx-2">About</a> |
      <a href="#" class="text-white mx-2">Pricing</a> |
      <a href="#" class="text-white mx-2">Blog</a> |
      <a href="#" class="text-white mx-2">Contact</a>
    </div>
  </footer>

  <!-- ==================== MODAL FORM DONASI ==================== -->
  <div class="modal fade" id="donasiModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content p-4 border-0 shadow-lg">
        <h3 class="mb-3 fw-bold">Be a Donor</h3>
        <form id="formDonasi">
          <div class="row g-3">
            <div class="col-md-6">
              <label>First name</label>
              <input type="text" class="form-control" name="firstname" placeholder="First Name" required />
            </div>
            <div class="col-md-6">
              <label>Last name</label>
              <input type="text" class="form-control" name="lastname" placeholder="Last Name" required />
            </div>
            <div class="col-md-12">
            <label>Email</label>
            <input type="email" class="form-control" name="email" placeholder="Email" required pattern="^[^\s@]+@[^\s@]+\.[^\s@]+$"title="Please enter a valid email address (must contain @ and domain)" />
            </div>
            <div class="col-md-6">
              <label>Country</label>
              <input type="text" class="form-control" name="country" placeholder="Country" required />
            </div>
            <div class="col-md-6">
            <label>Phone</label>
            <div class="input-group">
            <span class="input-group-text">+62</span>
            <input type="text" class="form-control" name="phone" id="phone" placeholder="81234567890" required pattern="[0-9]{9,15}" title="Enter numbers only (9-15 digits)"oninput="this.value=this.value.replace(/[^0-9]/g,'');"/>
            </div>
            </div>
            <div class="col-md-12">
            <label>Donation amount*</label>
            <div class="input-group">
            <span class="input-group-text">Rp.</span>
            <input type="text" class="form-control" name="donation_amount" id="donation_amount"placeholder="0"required oninput="this.value=this.value.replace(/[^0-9]/g,'');" />
            </div>
            </div>
            <div class="col-md-12">
              <label>Payment Method*</label>
              <select class="form-select" name="payment_method" required>
                <option>Qris</option>
              </select>
            </div>
            <div class="col-md-12 mt-3">
  <div class="form-check">
    <input 
      class="form-check-input" 
      type="checkbox" 
      id="anonymous_donation" 
      name="anonymous_donation"
    >
    <label class="form-check-label" for="anonymous_donation">
      I would like to donate anonymously.
    </label>
  </div>
</div>

          </div>

          <div class="mt-4 d-flex justify-content-end gap-2">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-p">Submit Donation</button>
          </div>
        </form>
        <div id="resultMsg" class="text-center mt-3 fw-semibold"></div>
      </div>
    </div>
  </div>

<div class="modal fade" id="qrisModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4 text-center border-0 shadow-lg">
      <h4 class="fw-bold mb-2">Scan QRIS</h4>
      <img src="gambar_qris.jpg" class="img-fluid rounded mb-3">
      <button class="btn btn-primary" data-bs-dismiss="modal">Selesai</button>
    </div>
  </div>
</div>


  <!-- ==================== JS ==================== -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="donasi.js"></script>

</body>
</html>
