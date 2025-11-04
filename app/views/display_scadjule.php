<?php
require_once __DIR__ . '/layouts/header.php';
?>

<div class="max-w-5xl mx-auto mt-8 p-6 bg-white shadow-lg rounded-lg">
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-semibold text-gray-800">Daftar Jadwal Bulanan</h1>
    <a href="index.php?controller=schedule&action=create"
      class="inline-flex items-center gap-1 rounded-md bg-blue-600 px-4 py-2 text-white text-sm font-medium shadow hover:bg-blue-700 transition">
      + Tambah Jadwal
    </a>
  </div>

  <div class="overflow-x-auto">
    <table class="min-w-full border border-gray-200 divide-y divide-gray-200 rounded-lg overflow-hidden">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Bulan</th>
          <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Tahun</th>
          <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Jumlah Hari</th>
          <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Opsi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100 bg-white">
        <?php if (!empty($schedules)): ?>
          <?php foreach ($schedules as $row): ?>
            <tr class="hover:bg-gray-50 transition">
              <td class="px-6 py-4 text-sm text-gray-700"><?= htmlspecialchars($row['month'] ?? '') ?></td>
              <td class="px-6 py-4 text-sm text-gray-700"><?= htmlspecialchars($row['year'] ?? '') ?></td>
              <td class="px-6 py-4 text-sm text-gray-700"><?= htmlspecialchars($row['days_count'] ?? '0') ?></td>
              <td class="px-6 py-4 space-x-2">
                <a href="index.php?controller=schedule&action=edit&id=<?= $row['id'] ?>"
                  class="inline-block rounded bg-blue-500 px-3 py-1 text-white text-sm hover:bg-blue-600 transition">
                  Edit
                </a>
                <a href="index.php?controller=schedule&action=delete&id=<?= $row['id'] ?>"
                  class="inline-block rounded bg-red-500 px-3 py-1 text-white text-sm hover:bg-red-600 transition"
                  onclick="return confirm('Hapus jadwal ini?')">
                  Delete
                </a>
                <a href="index.php?controller=schedule&action=detail&id=<?= $row['id'] ?>"
                  class="inline-block rounded bg-green-500 px-3 py-1 text-white text-sm hover:bg-green-600 transition">
                  Detail
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
              Belum ada jadwal.
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

</body>

</html>