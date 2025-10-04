<?php
// app/Helpers/QrToken.php
class QrToken
{
  // Kembalikan window saat ini (periode 5 menit)
  public static function window($time = null)
  {
    $t = $time ?? time();
    return (int) floor($t / 300);
  }

  // Generate token plain (window:hex-hmac)
  public static function generate()
  {
    $window = self::window();
    $secret = getenv('QR_SECRET') ?: '';
    $hmac = hash_hmac('sha256', (string)$window, $secret);
    return $window . ':' . $hmac;
  }

  // Verify token: allow current window dan previous window
  public static function verify($token)
  {
    $secret = getenv('QR_SECRET') ?: '';
    if (!$token) return false;
    $parts = explode(':', $token);
    if (count($parts) !== 2) return false;
    list($windowStr, $providedHmac) = $parts;
    if (!ctype_digit($windowStr)) return false;
    $window = (int)$windowStr;

    // check current and previous windows
    $windowsToCheck = [self::window(), self::window() - 1];
    foreach ($windowsToCheck as $w) {
      $expected = hash_hmac('sha256', (string)$w, $secret);
      // use hash_equals untuk mencegah timing attack
      if (hash_equals($expected, $providedHmac) && $w === $window) {
        return true;
      }
    }
    return false;
  }
}
