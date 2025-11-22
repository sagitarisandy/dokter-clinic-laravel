<?php
require_once __DIR__ . '/auth.php';
if (currentUser()) { header('Location: index.php'); exit; }
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if (login($email, $password)) {
        header('Location: ' . (isDoctor() ? 'doctor_dashboard.php' : 'user_dashboard.php'));
        exit;
    } else {
        $message = 'Email atau password salah.';
    }
}
include __DIR__ . '/components/header.php';
?>
<section class="auth-section">
  <div class="container">
    <div class="auth-card mx-auto">
      <div class="brand mb-3"><span class="logo">🦷</span> <span>Dental Clinic</span></div>
      <h2 class="h4 mb-2">Masuk ke Akun</h2>
      <p class="text-muted mb-4">Kelola appointment dan riwayat kunjungan Anda.</p>
      <?php if ($message): ?><div class="alert alert-danger"><?php echo htmlspecialchars($message); ?></div><?php endif; ?>
      <form method="post">
        <div class="mb-3"><label class="form-label">Email</label><input name="email" type="email" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Password</label><input name="password" type="password" class="form-control" required></div>
        <button class="btn btn-primary w-100">Login</button>
      </form>
      <p class="mt-3 small">Belum punya akun? <a href="register.php">Registrasi</a></p>
    </div>
  </div>
  </section>
<?php include __DIR__ . '/components/footer.php'; ?>