<?php
// session_start();
// require_once __DIR__ . '/../core/Controller.php';
// require_once __DIR__ . '/../helpers/token.php';
// require_once __DIR__ . '/../helpers/auth.php';
// require_once __DIR__ . '/../helpers/generateToken.php';
// require_once __DIR__ . '/../models/User.php';
// require_once __DIR__ . '/../core/Database.php';

class AuthController extends Controller
{
  private $userModel;

  public function __construct()
  {
    $this->userModel = new User();
  }

  // Halaman login
  public function index()
  {
    noNeedLogin();
    $base = getenv('BASE_URL') ?: 'localhost';
    $this->render('login', ['title' => 'Halaman Login', 'base' => $base]);
  }

  // Proses login
  public function login()
  {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $rememberme = $_POST['remember_me'] ?? false;

    $pdo = (new Database())->getConnection();
    $user = $this->userModel->findByEmail($email);
    // var_dump($user);
    // exit;

    // if ($user && password_verify($password, $user['password'])) {
    if ($user && $user['email'] === $email && $user['password'] === $password) {

      // set cookie params (opsional, lakukan sebelum session_start() pada kode produksi)
      // $cookieParams = session_get_cookie_params();
      // session_set_cookie_params([
      //   'lifetime' => $cookieParams['lifetime'],
      //   'path'     => $cookieParams['path'],
      //   'domain'   => $cookieParams['domain'],
      //   'secure'   => true,       // pastikan memakai HTTPS
      //   'httponly' => true,
      //   'samesite' => 'Lax'
      // ]);

      // setelah verifikasi password:
      session_regenerate_id(true);
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['user_role'] = $user['positions'];
      $_SESSION['nik'] = $user['nik'];
      $_SESSION['name'] = $user['name'];
      $_SESSION['email'] = $user['email'];
      $base = getenv('BASE_URL') ?: 'localhost';

      // jika user centang "ingat saya"
      // if (!empty($_POST['remember_me'])) {
      if ($rememberme) {
        // echo "<script>console.log('masuk mondisi remember me')</script>";
        createRememberToken($pdo, $user['id'], $_SERVER['HTTP_USER_AGENT'] ?? '');
      }

      // header('Location: http://localhost/SEMESTERVII/pemrograman2/coba2basedSession/public/index.php?controller=home');
      header("Location: $base");
    } else {
      http_response_code(401);
      echo json_encode(["error" => "Email atau password salah"]);
    }
  }

  public function logout()
  {
    requireLogin();
    $pdo = (new Database())->getConnection();
    logout($pdo);
  }

  // Contoh route yang butuh login
  public function profile()
  {
    requireLogin();
    // $pdo = (new Database())->getConnection();
    // $userData = authMiddleware($pdo); // middleware cek token

    // echo json_encode([
    //   "message" => "Data profil user",
    //   "user"    => $userData
    // ]);
    echo "Halaman profil user.";
  }

  public function register()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $nik = trim($_POST['nik']);
      $name = trim($_POST['name']);
      $email = trim($_POST['email']);
      $password = trim($_POST['password']);

      // Validasi sederhana
      if (empty($nik) || empty($name) || empty($email) || empty($password)) {
        $error = "Semua field wajib diisi.";
        $this->render('register', ['title' => 'Halaman Register', 'error' => $error]);
        return;
      }

      // Cek apakah email sudah digunakan
      if ($this->userModel->findByEmail($email)) {
        $error = "Email sudah terdaftar.";
        $this->render('register', ['title' => 'Halaman Register', 'error' => $error]);
        return;
      }

      // Hash password
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

      // Generate qr_token unik
      $qr_token = bin2hex(random_bytes(8));

      // Data user baru
      $data = [
        'nik' => $nik,
        'name' => $name,
        'email' => $email,
        'password' => $hashedPassword,
        'qr_token' => $qr_token
      ];

      // Simpan user
      if ($this->userModel->create($data)) {
        $base = getenv('BASE_URL') ?: 'localhost';
        // header("Location: index.php?success=registered");
        header("Location: " . $base . "index.php?controller=auth&success=registered");
        exit;
      } else {
        $error = "Terjadi kesalahan saat menyimpan data.";
      }
    }

    if (isset($error)) {
      $this->render('register', ['title' => 'Halaman Register', 'error' => $error]);
    } else {
      $this->render('register', ['title' => 'Halaman Register']);
    }
  }
}
