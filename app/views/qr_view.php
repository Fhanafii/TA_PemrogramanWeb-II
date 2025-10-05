<?php
// app/Views/qr_view.php
// Variabel: $scanUrl (bila ingin), atau gunakan endpoint png
// $pngEndpoint = '/qr/png'; // sesuaikan rute public menuju QrController::png
require_once __DIR__ . '/layouts/header.php';


var_dump($_SESSION);

echo "<br>";

$base = getenv('BASE_URL') ?: 'localhost';
echo $base;
?>

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

<?php
require_once __DIR__ . '/layouts/footer.php';
?>