<?php
require_once __DIR__ . '/layouts/header.php';

?>
<p>
  <a href="index.php?controller=schedule&action=create" class="button">+ Tambah Jadwal Bulanan</a>
</p>

<table>
  <thead>
    <tr>
      <th>Bulan</th>
      <th>Tahun</th>
      <th>Jumlah Hari</th>
      <th>Opsi</th>
    </tr>
  </thead>
  <tbody class="divide-y divide-gray-200 bg-white">
    <?php if (!empty($schedules)): ?>
      <?php foreach ($schedules as $row): ?>
        <tr class="hover:bg-gray-50 transition">
          <td class="px-6 py-4 text-sm text-gray-700"><?= htmlspecialchars($row['month'] ?? '') ?></td>
          <td class="px-6 py-4 text-sm text-gray-700"><?= htmlspecialchars($row['year'] ?? '') ?></td>
          <td class="px-6 py-4 text-sm text-gray-700"><?= htmlspecialchars($row['days_count'] ?? '0') ?></td>
          <td class="px-6 py-4 space-x-2">
            <a href="index.php?controller=schedule&action=edit&id=<?= $row['id'] ?>"
              class="inline-block rounded bg-blue-500 px-3 py-1 text-white text-sm hover:bg-blue-600">
              Edit
            </a>
            <a href="index.php?controller=schedule&action=delete&id=<?= $row['id'] ?>"
              class="inline-block rounded bg-red-500 px-3 py-1 text-white text-sm hover:bg-red-600"
              onclick="return confirm('Hapus jadwal ini?')">
              Delete
            </a>
            <a href="index.php?controller=schedule&action=detail&id=<?= $row['id'] ?>"
              class="inline-block rounded bg-green-500 px-3 py-1 text-white text-sm hover:bg-green-600">
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

</body>

</html>