<?php
$base = getenv('BASE_URL') ?: '';
$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
$url .= "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?></title>
  <link rel="<?= $base . '../lib/tailwindcdn/tailwind.min.css' ?>" href="style.css">
  <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.4/dist/tailwind.min.css" rel="stylesheet"> -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <script>
    lucide.createIcons(); // aktifkan ikon
  </script>
  <script src="../lib/html5qr/html5-qrcode.min.js"></script>
  <link rel="icon" type="image/svg+xml" href="assets/img/logo1.svg" />
</head>

<body class="flex flex-col md:flex-row bg-gray-50 min-h-screen">

  <!-- MOBILE NAVBAR -->
  <header class="md:hidden fixed top-0 left-0 right-0 bg-blue-700 text-white flex items-center justify-between px-4 py-3 shadow-lg z-50">
    <div class="flex items-center gap-2">
      <i data-lucide="grid" class="w-6 h-6"></i>
      <span class="font-bold text-lg">Paragon</span>
    </div>
    <button id="menuToggle" class="focus:outline-none">
      <i data-lucide="menu" class="w-6 h-6">☰</i>
    </button>
  </header>

  <!-- SIDEBAR (Desktop + Mobile) -->
  <!-- class="fixed md:static top-0 left-0 md:h-full w-56 bg-blue-700 text-white flex flex-col p-4 shadow-lg transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-40"> -->
  <nav id="sidebar"
    class="fixed  top-0 left-0 h-full w-56 bg-blue-700 text-white flex flex-col p-4 shadow-lg transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-40">
    <div class="text-2xl font-bold mb-8 flex items-center gap-2 mt-10 md:mt-0">
      <i data-lucide="grid" class="w-6 h-6"></i>
      <span>Paragon</span>
    </div>

    <ul class="flex flex-col gap-4 overflow-y-auto">
      <li>
        <a href="<?= $base ?>" class="flex items-center gap-3 hover:bg-blue-600 px-3 py-2 rounded-md transition <?php echo ($base === $url) ? 'bg-blue-600' : '' ?>">
          <i data-lucide="home" class="w-5 h-5"></i>
          <span>Home</span>
        </a>
      </li>
      <li>
        <a href="<?= $base ?>index.php?controller=scan" class="flex items-center gap-3 hover:bg-blue-600 px-3 py-2 rounded-md transition <?php echo ($base . 'index.php?controller=scan' === $url) ? 'bg-blue-600' : '' ?>">
          <i data-lucide="scan-line" class="w-5 h-5"></i>
          <span>Scan QR</span>
        </a>
      </li>
      <li>
        <a href="<?= $base ?>index.php?controller=Attendance" class="flex items-center gap-3 hover:bg-blue-600 px-3 py-2 rounded-md transition <?php echo ($base . 'index.php?controller=Attendance' === $url) ? 'bg-blue-600' : '' ?>">
          <i data-lucide="check-circle" class="w-5 h-5"></i>
          <span>Attendance</span>
        </a>
      </li>

      <?php if ($_SESSION['user_role'] === 'Admin'): ?>
        <li>
          <a href="<?= $base ?>index.php?controller=qr" class="flex items-center gap-3 hover:bg-blue-600 px-3 py-2 rounded-md transition <?php echo ($base . 'index.php?controller=qr' === $url) ? 'bg-blue-600' : '' ?>">
            <i data-lucide="qr-code" class="w-5 h-5"></i>
            <span>Generate QR</span>
          </a>
        </li>
        <li>
          <a href="<?= $base ?>index.php?controller=schedule" class="flex items-center gap-3 hover:bg-blue-600 px-3 py-2 rounded-md transition <?php echo ($base . 'index.php?controller=schedule' === $url) ? 'bg-blue-600' : '' ?>">
            <i data-lucide="calendar" class="w-5 h-5"></i>
            <span>Schedule</span>
          </a>
        </li>
        <li>
          <a href="<?= $base ?>index.php?controller=auth&action=register" class="flex items-center gap-3 hover:bg-blue-600 px-3 py-2 rounded-md transition <?php echo ($base . 'index.php?controller=auth&action=register' === $url) ? 'bg-blue-600' : '' ?>">
            <i data-lucide="user-plus" class="w-5 h-5"></i>
            <span>Register</span>
          </a>
        </li>
      <?php endif; ?>

      <li>
        <a href="<?= $base ?>index.php?controller=auth&action=logout" class="flex items-center gap-3 hover:bg-red-600 px-3 py-2 rounded-md transition">
          <i data-lucide="log-out" class="w-5 h-5"></i>
          <span>Logout</span>
        </a>
      </li>
    </ul>
  </nav>

  <!-- MAIN CONTENT -->
  <main class="flex-1 md:ml-56 mt-14 md:mt-0 p-6 transition-all duration-300">
    <h1 class="text-2xl font-bold text-gray-800 mb-6"><?= $title ?></h1>