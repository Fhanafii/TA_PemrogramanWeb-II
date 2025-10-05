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
  <script src="https://unpkg.com/lucide@latest"></script>
  <script>
    lucide.createIcons(); // aktifkan ikon
  </script>
  <script src="../lib/html5qr/html5-qrcode.min.js"></script>

</head>

<body>
  <nav class="fixed top-0 left-0 h-full w-56 bg-blue-700 text-white flex flex-col p-4 shadow-lg">
    <div class="text-2xl font-bold mb-8 flex items-center gap-2">
      <i data-lucide="grid" class="w-6 h-6"></i>
      <span>Paragon</span>
    </div>

    <ul class="flex flex-col gap-4">
      <li>
        <a href="<?= $base ?>" class="flex items-center gap-3 hover:bg-blue-600 px-3 py-2 rounded-md transition">
          <i data-lucide="home" class="w-5 h-5"></i>
          <span>Home</span>
        </a>
      </li>
      <li>
        <a href="<?= $base ?>index.php?controller=scan" class="flex items-center gap-3 hover:bg-blue-600 px-3 py-2 rounded-md transition">
          <i data-lucide="scan-line" class="w-5 h-5"></i>
          <span>Scan QR</span>
        </a>
      </li>
      <li>
        <a href="<?= $base ?>index.php?controller=qr" class="flex items-center gap-3 hover:bg-blue-600 px-3 py-2 rounded-md transition">
          <i data-lucide="qr-code" class="w-5 h-5"></i>
          <span>Generate QR</span>
        </a>
      </li>
      <li>
        <a href="<?= $base ?>index.php?controller=schedule" class="flex items-center gap-3 hover:bg-blue-600 px-3 py-2 rounded-md transition">
          <i data-lucide="calendar" class="w-5 h-5"></i>
          <span>Schedule</span>
        </a>
      </li>
      <li>
        <a href="<?= $base ?>index.php?controller=Attendance" class="flex items-center gap-3 hover:bg-blue-600 px-3 py-2 rounded-md transition">
          <i data-lucide="attendance" class="w-5 h-5"></i>
          <span>Attendance</span>
        </a>
      </li>
      <li>
        <a href="<?= $base ?>index.php?controller=auth&action=logout" class="flex items-center gap-3 hover:bg-red-600 px-3 py-2 rounded-md transition">
          <i data-lucide="log-out" class="w-5 h-5"></i>
          <span>Logout</span>
        </a>
      </li>
    </ul>
  </nav>

  <!-- Konten utama -->
  <main class="ml-56 p-6">
    <h1><?= $title ?></h1>