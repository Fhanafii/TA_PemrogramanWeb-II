<?php
// app/Views/qr_view.php
// Variabel: $scanUrl (bila ingin), atau gunakan endpoint png
// $pngEndpoint = '/qr/png'; // sesuaikan rute public menuju QrController::png

var_dump($_SESSION);

echo "<br>";

$base = getenv('BASE_URL') ?: 'localhost';
echo $base;
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>QR Presensi</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      text-align: center;
      padding: 20px;
    }

    .qr {
      display: inline-block;
      padding: 10px;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    }

    .meta {
      margin-top: 10px;
      color: #666;
    }
  </style>
</head>

<body>
  <h2>QR Presensi (Refresh otomatis tiap 5 menit)</h2>
  <div class="qr">
    <!-- <img id="qrimg" src="<?php echo $pngEndpoint . '?_t=' . time(); ?>" alt="QR Code"> -->
    <!-- <img id="qrimg" src="<?php echo $base . 'index.php?controller=qr&action=png' . '&_t=' . time(); ?>" alt="QR Code"> -->
    <img id="qrimg" src="<?php echo $base . 'index.php?controller=qr&action=png' . '&_t=' . time(); ?>" alt="QR Code">
  </div>
  <div class="meta">
    <div>Token window: <?php echo floor(time() / 300); ?></div>
    <div id="countdown">Masa berlaku: menghitung...⌚</div>
  </div>

  <script>
    // Auto-refresh gambar setiap 5 menit (300000 ms). 
    // Juga tampilkan countdown sisa waktu window 5 menit.
    const BASE_URL = "<?php echo getenv('BASE_URL'); ?>";
    // console.log("Base URL:", BASE_URL);

    function refreshQr() {
      const img = document.getElementById('qrimg');

      // img.src = '<?php echo "http://192.168.1.133/SEMESTERVII/pemrograman2/coba2basedSession/public/index.php?controller=qr&action=png"; ?>&_t=' + Date.now();
      img.src = `${BASE_URL}index.php?controller=qr&action=png&_t=${Date.now()}`;
      console.log("QR refreshed:", img.src);
    }

    function updateCountdown() {
      const now = Math.floor(Date.now() / 1000);
      const windowLength = 300;
      const seed = Math.floor(now / windowLength) * windowLength + windowLength;
      const remaining = seed - now;
      document.getElementById('countdown').innerText = 'Masa berlaku: ' + remaining + ' detik';
      if (remaining <= 0) {
        refreshQr();
      }
    }
    // refresh tiap 1 detik hitung mundur, otomatis refresh juga setiap 5 menit
    setInterval(updateCountdown, 1000);
    setInterval(refreshQr, 300000); // fallback refresh tiap 5 menit
    updateCountdown();
  </script>
</body>

</html>