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
  <title>Login | Paragon Hub</title>
  <link rel="<?= $base . '../lib/tailwindcdn/tailwind.min.css' ?>" href="style.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <script>
    lucide.createIcons();
  </script>
  <script src="../lib/html5qr/html5-qrcode.min.js"></script>
  <script src="assets/js/login.js" defer></script>
</head>

<body class="min-h-screen flex flex-col md:flex-row font-[Times New Roman] bg-white overflow-x-hidden">

  <!-- Logo -->
  <div class="absolute top-4 left-1/2 md:left-8 transform -translate-x-1/2 md:translate-x-0 z-10">
    <img src="assets/img/logo.svg" alt="Logo" class="w-32 sm:w-40 md:w-48 lg:w-56 h-auto">
  </div>

  <!-- LEFT SIDE (Login Form) -->
  <div class="flex flex-col justify-center items-center w-full md:w-1/2 px-6 sm:px-10 md:px-16 lg:px-20 xl:px-28 mt-32 md:mt-0">
    <div class="w-full max-w-md">
      <div class="text-center mb-8">
        <h3 class="text-2xl sm:text-3xl font-semibold text-gray-900 mb-2">Selamat Datang</h3>
        <p class="font-semibold text-gray-900">Di Sistem HR Management Paragon</p>
      </div>

      <form method="POST" action="index.php?controller=Auth&action=login" class="space-y-6 w-full">
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <input type="email" id="email" name="email" required
            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none text-base">
        </div>

        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
          <div class="relative">
            <input type="password" id="password" name="password" required
              class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none text-base">
            <button type="button" onclick="togglePassword()"
              class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-600">
              <i data-lucide="eye"></i>
            </button>
          </div>
        </div>

        <button type="submit" name="login"
          class="w-full py-2.5 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
          Login
        </button>
      </form>
    </div>
  </div>

  <!-- RIGHT SIDE (Image) -->
  <!-- <div class="hidden md:flex justify-center items-center w-1/2 bg-gray-50">
    <div class="w-full max-w-2xl px-8">
      <img src="assets/img/frame.svg" alt="Illustration" class="w-full h-auto object-contain">
    </div>
  </div> -->

  <div class="hidden md:flex justify-center items-center w-1/2 bg-[url('assets/img/frame.svg')] bg-cover bg-center bg-no-repeat">
    <!-- Jika ingin teks atau elemen tambahan di atas background -->
    <!-- <div class="text-white text-3xl font-bold">Welcome</div> -->
  </div>

</body>

</html>