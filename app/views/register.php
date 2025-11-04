<?php
require_once __DIR__ . '/layouts/header.php';
?>

<div class="min-h-screen flex items-center justify-center bg-gray-50 py-10">
  <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-8">
    <h2 class="text-2xl font-semibold text-gray-800 text-center mb-6">Form Registrasi</h2>

    <?php if (isset($error)): ?>
      <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 border border-red-300 rounded-md" role="alert">
        ❌ <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="" class="space-y-4">
      <!-- NIK -->
      <div>
        <label for="nik" class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
        <input type="text" name="nik" id="nik" required
          class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-700 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
      </div>

      <!-- Nama Lengkap -->
      <div>
        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
        <input type="text" name="name" id="name" required
          class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-700 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
      </div>

      <!-- Email -->
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input type="email" name="email" id="email" required
          class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-700 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
      </div>

      <!-- Password -->
      <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <input type="password" name="password" id="password" required
          class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-700 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
      </div>

      <!-- Tombol -->
      <div class="pt-4">
        <button type="submit"
          class="w-full bg-blue-600 text-white py-2 px-4 rounded-md font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
          Daftar
        </button>
      </div>
    </form>
  </div>
</div>

<?php
require_once __DIR__ . '/layouts/footer.php';
?>