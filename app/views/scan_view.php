<?php
// app/Views/scan_view.php
// session_start();
var_dump($_SESSION);
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Scan QR Presensi</title>
  <!-- <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script> -->
  <script src="../lib/html5qr/html5-qrcode.min.js"></script>

  <style>
    #reader {
      width: 300px;
      margin: auto;
    }

    #result {
      margin-top: 15px;
      font-weight: bold;
    }
  </style>
</head>

<body>
  <h2>Scan QR dengan Kamera</h2>
  <div id="reader"></div>
  <div id="result">Arahkan kamera ke QR...</div>

  <!-- <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script> -->

  <script>
    const BASE_URL = "<?php echo getenv('BASE_URL'); ?>";
    console.log("Base URL:", BASE_URL);

    function onScanSuccess(decodedText, decodedResult) {
      // decodedText adalah URL yg ada di QR (contoh: https://domain/scan?token=....)
      const url = new URL(decodedText);
      const token = url.searchParams.get("token");
      console.log("ini token :", token);

      if (!token) {
        document.getElementById("result").innerText = "QR tidak valid!";
        return;
      }

      // Kirim ke backend via fetch POST
      // fetch(`${BASE_URL}/index.php?controller=scan&action=submit`, {
      // fetch(`${BASE_URL}index.php?controller=scan&action=submit`, {
      fetch('index.php?controller=scan&action=submit', {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({
            token: token,
            nik: "<?php echo $_SESSION['nik'] ?? ''; ?>",
            type: confirm("Check-out? Klik OK. Untuk Check-in klik Cancel.") ? "out" : "in"
          })
        })
        .then(res => res.json())
        .then(data => {
          document.getElementById("result").innerText = data.message;
        })
        .catch(err => {
          document.getElementById("result").innerText = "Error: " + err;
        });
    }

    function onScanFailure(error) {
      // bisa diabaikan (scanner akan terus mencoba)
      console.log(`Scan error: ${error}`);
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
      "reader", {
        fps: 10,
        qrbox: 250
      });
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
  </script>
</body>

</html>