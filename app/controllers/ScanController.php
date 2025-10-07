<?php
// app/Controllers/ScanController.php
require_once __DIR__ . '/../../app/Helpers/QrToken.php';
// require_once __DIR__ . '/../Models/UserModel.php';
// require_once __DIR__ . '/../Models/AttendanceModel.php';

class ScanController extends Controller
{

  // Show scan page (GET)
  public function index()
  {
    requireLogin();
    // $token = $_GET['token'] ?? '';
    // include __DIR__ . '/../../app/Views/scan_view.php';

    $this->render('scan_view', ['title' => 'Scan QR dengan Kamera']);
  }

  // Handle form submit (POST) -> perform checkin/checkout
  public function submit()
  {
    requireLogin();
    $baseurl = getenv('BASE_URL') ?: '';
    $token = $_POST['token'] ?? '';
    $nik = trim($_SESSION['nik'] ?? '');
    $type = $_POST['type'] ?? 'in'; // 'in' atau 'out'
    // $photoPath = null; // kalau ada upload, proses disini
    // $lat = !empty($_POST['lat']) ? $_POST['lat'] : null;
    // $lon = !empty($_POST['lon']) ? $_POST['lon'] : null;
    $ip = $_SERVER['REMOTE_ADDR'] ?? null;

    if (empty($token)) {
      // $_SESSION['flash'] = "Token atau NIK tidak boleh kosong.";
      // header("Location:" . $baseurl . "/scan?token=" . urlencode($token));
      // http_response_code(400); // lebih tepat daripada 200
      // header('Content-Type: application/json');
      // echo json_encode([
      //   "status" => "error",
      //   "message" => "Token atau NIK tidak boleh kosong bro."
      // ]);

      // Jika kosong, coba baca JSON payload (application/json)
      $raw = file_get_contents('php://input');
      if (!empty($raw)) {
        $json = json_decode($raw, true);
        if (json_last_error() === JSON_ERROR_NONE && isset($json['token'])) {
          $token = $json['token'];
          $type = $json['type'] ?? 'in';
          // http_response_code(200); // lebih tepat daripada 200
          // header('Content-Type: application/json');
          // echo json_encode([
          //   "status" => "Success",
          //   "message" => $token
          // ]);
        }
        // jika client mengirim nested e.g. { data: { token: '...' } }
        // $token = $json['token'] ?? $json['data']['token'] ?? $token;
      }
      // exit;
    }

    // verifikasi token
    if (!QrToken::verify($token)) {
      $_SESSION['flash'] = "Token QR tidak valid atau kadaluarsa.";
      // header("Location:" . $baseurl . "/scan?token=" . urlencode($token));
      http_response_code(200); // lebih tepat daripada 200
      header('Content-Type: application/json');
      echo json_encode([
        "status" => "Masuk Kondisi 1",
        "message" => $token
      ]);
      exit;
    }

    $userModel = new UserModel();
    $user = $userModel->findByNik($nik);
    if (!$user) {
      $_SESSION['flash'] = "User dengan NIK $nik tidak ditemukan.";
      // header("Location: /scan?token=" . urlencode($token));

      http_response_code(200); // lebih tepat daripada 200
      header('Content-Type: application/json');
      echo json_encode([
        "status" => "Masuk Kondisi 2",
        "message" => $token
      ]);
      exit;
    }
    $attendanceModel = new AttendanceModel();

    // logic check: jika type=out tapi belum ada in hari ini -> tolak
    $todayIn = $attendanceModel->existsTodayType($user['id'], 'in');
    $todayOut = $attendanceModel->existsTodayType($user['id'], 'out');

    if ($type === 'out' && !$todayIn) {
      $_SESSION['flash'] = "Anda belum melakukan check-in hari ini. Tidak bisa check-out.";
      // header("Location: /scan?token=" . urlencode($token));

      http_response_code(200); // lebih tepat daripada 200
      header('Content-Type: application/json');
      echo json_encode([
        "status" => "Masuk Kondisi 3",
        "message" => $token
      ]);

      exit;
    }

    if ($type === 'in' && $todayIn) {
      $_SESSION['flash'] = "Anda sudah check-in hari ini.";
      // header("Location: /scan?token=" . urlencode($token));

      http_response_code(200); // lebih tepat daripada 200
      header('Content-Type: application/json');
      echo json_encode([
        "status" => "Masuk Kondisi 4",
        "message" => $token
      ]);

      exit;
    }

    if ($type === 'out' && $todayOut) {
      $_SESSION['flash'] = "Anda sudah check-out hari ini.";
      // header("Location: /scan?token=" . urlencode($token));

      http_response_code(200); // lebih tepat daripada 200
      header('Content-Type: application/json');
      echo json_encode([
        "status" => "Masuk Kondisi 5",
        "message" => $token
      ]);

      exit;
    }

    // Insert attendance
    // $attendanceModel->create($user['id'], $type, $token, $photoPath, $lat, $lon, $ip);
    $attendanceModel->create($user['id'], $type, $token, $ip);

    $_SESSION['flash'] = "Berhasil $type.";

    http_response_code(200); // lebih tepat daripada 200
    header('Content-Type: application/json');
    echo json_encode([
      "status" => "Masuk Kondisi 6",
      "message" => $token
    ]);

    // header("Location:" . $baseurl . "index.php/scan?token=" . urlencode($token));
    exit;
  }
}
