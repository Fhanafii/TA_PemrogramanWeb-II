<?php
// src/generate_qr.php
// require_once __DIR__.'/db.php';
// require_once __DIR__.'/helpers.php';
// require_once __DIR__.'/../lib/phpqrcode/qrlib.php'; // phpqrcode library

// // contoh: dipanggil oleh admin dengan ?user_id=123
// $user_id = intval($_GET['user_id'] ?? 0);
// if(!$user_id) { echo "Invalid"; exit; }

// $stmt = $pdo->prepare("SELECT id, qr_token, name FROM users WHERE id = ?");
// $stmt->execute([$user_id]);
// $user = $stmt->fetch();
// if(!$user) { echo "User not found"; exit; }

// // isi QR: kita simpan token saja (atau JSON ter-encrypt)
// $payload = json_encode([
//     'uid' => $user['id'],
//     'token' => $user['qr_token']
// ]);

// $outDir = __DIR__ . '/../public/qrcodes';
// if(!is_dir($outDir)) mkdir($outDir, 0755, true);

// $filename = $outDir . "/qr_user_{$user['id']}.png";
// QRcode::png($payload, $filename, QR_ECLEVEL_Q, 6);

// echo "QR generated: <a href='/qrcodes/qr_user_{$user['id']}.png'>lihat</a>";

require_once __DIR__ . '/../lib/phpqrcode/qrlib.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/helpers.php';

// ambil user_id dari query string
$user_id = intval($_GET['user_id'] ?? 0);
if (!$user_id) {
    echo "User ID tidak valid";
    exit;
}

// ambil data user
$stmt = $pdo->prepare("SELECT id, qr_token, name FROM users WHERE id=?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
if (!$user) {
    echo "User tidak ditemukan";
    exit;
}

// data yang akan dimasukkan ke QR
$payload = json_encode([
    'uid' => $user['id'],
    'token' => $user['qr_token']
]);

// path penyimpanan QR
$outDir = __DIR__ . '/../public/qrcodes';
if (!is_dir($outDir)) {
    mkdir($outDir, 0755, true);
}

$filename = $outDir . "/qr_user_{$user['id']}.png";

// generate QR
QRcode::png($payload, $filename, QR_ECLEVEL_Q, 6);

echo "QR Code berhasil dibuat: <a href='http://localhost/SEMESTERVII/pemrograman2/coba1/public/qrcodes/qr_user_{$user['id']}.png'>Lihat QR</a>";