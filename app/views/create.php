<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Buat Schedule</title>
  <!-- Tambahkan Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gray-50 flex items-center justify-center">
  <div class="w-full max-w-lg bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Buat Schedule Bulanan</h2>

    <form method="post" class="space-y-4">
      <!-- Nama -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
        <input name="name" required
          class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-700 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="Perancangan Sistem">
      </div>

      <!-- Tahun -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
        <input name="year" value="<?php echo date('Y'); ?>" required
          class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-700 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
      </div>

      <!-- Bulan -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Bulan</label>
        <select name="month"
          class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-700 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
          <?php for ($m = 1; $m <= 12; $m++): ?>
            <option value="<?php echo $m; ?>"><?php echo date('F', mktime(0, 0, 0, $m, 1)); ?></option>
          <?php endfor; ?>
        </select>
      </div>

      <!-- Default Check-in -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Default Check-in</label>
        <input name="default_checkin" type="time" value="08:00"
          class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-700 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
      </div>

      <!-- Default Check-out -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Default Check-out</label>
        <input name="default_checkout" type="time" value="16:00"
          class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-700 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
      </div>

      <!-- Catatan -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
        <textarea name="note" rows="3"
          class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-700 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"></textarea>
      </div>

      <!-- Tombol -->
      <div class="pt-4 text-center">
        <button type="submit"
          class="w-full rounded-md bg-blue-600 px-4 py-2 text-white font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
          Buat Jadwal
        </button>
      </div>
    </form>
  </div>
</body>

</html>