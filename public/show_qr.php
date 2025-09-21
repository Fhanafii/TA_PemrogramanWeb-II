<?php
// public/show_qr.php
require_once __DIR__ . '/../src/db.php';

$user_id = intval($_GET['id'] ?? 0);
if (!$user_id) {
    echo "User ID tidak valid";
    exit;
}

$stmt = $pdo->prepare("SELECT id, name FROM users WHERE id=?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    echo "Pegawai tidak ditemukan";
    exit;
}

$qr_path = "qrcodes/qr_user_{$user['id']}.png";
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>QR Code Pegawai</title>
</head>
<body>
  <h2>QR Code Pegawai</h2>
  <p>Nama: <?= htmlspecialchars($user['name']) ?></p>
  <img src="<?= $qr_path ?>" alt="QR Code <?= htmlspecialchars($user['name']) ?>">
</body>
</html>
