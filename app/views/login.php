<?php
// Keep your original backend logic here
// Example: session_start(); include('../config/db.php'); etc.
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Paragon Hub</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="/assets/js/login.js" defer></script>
</head>
<body class="min-h-screen flex font-[Times New Roman] bg-white">
  <img src="/assets/img/logo.svg" alt="Logo" class="w-60 h-auto absolute top-8 left-8">

  <!-- LEFT SIDE (Login Form) -->
  <div class="flex flex-col justify-center w-full md:w-1/2 px-10 md:px-24">
    
    <!-- <div class="flex items-center gap-3 mb-10">
      <img src="/assets/img/logo.svg" alt="Paragon Logo" class="w-40 h-auto">
      <h2 class="text-2xl font-semibold text-gray-800">
        Paragon <span class="text-blue-600">Hub</span>
      </h2>
    </div> -->

    <div>
      <h3 class="text-3xl font-semibold text-center text-gray-900 mb-2">Selamat Datang</h3>
      <p class="font-semibold text-center text-gray-900 mb-10">Di Sistem HR Management Paragon</p>
    </div>

    <form method="POST" action="index.php?controller=Auth&action=login" class="space-y-6 max-w-lg mx-auto w-full">
      <div>
        <label for="username" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" id="email" name="email" required
          class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <div class="relative">
          <input type="password" id="password" name="password" required
            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
          <button type="button" onclick="togglePassword()"
            class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-600"></button>
        </div>
      </div>

      <button type="submit" name="login"
        class="w-full py-2.5 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
        Login
      </button>
    </form>
  </div>

  <!-- RIGHT SIDE (Blue Background Info) -->
   <!-- Still need to change since it just image background using whole design -->
<div class="flex flex-col justify-center w-full md:w-1/2 px-10 md:px-24">
    <div class="-mx-10 md:-mx-24">
    <img src="/assets/img/frame.svg" alt="Illustration" class="w-full h-full object-cover">
  </div>
  </div>

</body>
</html>