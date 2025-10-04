<?php require_once __DIR__ . '/layouts/header.php'; ?>

<?= "Selamat datang {$_SESSION['user_role']}" ?>
<?php if (!isset($user)): ?>
  <p>Selamat datang di aplikasi PHP Native MVC 🚀</p>
<?php else: ?>
  <p>Selamat datang <?= $user ?> di aplikasi PHP Native MVC 🚀</p>
<?php endif; ?>


<?php require_once __DIR__ . '/layouts/footer.php'; ?>