<?php

class ProfileController extends Controller {


    public function __construct()
    {
        parent::__construct();

        // cek user login yang benar
        if (!isset($_SESSION['user']['id'])) {
            header("Location:?c=auth&m=login");
            exit();
        }
    }

    public function index() {
        $user_id = $_SESSION['user']['id'];
    
        try {
            $profileModel = $this->loadModel("ProfileModel");
            // pastikan email sinkron
            $profileModel->syncEmailFromUsers($user_id);
            $profile = $profileModel->getProfileByUserId($user_id);

            $this->loadView('profile/index', ['profile' => $profile]);
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function update() {

        $profileModel = $this->loadModel("ProfileModel");
        $user_id = $_SESSION['user']['id'];

        // GET: tampilkan form edit
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $profileModel->syncEmailFromUsers($user_id);
            $profile = $profileModel->getProfileByUserId($user_id);
            $this->loadView('profile/edit', ['profile' => $profile]);
            return;
        }

        // POST: proses update
        // ambil current profile untuk default file names
        $current = $profileModel->getProfileByUserId($user_id);
        $uploadDir = __DIR__ . '/../../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // helper untuk upload file (mengembalikan filename atau existing)
        $handleUpload = function($fieldName, $currentFilename) use ($uploadDir) {
            if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] !== UPLOAD_ERR_OK) {
                return $currentFilename;
            }
            $tmp = $_FILES[$fieldName]['tmp_name'];
            $orig = basename($_FILES[$fieldName]['name']);
            $ext = pathinfo($orig, PATHINFO_EXTENSION);
            $safe = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', pathinfo($orig, PATHINFO_FILENAME));
            $newName = time() . '_' . $safe . ($ext ? '.' . $ext : '');
            $dest = $uploadDir . $newName;
            if (move_uploaded_file($tmp, $dest)) {
                return $newName;
            }
            return $currentFilename;
        };

        $foto_profil = $handleUpload('foto_profil', $current->foto_profil ?? 'default.jpg');
        $foto_header = $handleUpload('foto_header', $current->foto_header ?? 'default_header.jpg');

        $data = [
            "user_id" => $user_id,
            "foto_profil" => $foto_profil,
            "foto_header" => $foto_header,
            "fullname" => htmlspecialchars(trim($_POST['fullname'] ?? '')),
            "nickname" => htmlspecialchars(trim($_POST['nickname'] ?? '')),
            "email" => filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL) ?: '',
            "gender" => htmlspecialchars(trim($_POST['gender'] ?? '')),
            "date_of_birth" => htmlspecialchars(trim($_POST['date_of_birth'] ?? '')),
            "phone_number" => htmlspecialchars(trim($_POST['phone_number'] ?? '')),
            "country" => htmlspecialchars(trim($_POST['country'] ?? '')),
            "address" => htmlspecialchars(trim($_POST['address'] ?? ''))
        ];

        $ok = $profileModel->updateProfile($data);

        $_SESSION['success_message'] = $ok ? "Profile updated successfully." : "Failed to update profile.";

        header("Location:?c=profile&m=index");
        exit;
    }

        public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
        header("Location:?c=auth&m=login");
        exit();
    }
}
