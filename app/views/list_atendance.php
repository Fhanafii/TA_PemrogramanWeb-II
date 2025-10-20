<?php
require_once __DIR__ . '/layouts/header.php';

function getAttendanceStatus($day)
{
  // ubah ke format tanggal PHP (tanpa jam)
  $today = date('Y-m-d');
  $dayDate = $day['the_date'];

  // 1️⃣ Jika hari libur
  if ($day['day_status'] === 'off') {
    return ['Libur', 'text-gray-600 bg-gray-100'];
  }

  // 2️⃣ Jika sudah check-in dan check-out
  if (!empty($day['checkin_id']) && !empty($day['checkout_id'])) {
    return ['Hadir', 'text-green-600 bg-green-100'];
  }

  // 3️⃣ Jika sudah check-in tapi belum checkout
  if (!empty($day['checkin_id']) && empty($day['checkout_id'])) {
    return ['Belum Checkout', 'text-orange-600 bg-orange-100'];
  }

  // 4️⃣ Jika belum check-in & belum checkout
  if (empty($day['checkin_id']) && empty($day['checkout_id'])) {
    if ($dayDate < $today) {
      // Sudah lewat dari hari ini → dianggap absen
      return ['Absen', 'text-red-600 bg-red-100'];
    } else {
      // Masih hari ini atau ke depan → belum absen
      return ['Belum Absen', 'text-blue-600 bg-blue-100'];
    }
  }

  // fallback
  return ['Tidak Diketahui', 'text-gray-600 bg-gray-100'];
}
?>
<div class="max-w-5xl mx-auto bg-white rounded-xl shadow p-6">
  <h1 class="text-2xl font-bold mb-4 text-gray-700">📋 Daftar Absensi Bulanan</h1>

  <table class="min-w-full border border-gray-200 mt-4 rounded-lg overflow-hidden">
    <thead class="bg-gray-100">
      <tr>
        <th class="px-4 py-2 text-left text-gray-700">Tanggal</th>
        <th class="px-4 py-2 text-left text-gray-700">Status Hari</th>
        <th class="px-4 py-2 text-left text-gray-700">Check-in</th>
        <th class="px-4 py-2 text-left text-gray-700">Check-out</th>
        <th class="px-4 py-2 text-left text-gray-700">Keterangan</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-200 bg-white">
      <?php if (!empty($attendanceDays)): ?>
        <?php foreach ($attendanceDays as $day): ?>
          <?php [$statusText, $statusClass] = getAttendanceStatus($day); ?>
          <tr class="hover:bg-gray-50 transition">
            <td class="px-4 py-2 text-gray-700"><?= htmlspecialchars($day['the_date']) ?></td>
            <td class="px-4 py-2 text-gray-700">
              <?= $day['day_status'] === 'work' ? 'Masuk' : 'Libur' ?>
            </td>
            <td class="px-4 py-2 text-gray-700"><?= $day['checkin_time'] ?? '-' ?></td>
            <td class="px-4 py-2 text-gray-700"><?= $day['checkout_time'] ?? '-' ?></td>
            <td class="px-4 py-2 font-medium rounded <?= $statusClass ?> px-2 py-1 inline-block">
              <?= $statusText ?>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="5" class="text-center py-4 text-gray-500">Tidak ada data absensi.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>

  <div class="mt-4">
    <a href="index.php?controller=schedule" class="text-blue-600 hover:underline">← Kembali ke Jadwal</a>
  </div>
</div>

<?php require_once __DIR__ . '/layouts/header.php' ?>