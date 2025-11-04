<?php
require_once __DIR__ . '/layouts/header.php';
?>

<div class="max-w-5xl mx-auto mt-8 p-6 bg-white shadow-lg rounded-lg">
  <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Edit Schedule Bulanan</h2>

  <!-- Form Edit Schedule -->
  <form method="post" class="space-y-4 mb-8">
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
      <input name="name" value="<?= htmlspecialchars((string)$schedule['name']); ?>"
        class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-700 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Default Check-in</label>
      <input name="default_checkin" type="time" value="<?= $schedule['default_checkin'] ?? ''; ?>"
        class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-700 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Default Check-out</label>
      <input name="default_checkout" type="time" value="<?= $schedule['default_checkout'] ?? ''; ?>"
        class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-700 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
      <textarea name="note" rows="3"
        class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-700 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"><?= htmlspecialchars($schedule['note'] ?? ''); ?></textarea>
    </div>

    <div class="pt-4 text-center">
      <button type="submit"
        class="w-full rounded-md bg-blue-600 px-4 py-2 text-white font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
        Simpan Perubahan
      </button>
    </div>
  </form>

  <!-- Tabel Hari dalam Bulan -->
  <h3 class="text-xl font-semibold text-gray-800 mb-4">Hari dalam Bulan</h3>
  <div class="overflow-x-auto">
    <table class="min-w-full border border-gray-200 divide-y divide-gray-200 rounded-lg overflow-hidden">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Tanggal</th>
          <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Status</th>
          <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Check-in</th>
          <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Check-out</th>
          <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Catatan</th>
          <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100 bg-white">
        <?php foreach ($days as $day): ?>
          <tr id="row-<?php echo $day['id']; ?>" class="hover:bg-gray-50 transition">
            <td class="px-4 py-2 text-sm text-gray-700"><?php echo $day['the_date']; ?></td>
            <td class="px-4 py-2 text-sm font-medium status 
              <?= $day['status'] === 'off' ? 'text-red-500' : 'text-green-600'; ?>">
              <?php echo htmlspecialchars($day['status']); ?>
            </td>
            <td class="px-4 py-2 text-sm text-gray-700 ci"><?php echo $day['checkin_time'] ?? $schedule['default_checkin']; ?></td>
            <td class="px-4 py-2 text-sm text-gray-700 co"><?php echo $day['checkout_time'] ?? $schedule['default_checkout']; ?></td>
            <td class="px-4 py-2 text-sm text-gray-700 note"><?php echo htmlspecialchars($day['note'] ?? ''); ?></td>
            <td class="px-4 py-2 text-sm">
              <button onclick="toggleOff(<?php echo $day['id']; ?>)"
                class="rounded bg-yellow-500 px-3 py-1 text-white text-sm hover:bg-yellow-600 transition">
                Toggle Off
              </button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<script>
  function toggleOff(id) {
    const row = document.getElementById('row-' + id);
    const current = row.querySelector('.status').innerText.trim();
    const newStatus = current === 'work' ? 'off' : 'work';

    fetch('?controller=schedule&action=updateDay', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: 'id=' + encodeURIComponent(id) + '&status=' + encodeURIComponent(newStatus)
    }).then(r => r.json()).then(json => {
      if (json && json.status === 'ok') {
        const statusCell = row.querySelector('.status');
        statusCell.innerText = newStatus;
        statusCell.classList.toggle('text-green-600', newStatus === 'work');
        statusCell.classList.toggle('text-red-500', newStatus === 'off');
      }
    });
  }
</script>