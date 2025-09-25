<!DOCTYPE html>
<html>

<head>
  <title><?= $title ?></title>
</head>

<body>
  <h1><?= $title ?></h1>
  <?php if (!isset($user)): ?>
    <p>Selamat datang di aplikasi PHP Native MVC 🚀</p>
  <?php else: ?>
    <p>Selamat datang <?= $user ?> di aplikasi PHP Native MVC 🚀</p>
  <?php endif; ?>
  <a href="index.php?controller=user&action=profile&id=1">Lihat Profil User 1</a>
  <br>
  <a href="index.php?controller=auth&action=logout">Logout</a>
</body>

</html>