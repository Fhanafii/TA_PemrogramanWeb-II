<?php
require_once __DIR__ . '/layouts/header.php';

// Untuk debugging sesi
// var_dump($_SESSION);
$nik = $_SESSION['nik'] ?? '';
$baseUrl = getenv('BASE_URL') ?: '/';
?>

<div class="min-h-screen flex flex-col items-center justify-center bg-gray-50 px-4 py-10">
  <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-md text-center">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">📷 Scan QR untuk Absensi</h2>

    <div id="reader" class="w-full mx-auto border border-gray-200 rounded-lg shadow-sm overflow-hidden"></div>

    <div id="result"
      class="mt-5 text-base font-medium text-gray-700 bg-gray-100 py-3 px-4 rounded-lg border border-gray-200">
      Arahkan kamera ke QR...
    </div>

    <p class="mt-4 text-sm text-gray-500">
      Pastikan kamera dalam kondisi jelas dan QR berada di dalam kotak pemindaian.
    </p>
  </div>
</div>

<!-- Script Scanner -->
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<script>
  const BASE_URL = "<?php echo rtrim($baseUrl, '/') . '/'; ?>";
  const NIK = "<?php echo htmlspecialchars($nik, ENT_QUOTES, 'UTF-8'); ?>";

  console.log("Base URL:", BASE_URL);
  console.log("NIK:", NIK);

  function onScanSuccess(decodedText) {
    try {
      const url = new URL(decodedText);
      const token = url.searchParams.get("token");
      if (!token) throw new Error("QR tidak valid!");

      const isCheckout = confirm("Apakah ini untuk Check-out?\nKlik OK untuk Check-out, Cancel untuk Check-in.");
      const type = isCheckout ? "out" : "in";

      fetch(`${BASE_URL}index.php?controller=scan&action=submit`, {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({
            token: token,
            nik: NIK,
            type: type
          })
        })
        .then(res => res.json())
        .then(data => {
          document.getElementById("result").innerText = data.message || "Sukses!";
          document.getElementById("result").classList.add("bg-green-100", "text-green-700");
        })
        .catch(err => {
          document.getElementById("result").innerText = "❌ Terjadi kesalahan: " + err.message;
          document.getElementById("result").classList.add("bg-red-100", "text-red-700");
        });

    } catch (e) {
      document.getElementById("result").innerText = e.message;
      document.getElementById("result").classList.add("bg-red-100", "text-red-700");
    }
  }

  function onScanFailure(error) {
    console.log(`Scan error: ${error}`);
  }

  const html5QrcodeScanner = new Html5QrcodeScanner("reader", {
    fps: 10,
    qrbox: 250
  });
  html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>