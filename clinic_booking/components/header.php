<?php
require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../auth.php';
// Ensure DB tables exist at first load by including init when needed (silent)
try {
  // Check base table
  $pdo->query('SELECT 1 FROM users LIMIT 1');
  // Also ensure newer tables/columns
  $pdo->query('SELECT 1 FROM services LIMIT 1');
} catch (Exception $e) {
  // Run initializer silently to add missing tables/columns
  if (is_file(__DIR__ . '/../init_db.php')) {
    ob_start();
    include __DIR__ . '/../init_db.php';
    ob_end_clean();
  }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Klinik Booking</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/style.css" rel="stylesheet">
</head>
<body>

<!-- Topbar -->
<div class="topbar d-none d-lg-block py-2">
  <div class="container d-flex align-items-center justify-content-between">
    <div class="d-flex">
      <div class="item"><span>📞</span><span>+62 812 0000 0000</span></div>
      <div class="item"><span>⏰</span><span>Mon–Sat 08.00–17.00</span></div>
      <div class="item"><span>📍</span><span>Jakarta, Indonesia</span></div>
    </div>
    <div class="d-flex">
      <div class="item"><span>✉️</span><span>care@klinik.demo</span></div>
    </div>
  </div>
  </div>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark site-navbar">
  <div class="container">
    <a class="navbar-brand" href="index.php">🦷 Dental Clinic</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample" aria-controls="navbarsExample" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarsExample">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="index.php#about">Tentang</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php#services">Layanan</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php#team">Dokter</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php#faq">FAQ</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php#appointment">Appointment</a></li>
        <?php if (currentUser() && !isDoctor()): ?>
          <li class="nav-item"><a class="nav-link" href="user_dashboard.php">Dashboard</a></li>
        <?php elseif (isDoctor()): ?>
          <li class="nav-item"><a class="nav-link" href="doctor_dashboard.php">Dashboard Dokter</a></li>
        <?php endif; ?>
      </ul>
      <div class="d-flex align-items-center gap-2">
        <?php if (currentUser()): ?>
          <span class="text-white-50 small d-none d-md-inline">Hi, <?php echo htmlspecialchars(currentUser()['name']); ?></span>
          <a class="btn btn-light btn-sm" href="logout.php">Logout</a>
        <?php else: ?>
          <a class="btn btn-outline-light btn-sm" href="login.php">Login</a>
          <a class="btn btn-cta btn-sm" href="register.php">Registrasi</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
