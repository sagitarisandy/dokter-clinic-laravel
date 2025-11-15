<?php
require_once __DIR__ . '/auth.php';
requireLogin();
if (isDoctor()) { header('Location: doctor_dashboard.php'); exit; }
include __DIR__ . '/components/header.php';

$stmt = $pdo->prepare('SELECT a.*, s.name AS service_name FROM appointments a LEFT JOIN services s ON s.id = a.service_id WHERE user_id = ? ORDER BY created_at DESC');
$stmt->execute([ currentUser()['id'] ]);
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Simple stats computed locally (no extra queries)
$total = count($appointments);
$paid = 0; $unpaid = 0; $total_spent = 0;
foreach ($appointments as $r) {
  if (strtolower((string)$r['status']) === 'paid') { $paid++; $total_spent += (int)$r['price']; }
  else { $unpaid++; }
}
?>

<!-- Hero / Header section -->
<section class="hero-dashboard text-light">
  <div class="container py-5">
    <div class="row align-items-center g-4">
      <div class="col-lg-8">
        <h1 class="hero-title mb-3">Elevating Your Smile, <?php echo htmlspecialchars(currentUser()['name']); ?>!</h1>
        <p class="lead opacity-85 mb-4">Kelola riwayat appointment Anda dengan mudah. Pesan janji baru, unduh bukti, dan pantau status pembayaran—all in one place.</p>
        <a href="index.php#appointment" class="btn btn-accent btn-lg me-2">Buat Appointment Baru</a>
        <a href="#appointments" class="btn btn-outline-light btn-lg">Lihat Riwayat</a>
      </div>
      <div class="col-lg-4 d-none d-lg-block">
        <div class="hero-badge">
          <div class="small text-uppercase text-white-50">Quick Info</div>
          <div class="fs-4 fw-semibold">Total Appointment: <?php echo (int)$total; ?></div>
        </div>
      </div>
    </div>
  </div>
  <div class="hero-wave"></div>
  <div class="container position-relative translate-up">
    <!-- Stats cards -->
    <div class="row g-3 stats-grid">
      <div class="col-6 col-md-3">
        <div class="card stat-card">
          <div class="card-body d-flex align-items-center">
            <span class="icon-circle bg-soft-primary me-3">🏥</span>
            <div>
              <div class="stat-label">Total</div>
              <div class="stat-value"><?php echo (int)$total; ?>+</div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="card stat-card">
          <div class="card-body d-flex align-items-center">
            <span class="icon-circle bg-soft-success me-3">✔️</span>
            <div>
              <div class="stat-label">Paid</div>
              <div class="stat-value text-success"><?php echo (int)$paid; ?></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="card stat-card">
          <div class="card-body d-flex align-items-center">
            <span class="icon-circle bg-soft-warning me-3">⏳</span>
            <div>
              <div class="stat-label">Belum Bayar</div>
              <div class="stat-value text-warning"><?php echo (int)$unpaid; ?></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="card stat-card">
          <div class="card-body d-flex align-items-center">
            <span class="icon-circle bg-soft-info me-3">💳</span>
            <div>
              <div class="stat-label">Total Dibayar</div>
              <div class="stat-value">Rp <?php echo number_format((int)$total_spent,0,',','.'); ?></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="container my-5" id="appointments">
  <?php if (isset($_GET['booked'])): ?>
    <div class="alert alert-success shadow-sm">Appointment berhasil dibuat. <a class="alert-link" target="_blank" href="appointment_pdf.php?id=<?php echo (int)$_GET['booked']; ?>">Unduh PDF</a></div>
  <?php endif; ?>

  <div class="card card-elevated">
    <div class="card-header bg-white d-flex align-items-center justify-content-between">
      <h2 class="h5 mb-0">Riwayat Appointment</h2>
      <a href="index.php#appointment" class="btn btn-primary btn-sm">+ Appointment Baru</a>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-modern align-middle mb-0">
          <thead>
            <tr>
              <th>ID</th>
              <th>Tanggal</th>
              <th>Waktu</th>
              <th>Layanan</th>
              <th>Harga</th>
              <th>Status</th>
              <th>Catatan</th>
              <th class="text-center">PDF</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($appointments as $a): ?>
            <tr>
              <td class="fw-semibold">#<?php echo (int)$a['id']; ?></td>
              <td><?php echo htmlspecialchars($a['date']); ?></td>
              <td><?php echo htmlspecialchars($a['time']); ?></td>
              <td><?php echo htmlspecialchars($a['service_name'] ?? '-'); ?></td>
              <td>Rp <?php echo number_format((int)$a['price'],0,',','.'); ?></td>
              <td>
                <?php $ok = strtolower((string)$a['status'])==='paid'; ?>
                <span class="badge rounded-pill bg-<?php echo $ok?'success':'secondary'; ?>">
                  <?php echo htmlspecialchars($a['status']); ?>
                </span>
              </td>
              <td class="text-truncate" style="max-width:240px;" title="<?php echo htmlspecialchars($a['notes']); ?>"><?php echo htmlspecialchars($a['notes']); ?></td>
              <td class="text-center"><a class="btn btn-sm btn-outline-secondary" target="_blank" href="appointment_pdf.php?id=<?php echo (int)$a['id']; ?>">PDF</a></td>
            </tr>
          <?php endforeach; ?>
          <?php if (!$appointments): ?>
            <tr>
              <td colspan="8" class="text-center p-5">
                <div class="empty-state">
                  <div class="icon">📄</div>
                  <h5 class="mb-2">Belum ada appointment</h5>
                  <p class="text-muted mb-3">Mulai jaga kesehatan gigi Anda dengan membuat appointment pertama.</p>
                  <a href="index.php#appointment" class="btn btn-accent">Buat Appointment</a>
                </div>
              </td>
            </tr>
          <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/components/footer.php'; ?>