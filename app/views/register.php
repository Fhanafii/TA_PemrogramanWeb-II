<?php
require_once __DIR__ . '/layouts/header.php';
?>

<div class="container mt-5">
  <div class="card shadow p-4 col-md-6 mx-auto">
    <h2 class="text-center mb-4">Form Registrasi</h2>

    <?php if (isset($error)): ?>
      <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 border border-green-300 rounded-lg" role="alert">
        ❌ <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="mb-3">
        <label for="nik" class="form-label">NIK</label>
        <input type="text" class="form-control" name="nik" id="nik" required>
      </div>

      <div class="mb-3">
        <label for="name" class="form-label">Nama Lengkap</label>
        <input type="text" class="form-control" name="name" id="name" required>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" name="email" id="email" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" name="password" id="password" required>
      </div>

      <button type="submit" class="btn btn-primary w-100">Daftar</button>
    </form>
  </div>
</div>


<?php
require_once __DIR__ . '/layouts/footer.php';
?>