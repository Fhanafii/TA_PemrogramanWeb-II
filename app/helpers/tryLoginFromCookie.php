<?php
function tryAutoLoginFromCookie(PDO $pdo)
{
  if (isset($_SESSION['user_id'])) {
    return; // sudah login
  }

  if (empty($_COOKIE['remember_me'])) {
    return;
  }

  $cookie = $_COOKIE['remember_me'];
  if (!strpos($cookie, ':')) {
    return;
  }

  list($selector, $validator) = explode(':', $cookie, 2);
  if (!$selector || !$validator) return;

  $stmt = $pdo->prepare("SELECT id, user_id, token_hash, expires_at, user_agent FROM remember_tokens WHERE selector = ?");
  $stmt->execute([$selector]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$row) {
    // tidak ada selector -> ignore
    return;
  }

  // cek expired
  if (new DateTime() > new DateTime($row['expires_at'])) {
    // hapus token expired
    $del = $pdo->prepare("DELETE FROM remember_tokens WHERE id = ?");
    $del->execute([$row['id']]);
    setcookie('remember_me', '', time() - 3600, '/');
    return;
  }

  // bandingkan hash validator
  $calcHash = hash('sha256', $validator);
  if (hash_equals($row['token_hash'], $calcHash)) {
    // valid: auto-login user
    session_regenerate_id(true);
    $_SESSION['user_id'] = (int)$row['user_id'];

    // rotate validator: buat validator baru, update DB dan cookie
    $newValidator = generateRandomHex(32);
    $newHash = hash('sha256', $newValidator);
    $newExpires = (new DateTime('+7 days'))->format('Y-m-d H:i:s');

    $upd = $pdo->prepare("UPDATE remember_tokens SET token_hash = ?, expires_at = ?, user_agent = ? WHERE id = ?");
    $upd->execute([$newHash, $newExpires, $_SERVER['HTTP_USER_AGENT'] ?? '', $row['id']]);

    $newCookie = $selector . ':' . $newValidator;
    setcookie('remember_me', $newCookie, [
      'expires' => time() + 7 * 24 * 60 * 60,
      'path' => '/',
      'secure' => true,
      'httponly' => true,
      'samesite' => 'Lax'
    ]);

    return;
  } else {
    // validator mismatch -> kemungkinan cookie dicuri / dicoba tebak
    // hapus semua token untuk user agar revoke session
    $del = $pdo->prepare("DELETE FROM remember_tokens WHERE user_id = ?");
    $del->execute([$row['user_id']]);
    setcookie('remember_me', '', time() - 3600, '/');
    // opsional: log kejadian, kirim notifikasi ke owner, dsb.
    return;
  }
}
