<?php
require_once __DIR__ . '/auth.php';
requireLogin();

$token = $_GET['token'] ?? '';
if (!$token || !isset($_SESSION['payment_token']) || $token !== $_SESSION['payment_token'] || empty($_SESSION['pending_appointment'])) {
    header('Location: index.php');
    exit;
}
$ap = $_SESSION['pending_appointment'];

// Generate a fake QR code using quickchart (static image) or placeholder SVG
$amount = (int)$ap['price'];
$serviceLabel = 'Pembayaran ' . $ap['full_name'];
$qrText = 'QRIS|clinic|' . $ap['user_id'] . '|' . $ap['date'] . ' ' . $ap['time'] . '|Rp' . $amount;


include __DIR__ . '/components/header.php';
?>
<div class="container py-5" style="max-width:720px">
  <h2 class="mb-4">Pembayaran QRIS</h2>
  <div class="card payment-card">
    <div class="card-body">
      <div class="row g-3 align-items-center">
        <div class="col-md-5 text-center">
          <img src="qr.jpg" alt="QRIS" class="img-fluid"/>
          <div class="small text-muted mt-2">Scan dengan aplikasi e-wallet yang mendukung QRIS</div>
        </div>
        <div class="col-md-7">
          <dl class="row mb-0">
            <dt class="col-5">Layanan</dt><dd class="col-7"><?php echo htmlspecialchars($ap['service_name']); ?></dd>
            <dt class="col-5">Nama</dt><dd class="col-7"><?php echo htmlspecialchars($ap['full_name']); ?></dd>
            <dt class="col-5">Tanggal</dt><dd class="col-7"><?php echo htmlspecialchars($ap['date']); ?> <?php echo htmlspecialchars($ap['time']); ?></dd>
            <dt class="col-5">Total</dt><dd class="col-7">Rp <?php echo number_format($amount,0,',','.'); ?></dd>
          </dl>
          <div class="mt-3">
            <div id="status" class="alert alert-info">Menunggu pembayaran... (5 detik)</div>
            <div class="d-flex gap-2">
              <button id="btnPay" class="btn btn-success">Saya sudah bayar</button>
              <a class="btn btn-outline-secondary" href="index.php">Batal</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  const btn = document.getElementById('btnPay');
  const statusBox = document.getElementById('status');
  let triggered = false;
  function process(){
    if (triggered) return; triggered = true;
    statusBox.className = 'alert alert-warning';
    statusBox.textContent = 'Memproses pembayaran...';
    setTimeout(()=>{
      window.location.href = 'payment_complete.php?token=<?php echo urlencode($token); ?>';
    }, 5000);
  }
  btn.addEventListener('click', process);
  // Auto trigger after 5s as well
  setTimeout(process, 5000);
</script>
<?php include __DIR__ . '/components/footer.php'; ?>