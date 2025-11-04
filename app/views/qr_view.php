<?php
require_once __DIR__ . '/layouts/header.php';

$base = getenv('BASE_URL') ?: '/';
?>

<div class="min-h-screen flex flex-col items-center justify-center bg-gray-50 px-4 py-10">
  <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md text-center">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Scan QR untuk Login</h2>

    <div class="flex justify-center mb-6">
      <img id="qrimg"
        src="<?php echo $base . 'index.php?controller=qr&action=png' . '&_t=' . time(); ?>"
        alt="QR Code"
        class="w-56 h-56 border border-gray-200 rounded-lg shadow-sm object-contain">
    </div>

    <div class="bg-gray-100 rounded-md p-3 text-sm text-gray-700">
      <div><span class="font-medium">Token Window:</span> <?php echo floor(time() / 300); ?></div>
      <div id="countdown" class="mt-1 text-blue-600 font-medium">Masa berlaku: menghitung...⌚</div>
    </div>

    <p class="mt-6 text-gray-500 text-sm">
      QR akan diperbarui otomatis setiap 5 menit ⟳
    </p>
  </div>
</div>

<script>
  const BASE_URL = "<?php echo rtrim($base, '/') . '/'; ?>";

  function refreshQr() {
    const img = document.getElementById('qrimg');
    img.src = `${BASE_URL}index.php?controller=qr&action=png&_t=${Date.now()}`;
    console.log("QR refreshed:", img.src);
  }

  function updateCountdown() {
    const now = Math.floor(Date.now() / 1000);
    const windowLength = 300;
    const nextWindow = Math.floor(now / windowLength) * windowLength + windowLength;
    const remaining = nextWindow - now;
    const countdownEl = document.getElementById('countdown');

    countdownEl.innerText = `Masa berlaku: ${remaining} detik`;

    // Ganti warna teks mendekati habis
    if (remaining <= 30) {
      countdownEl.classList.add('text-red-600');
      countdownEl.classList.remove('text-blue-600');
    } else {
      countdownEl.classList.add('text-blue-600');
      countdownEl.classList.remove('text-red-600');
    }

    // Auto-refresh jika sudah habis
    if (remaining <= 0) refreshQr();
  }

  // Jalankan interval hitung mundur dan refresh QR
  setInterval(updateCountdown, 1000);
  setInterval(refreshQr, 300000);
  updateCountdown();
</script>

<?php
require_once __DIR__ . '/layouts/footer.php';
?>