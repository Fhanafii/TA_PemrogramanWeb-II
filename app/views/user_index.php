<!DOCTYPE html>
<html>

<head>
  <title>List User</title>
</head>

<body>
  <h1>Daftar User</h1>
  <ul>
    <?php foreach ($users as $u): ?>
      <li><?= $u['nik'] ?> - <?= $u['name'] ?> (<?= $u['role'] ?>)</li>
    <?php endforeach; ?>
  </ul>


</body>

</html>