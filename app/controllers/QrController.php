<?php
// app/Controllers/QrController.php
require_once __DIR__ . '/../../lib/phpqrcode/qrlib.php'; // sesuaikan path
require_once __DIR__ . '/../Helpers/QrToken.php';

class QrController extends Controller
{
  // menampilkan halaman QR (img) yang auto-refresh client-side
  public function index()
  {
    requireLogin();
    AuthMiddleware::requireRole('Admin');
    $token = QrToken::generate();
    // URL yang akan di-encode dalam QR
    // $scanUrl = rtrim($base, '/') . '/scan?token=' . urlencode($token);
    // tampilkan view sederhana
    // include __DIR__ . '/../../app/Views/qr_view.php';
    $this->render('qr_view', ['title' => 'Generate QR']);
  }

  // endpoint yang mengembalikan PNG QR (alternatif)
  public function png()
  {
    requireLogin();
    AuthMiddleware::requireRole('Admin');
    $token = QrToken::generate();
    $base = getenv('BASE_URL') ?: '';
    // $scanUrl = rtrim($base, '/') . '/scan?token=' . urlencode($token);
    $scanUrl = rtrim($base, '/') . '/scan?token=' . urlencode($token);
    header('Content-Type: image/png');
    // generate png langsung ke output
    QRcode::png($scanUrl, false, QR_ECLEVEL_L, 6, 2);
    exit;
  }
}
