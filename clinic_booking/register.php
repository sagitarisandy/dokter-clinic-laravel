<?php
require_once __DIR__ . '/auth.php';
if (currentUser()) { header('Location: index.php'); exit; }
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';
    if ($password !== $password2) {
        $message = 'Password konfirmasi tidak cocok.';
    } elseif (!$name || !$email || !$password) {
        $message = 'Lengkapi semua field.';
    } else {
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE email = ?');
        $stmt->execute([$email]);
        if ($stmt->fetchColumn() > 0) {
            $message = 'Email sudah terdaftar.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $insert = $pdo->prepare('INSERT INTO users (name,email,password,role) VALUES (?,?,?,"user")');
            $insert->execute([$name,$email,$hash]);
            login($email,$password);
            header('Location: user_dashboard.php');
            exit;
        }
    }
}
include __DIR__ . '/components/header.php';
?>
<section class="auth-section">
    <div class="container">
        <div class="auth-card mx-auto">
            <div class="brand mb-3"><span class="logo">🦷</span> <span>Dental Clinic</span></div>
            <h2 class="h4 mb-2">Buat Akun Baru</h2>
            <p class="text-muted mb-4">Akses cepat untuk booking appointment.</p>
            <?php if ($message): ?><div class="alert alert-warning"><?php echo htmlspecialchars($message); ?></div><?php endif; ?>
            <form method="post">
                <div class="mb-3"><label class="form-label">Nama Lengkap</label><input name="name" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Password</label><input type="password" name="password" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Konfirmasi Password</label><input type="password" name="password2" class="form-control" required></div>
                <button class="btn btn-success w-100">Daftar</button>
            </form>
            <p class="mt-3 small">Sudah punya akun? <a href="login.php">Login</a></p>
        </div>
    </div>
    </section>
<?php include __DIR__ . '/components/footer.php'; ?>