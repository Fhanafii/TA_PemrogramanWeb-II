<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Deteil user</title>
</head>

<body>
  <h1>Detail User</h1>
  <?php if ($user): ?>
    <p>ID: <?= $user['id'] ?></p>
    <p>NIK: <?= $user['nik'] ?></p>
    <p>Nama: <?= $user['name'] ?></p>
    <p>Email: <?= $user['email'] ?></p>
    <p>Role: <?= $user['role'] ?></p>
  <?php else: ?>
    <p>User tidak ditemukan</p>
  <?php endif; ?>

</body>

</html>