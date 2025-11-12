<?php
include 'db_connect.php';
session_start();

$user_id = $_SESSION['user_id'] ?? 1;

// Ambil data user lama
$oldData = mysqli_fetch_assoc(mysqli_query($conn, "SELECT foto_profil, foto_header FROM user_profiles WHERE user_id='$user_id'"));

$fullname = $_POST['fullname'];
$nickname = $_POST['nickname'];
$email = $_POST['email'];
$gender = $_POST['gender'];
$date_of_birth = $_POST['date_of_birth'];
$country = $_POST['country'];
$phone = $_POST['phone_number'];
$address = $_POST['address'];

$update_foto = "";
$update_header = "";

// --- Upload Foto Profil ---
if (!empty($_FILES['foto_profil']['name'])) {
    $fileName = time() . '_' . basename($_FILES['foto_profil']['name']);
    $targetPath = __DIR__ . "/uploads/" . $fileName;
    if (move_uploaded_file($_FILES['foto_profil']['tmp_name'], $targetPath)) {
        $update_foto = ", foto_profil='$fileName'";
        // Hapus foto lama (kecuali default)
        if (!empty($oldData['foto_profil']) && $oldData['foto_profil'] != 'default.jpg') {
            @unlink(__DIR__ . "/uploads/" . $oldData['foto_profil']);
        }
    }
}

// --- Upload Header ---
if (!empty($_FILES['foto_header']['name'])) {
    $headerName = time() . '_' . basename($_FILES['foto_header']['name']);
    $targetPath = __DIR__ . "/uploads/" . $headerName;
    if (move_uploaded_file($_FILES['foto_header']['tmp_name'], $targetPath)) {
        $update_header = ", foto_header='$headerName'";
        // Hapus header lama (kecuali default)
        if (!empty($oldData['foto_header']) && $oldData['foto_header'] != 'default_header.jpg') {
            @unlink(__DIR__ . "/uploads/" . $oldData['foto_header']);
        }
    }
}

$sql = "UPDATE user_profiles SET 
    fullname='$fullname',
    nickname='$nickname',
    email='$email',
    gender='$gender',
    date_of_birth='$date_of_birth',
    country='$country',
    phone_number='$phone',
    address='$address'
    $update_foto
    $update_header
    WHERE user_id='$user_id'";

if (mysqli_query($conn, $sql)) {
    header("Location: profile.php?updated=1");
    exit;
} else {
    echo "Error updating record: " . mysqli_error($conn);
}
?>
