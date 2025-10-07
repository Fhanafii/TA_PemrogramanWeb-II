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
    $this->render('login', ['title' => 'Halaman Login']);
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
}
