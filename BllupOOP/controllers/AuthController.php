<?php
class AuthController extends Controller{
  public function __construct(){
    // session_start();
    if (isset($_SESSION['user']) && ($_GET['m'] ?? '') !== 'logout') { //
      header("Location:?c=dashboard&m=index");
      exit();
    }
  }

  public function login(){
    $this->loadView("auth/login", ['title' => 'Login']);
  }

public function loginProcess(){
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $userModel = $this->loadModel("User");
    $user = $userModel->getByEmail($email);

    if ($user && password_verify($password, $user->password)) {
        $_SESSION['user'] = [
            'id' => $user->id,
            'email' => $user->email
        ];
        header('Location:?c=dashboard&m=index');
        exit();
    } else {
        $this->loadView("auth/login", ['title'=>'Login','error'=>'Email atau password salah','email'=>$email],null);
        exit();
    }
}

  public function register(){
    $this->loadView("auth/register", ['title' => 'Register']);
  }


  public function registerProcess(){
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm'] ?? '';

    if ($password !== $confirmPassword) {
        $this->loadView("auth/register", ['title'=>'Register','error'=>'Password tidak cocok']);
        return;
    }

    $userModel = $this->loadModel("User");
    if ($userModel->getByEmail($email)) {
        $this->loadView("auth/register", ['title'=>'Register','error'=>'Email sudah terdaftar']);
        return;
    }

    if ($userModel->create($email, $password)) {
        header("Location:?c=auth&m=login");
        exit();
    } else {
        $this->loadView("auth/register", ['title'=>'Register','error'=>'Gagal mendaftar, coba lagi']);
    }
}


  public function forgot_password(){
    $this->loadView("auth/forgot_password", ['title' => 'Forgot Password'], "auth");
  }

  public function logout(){
    session_start();
    session_unset();
    session_destroy();
    header("Location:?c=auth&m=login");
    exit();
  }
}