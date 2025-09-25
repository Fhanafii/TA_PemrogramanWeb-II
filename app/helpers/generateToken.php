<?php
function generateRandomHex($length = 32)
{
  return bin2hex(random_bytes($length)); // menghasilkan string 64 hex chars untuk length=32
}

function createRememberToken(PDO $pdo, int $userId, string $userAgent)
{
  $selector = bin2hex(random_bytes(9));    // ~18 chars, cukup pendek untuk lookup
  $validator = generateRandomHex(32);      // panjang token yang sulit ditebak
  $tokenHash = hash('sha256', $validator);
  $expiresAt = (new DateTime('+7 days'))->format('Y-m-d H:i:s');

  $stmt = $pdo->prepare("INSERT INTO remember_tokens (user_id, selector, token_hash, user_agent, expires_at) VALUES (?, ?, ?, ?, ?)");
  $stmt->execute([$userId, $selector, $tokenHash, $userAgent, $expiresAt]);

  // simpan cookie: format "selector:validator"
  $cookieValue = $selector . ':' . $validator;
  setcookie('remember_me', $cookieValue, [
    'expires' => time() + 7 * 24 * 60 * 60, // 1 minggu
    'path' => '/',
    'domain' => '', // sesuaikan jika perlu
    'secure' => true, // HARUS true jika pakai HTTPS
    'httponly' => true,
    'samesite' => 'Lax'
  ]);

  return true;
}
