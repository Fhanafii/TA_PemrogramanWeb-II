<?php
class AuthMiddleware
{
  public static function checkAuth()
  {
    if (empty($_SESSION['user_id'])) {
      header("Location: index.php?controller=auth&action=login");
      exit;
    }
  }

  public static function requireRole($role)
  {

    if (empty($_SESSION['user_id'])) {
      header("Location: index.php?controller=auth&action=login");
      exit;
    }

    if ($_SESSION['user_role'] !== $role) {
      // Jika bukan role yang diizinkan
      http_response_code(403);
      echo "<h1 style='color:red;'>403 Forbidden</h1><p>Anda tidak memiliki izin untuk mengakses halaman ini.</p>";
      exit;
    }
  }

  public static function requireRoles($roles = [])
  {

    if (empty($_SESSION['user_id'])) {
      header("Location: index.php?controller=auth&action=login");
      exit;
    }

    if (!in_array($_SESSION['user_role'], $roles)) {
      http_response_code(403);
      echo "<h1 style='color:red;'>403 Forbidden</h1><p>Akses dibatasi untuk peran tertentu.</p>";
      exit;
    }
  }
}
