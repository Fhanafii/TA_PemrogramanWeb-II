<?php
function logout(PDO $pdo)
{
  // hapus session
  $_SESSION = [];
  if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
      session_name(),
      '',
      time() - 42000,
      $params["path"],
      $params["domain"],
      $params["secure"],
      $params["httponly"]
    );
  }
  session_destroy();

  // hapus remember token yang terkait cookie saat ini (jika ada)
  if (!empty($_COOKIE['remember_me']) && strpos($_COOKIE['remember_me'], ':')) {
    list($selector, $validator) = explode(':', $_COOKIE['remember_me'], 2);
    $stmt = $pdo->prepare("DELETE FROM remember_tokens WHERE selector = ?");
    $stmt->execute([$selector]);
    setcookie('remember_me', '', time() - 3600, '/');
  }

  header("Location: http://localhost/SEMESTERVII/pemrograman2/coba2basedSession/public/index.php?controller=auth&action=index");
  exit;
}
