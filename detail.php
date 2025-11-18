<?php
// debug sementara — hapus atau comment di production
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';  // sesuaikan path koneksi

// Ambil activity_id dari GET (dipakai untuk menampilkan detail)
$activity_id = null;
if (isset($_GET['id'])) {
    $activity_id = intval($_GET['id']);
}

// Jika tidak ada id di GET, stop lebih awal
if ($activity_id === null) {
    die("Error: ID tidak ditemukan.");
}

// Ambil data program dulu (so we have $program for title even if form submit)
$sql = "SELECT * FROM program WHERE activity_id = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}
$stmt->bind_param("i", $activity_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Program tidak ditemukan.");
}
$program = $result->fetch_assoc();


// HANDLE FORM SUBMIT (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ambil activity_id dari POST (hidden input) — fallback ke $activity_id dari GET
    $activity_id_post = isset($_POST['activity_id']) ? intval($_POST['activity_id']) : $activity_id;

    // Ambil dan sanitize input sesuai dengan name pada form
    $fullname   = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
    $email      = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone      = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $address    = isset($_POST['address']) ? trim($_POST['address']) : '';
    $motivation = isset($_POST['motivation']) ? trim($_POST['motivation']) : '';

    // Validasi minimal
    if ($activity_id_post === 0 || $fullname === '' || $email === '') {
        echo "<script>alert('Data tidak lengkap. Pastikan semua field wajib terisi.');</script>";
    } else {

        // Handle file upload (opsional)
        $fileName = null;
        if (!empty($_FILES['file_support']['name']) && $_FILES['file_support']['error'] === UPLOAD_ERR_OK) {
            $origName = $_FILES['file_support']['name'];
            $tmpName  = $_FILES['file_support']['tmp_name'];
            $ext = pathinfo($origName, PATHINFO_EXTENSION);
            $fileName = time() . "_" . rand(1000,9999) . "." . $ext;
            $uploadsDir = __DIR__ . "/uploads/";
            if (!is_dir($uploadsDir)) {
                mkdir($uploadsDir, 0755, true);
            }
            $dest = $uploadsDir . $fileName;
            if (!move_uploaded_file($tmpName, $dest)) {
                $fileName = null; // jika gagal upload, lanjutkan tanpa file
            }
        }

        // Prepared INSERT — pastikan kolom ini ada di tabel volunteer:
        $sqlInsert = "INSERT INTO volunteer 
            (user_profile_id, activity_id, fullname, email, phone, address, motivation, file_support)
            VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)";

        $stmtIns = $conn->prepare($sqlInsert);
        if ($stmtIns === false) {
            echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
        } else {
            $stmtIns->bind_param(
                "issssss",
                $activity_id_post,
                $fullname,
                $email,
                $phone,
                $address,
                $motivation,
                $fileName
            );

            if ($stmtIns->execute()) {
                echo "<script>
                        alert('Pendaftaran berhasil!');
                        window.location.href = 'volunteer.php';
                      </script>";
                exit;
            } else {
                echo "Execute failed: (" . $stmtIns->errno . ") " . $stmtIns->error;
            }
        }
    }
} // akhir POST handler

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= htmlspecialchars($program['program_name']); ?></title>
  <link rel="stylesheet" href="vol.css">
</head>
<body class="detail-body">

<div class="detail-container">
    <img src="vol.png" class="detail-image" alt="program image">
    <div class="detail-content">
        <h1 class="detail-title"><?= htmlspecialchars($program['program_name']); ?></h1>
        <div class="detail-meta">
            <span>📅 <?= htmlspecialchars($program['date']); ?></span>
            <span>⏰ <?= htmlspecialchars($program['time']); ?></span>
            <span>📍 <?= htmlspecialchars($program['location']); ?></span>
        </div>
        <p class="detail-description"><?= nl2br(htmlspecialchars($program['description'])); ?></p>
        <button class="detail-btn" id="openPopup">Daftar Sekarang</button>
    </div>
</div>

<!-- POPUP FORM -->
<div class="popup-overlay" id="popupForm">
  <div class="popup-box">
    <span class="popup-close" id="closePopup">&times;</span>

    <h2 style="margin-bottom:10px;">Daftar Volunteer – <?= htmlspecialchars($program['program_name']); ?></h2>

    <form action="" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="activity_id" value="<?= htmlspecialchars($program['activity_id']); ?>">

      <label>Nama Lengkap</label>
      <input type="text" name="fullname" required>

      <label>Email</label>
      <input type="email" name="email" required>

      <label>No Telepon</label>
      <input type="text" name="phone" required>

      <label>Alamat</label>
      <textarea name="address" rows="3" required></textarea>

      <label>Motivasi Mengikuti Event</label>
      <textarea name="motivation" rows="4" required></textarea>

      <label>Upload Berkas (Opsional)</label>
      <input type="file" name="file_support">

      <br><br>
      <button type="submit" class="detail-btn" style="width:100%;">Kirim Pendaftaran</button>
    </form>
  </div>
</div>

<script>
const popup = document.getElementById("popupForm");
const openBtn = document.getElementById("openPopup");
const closeBtn = document.getElementById("closePopup");
openBtn.onclick = () => popup.style.display = "flex";
closeBtn.onclick = () => popup.style.display = "none";
window.onclick = (e) => { if (e.target === popup) popup.style.display = "none"; }
</script>

</body>
</html>
