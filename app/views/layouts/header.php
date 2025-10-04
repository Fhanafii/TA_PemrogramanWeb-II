<?php
$base = getenv('BASE_URL') ?: '';
?>

<!DOCTYPE html>
<html>

<head>
  <title><?= $title ?></title>
  <link rel="<?= $base . '../lib/tailwindcdn/tailwind.min.css' ?>" href="style.css">
  <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.4/dist/tailwind.min.css" rel="stylesheet"> -->
  <script src="https://cdn.tailwindcss.com"></script>

</head>

<body>
  <nav>
    <!-- <ul style="list-style-type: none; display: flex; gap: 10px;"> -->
    <ul class="list-none flex gap-4">
      <li><a href="<?= $base ?>index.php?controller=scan">scann QR</a></li>
      <li><a href="<?= $base ?>index.php?controller=qr">generate QR</a></li>
      <li><a href="<?= $base ?>index.php?controller=schedule">Schedule</a></li>
      <li><a href="<?= $base ?>index.php?controller=auth&action=logout">Logout</a></li>
    </ul>
  </nav>
  <h1><?= $title ?></h1>