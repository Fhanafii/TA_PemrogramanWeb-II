<?php
$base = getenv('BASE_URL') ?: '';
$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
$url .= "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];


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

<body class="min-h-screen flex">

  <!-- Left Section -->
  <div class="w-1/2 bg-gray-50 flex flex-col justify-center px-16">
    <!-- Logo -->
    <div class="flex items-center mb-8">
      <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-xl mr-2">P</div>
      <h1 class="text-2xl font-semibold text-gray-800">Paragon <span class="text-blue-600">Hub</span></h1>
    </div>

    <div class="max-w-sm w-full">
      <h2 class="text-2xl font-bold text-gray-900 mb-2">Selamat Datang</h2>
      <p class="text-gray-500 mb-8">Di Sistem HR management Paragon</p>

      <?php if (isset($_GET['success']) && $_GET['success'] === 'registered'): ?>
        <div class="p-3 mb-4 text-sm text-green-800 bg-green-100 border border-green-300 rounded-lg" role="alert">
          ✅ Registrasi berhasil! Silakan login untuk melanjutkan.
        </div>
      <?php endif; ?>

      <form method="POST" action="index.php?controller=Auth&action=login" class="space-y-5">
        <div>
          <label class="block text-gray-700 font-medium mb-1">Username</label>
          <input type="text" name="email" required
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-600 focus:outline-none">
        </div>
        <div>
          <label class="block text-gray-700 font-medium mb-1">Password</label>
          <input type="password" name="password" required
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-600 focus:outline-none">
        </div>
        <button type="submit"
          class="w-full bg-blue-600 text-white py-2 rounded-md font-medium hover:bg-blue-700 transition">
          Login
        </button>
      </form>
    </div>
  </div>

  <!-- Right Section -->
  <div class="w-1/2 bg-blue-700 text-white flex flex-col justify-center px-16 relative overflow-hidden">
    <!-- Decorative lines -->
    <div class="absolute inset-0 opacity-20">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" viewBox="0 0 500 500">
        <defs>
          <pattern id="lines" width="100" height="100" patternUnits="userSpaceOnUse">
            <path d="M0,50 Q50,0 100,50 T200,50" stroke="white" stroke-width="1" fill="none" />
          </pattern>
        </defs>
        <rect width="100%" height="100%" fill="url(#lines)" />
      </svg>
    </div>

    <!-- Content -->
    <div class="relative z-10 max-w-md">
      <div class="text-4xl font-semibold mb-4">Paragon Hub</div>
      <p class="text-base leading-relaxed text-gray-100">
        Bringing people, performance, and presence together. Manage HR smarter, track attendance instantly with QR,
        and unlock the true potential of your workforce.
      </p>
    </div>
  </div>

</body>

</html>