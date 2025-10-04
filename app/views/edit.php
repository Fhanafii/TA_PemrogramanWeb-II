<!-- <!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Edit Schedule</title>
</head> -->
<?php
require_once __DIR__ . '/layouts/header.php';

?>

<body>
  <form method="post">
    <label>Nama: <input name="name" value="<?= htmlspecialchars((string)$schedule['name']); ?>"></label><br>
    <label>Default Check-in: <input name="default_checkin" type="time" value="<?= $schedule['default_checkin'] ?? ''; ?>"></label><br>
    <label>Default Check-out: <input name="default_checkout" type="time" value="<?= $schedule['default_checkout'] ?? ''; ?>"></label><br>
    <label>Note: <textarea name="note"><?= htmlspecialchars($schedule['note'] ?? ''); ?></textarea></label><br>
    <button type="submit">Simpan</button>
  </form>

  <h3>Hari dalam Bulan</h3>
  <table border="1" cellpadding="6">
    <tr>
      <th>Tanggal</th>
      <th>Status</th>
      <th>Checkin</th>
      <th>Checkout</th>
      <th>Note</th>
      <th>Aksi</th>
    </tr>
    <?php foreach ($days as $day): ?>
      <tr id="row-<?php echo $day['id']; ?>">
        <td><?php echo $day['the_date']; ?></td>
        <td class="status"><?php echo $day['status']; ?></td>
        <td class="ci"><?php echo $day['checkin_time'] ?? $schedule['default_checkin']; ?></td>
        <td class="co"><?php echo $day['checkout_time'] ?? $schedule['default_checkout']; ?></td>
        <td class="note"><? echo htmlspecialchars($day['note'] ?? ''); ?></td>
        <td>
          <button onclick="toggleOff(<?php echo $day['id']; ?>)">Toggle Off</button>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>

  <script>
    function toggleOff(id) {
      const row = document.getElementById('row-' + id);
      // simple toggle: if work -> set off, else set work
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
          row.querySelector('.status').innerText = newStatus;
        }
      });
    }
  </script>
</body>

</html>