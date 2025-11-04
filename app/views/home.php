<?php require_once __DIR__ . '/layouts/header.php'; ?>

<div class="max-w-6xl mx-auto p-6 bg-white rounded-xl shadow">
  <h1 class="text-3xl font-bold mb-6 text-gray-700">🏠 Dashboard Presensi</h1>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    <div class="p-4 bg-blue-100 text-blue-800 rounded-lg shadow">
      <h2 class="text-lg font-semibold">👥 Total Pegawai</h2>
      <p class="text-3xl font-bold mt-2"><?= $data['totalUsers'] ?></p>
    </div>

    <div class="p-4 bg-green-100 text-green-800 rounded-lg shadow">
      <h2 class="text-lg font-semibold">🕒 Check-in Hari Ini</h2>
      <p class="text-3xl font-bold mt-2"><?= $data['checkedInToday'] ?></p>
    </div>

    <div class="p-4 bg-red-100 text-red-800 rounded-lg shadow">
      <h2 class="text-lg font-semibold">⏰ Belum Check-in</h2>
      <p class="text-3xl font-bold mt-2"><?= $data['notCheckedInToday'] ?></p>
    </div>

    <div class="p-4 bg-indigo-100 text-indigo-800 rounded-lg shadow">
      <h2 class="text-lg font-semibold">🏢 Departemen</h2>
      <p class="text-3xl font-bold mt-2"><?= $data['totalDepartments'] ?></p>
    </div>

    <div class="p-4 bg-yellow-100 text-yellow-800 rounded-lg shadow">
      <h2 class="text-lg font-semibold">🎯 Jabatan</h2>
      <p class="text-3xl font-bold mt-2"><?= $data['totalPositions'] ?></p>
    </div>

    <div class="p-4 bg-purple-100 text-purple-800 rounded-lg shadow">
      <h2 class="text-lg font-semibold">📋 Jadwal Tersedia</h2>
      <p class="text-3xl font-bold mt-2"><?= $data['totalSchedules'] ?></p>
    </div>
  </div>

  <div class="mt-8 p-4 border-t border-gray-200">
    <h2 class="text-xl font-semibold text-gray-700 mb-2">📅 Jadwal Aktif</h2>
    <?php if ($data['activeSchedule']): ?>
      <p class="text-gray-700">
        <?= htmlspecialchars($data['activeSchedule']['name']) ?> —
        <?= date('F', mktime(0, 0, 0, $data['activeSchedule']['month'], 1)) . ' ' . $data['activeSchedule']['year'] ?>
      </p>
    <?php else: ?>
      <p class="text-gray-500">Belum ada jadwal untuk bulan ini.</p>
    <?php endif; ?>
  </div>
</div>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>