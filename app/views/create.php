<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Buat Schedule</title>
</head>

<body>
  <h2>Buat Schedule Bulanan</h2>
  <form method="post">
    <label>Nama: <input name="name" required></label><br>
    <label>Tahun: <input name="year" value="<?php echo date('Y'); ?>" required></label><br>
    <label>Bulan:
      <select name="month">
        <?php for ($m = 1; $m <= 12; $m++): ?>
          <option value="<?php echo $m; ?>"><?php echo date('F', mktime(0, 0, 0, $m, 1)); ?></option>
        <?php endfor; ?>
      </select>
    </label><br>
    <label>Default Check-in: <input name="default_checkin" type="time" value="08:00"></label><br>
    <label>Default Check-out: <input name="default_checkout" type="time" value="16:00"></label><br>
    <label>Catatan: <textarea name="note"></textarea></label><br>
    <button type="submit">Buat</button>
  </form>
</body>

</html>