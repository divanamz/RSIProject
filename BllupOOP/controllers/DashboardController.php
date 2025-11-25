<?php
class DashboardController extends Controller
{

  public function __construct()
  {
    // session_start();
    if (!isset($_SESSION['user'])) {
      header("Location:?c=auth&m=login");
      exit();
    }

  }

  public function index()
  {
    $this->loadView("dashboard/index", [
      'title' => 'Dashboard',
      'user' => $_SESSION['user']
    ]);
  }

  public function profile()
  {
    $this->loadView('profile/index');
  }

  public function editSelf()
  {
    // Data user diambil langsung dari session, tidak perlu ke database lagi
    $this->loadView("dashboard/edit_akun", [
      'user' => $_SESSION['user']
    ]);
  }

  /**
   * Memproses update PROFIL DIRI SENDIRI.
   */
  public function updateSelf()
  {
    // Pastikan user masih login
    if (!isset($_SESSION['user'])) {
      header("Location:?c=auth&m=login");
      exit();
    }

    $userId = $_SESSION['user']['user_id'];
    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $photoFilename = $_SESSION['user']['photo'] ?? null; // Default ke foto lama

    // --- Logika Upload Foto ---
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
      $uploadDir = _DIR_ . '/../uploads/';
      if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
      }

      // Hapus foto lama untuk menghindari penumpukan file
      foreach (glob($uploadDir . "user_{$userId}_*") as $oldFile) {
        unlink($oldFile);
      }

      // Buat nama file baru yang unik
      $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
      $photoFilename = "user_{$userId}_" . time() . "." . $ext;
      $destination = $uploadDir . $photoFilename;

      if (!move_uploaded_file($_FILES['photo']['tmp_name'], $destination)) {
        // Handle error jika upload gagal
        $this->loadView("dashboard/profile", ['error' => 'Gagal menyimpan foto.']);
        return;
      }
    }

    $userModel = $this->loadModel("User");
    $updateSuccess = $userModel->updateAccount($userId, $fullname, $email, $photoFilename);

    if ($updateSuccess) {

      $_SESSION['user']['fullname'] = $fullname;
      $_SESSION['user']['email'] = $email;
      $_SESSION['user']['photo'] = $photoFilename;

      header("Location:?c=dashboard&m=profile");
      exit();
    } else {
      $this->loadView("dashboard/profile", ['error' => 'Gagal memperbarui data di database.']);
    }
  }

  public function promo()
  {
    $this->loadView('promo/index');
  }

  public function order()
  {
    $this->loadView('order/index');
  }

  public function vehicle()
  {
    $this->loadView('vehicle/rent');
  }

  public function accommodation()
  {
    $this->loadView('accommodation/index');
  }

}