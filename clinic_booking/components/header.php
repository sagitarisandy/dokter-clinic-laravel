<?php
require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../auth.php';
// Ensure DB tables exist at first load by including init when needed
// If tables not present, try creating them silently
try {
    $pdo->query('SELECT 1 FROM users LIMIT 1');
} catch (Exception $e) {
    @include __DIR__ . '/../init_db.php';
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
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="index.php">Klinik</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample" aria-controls="navbarsExample" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarsExample">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="index.php#appointment">Make Appointment</a></li>
        <?php if (currentUser() && !isDoctor()): ?>
          <li class="nav-item"><a class="nav-link" href="user_dashboard.php">Dashboard</a></li>
        <?php elseif (isDoctor()): ?>
          <li class="nav-item"><a class="nav-link" href="doctor_dashboard.php">Dashboard Dokter</a></li>
        <?php endif; ?>
      </ul>
      <div class="d-flex">
        <?php if (currentUser()): ?>
          <span class="navbar-text me-3">Hi, <?php echo htmlspecialchars(currentUser()['name']); ?></span>
          <a class="btn btn-light btn-sm" href="logout.php">Logout</a>
        <?php else: ?>
          <a class="btn btn-light btn-sm me-2" href="login.php">Login</a>
          <a class="btn btn-outline-light btn-sm" href="register.php">Registrasi</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
