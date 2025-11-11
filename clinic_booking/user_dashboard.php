<?php
require_once __DIR__ . '/auth.php';
requireLogin();
if (isDoctor()) { header('Location: doctor_dashboard.php'); exit; }
include __DIR__ . '/components/header.php';

$stmt = $pdo->prepare('SELECT * FROM appointments WHERE user_id = ? ORDER BY created_at DESC');
$stmt->execute([ currentUser()['id'] ]);
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container py-5">
  <h2 class="mb-4">Dashboard User</h2>
  <?php if (isset($_GET['booked'])): ?><div class="alert alert-success">Appointment berhasil dibuat. <a target="_blank" href="appointment_pdf.php?id=<?php echo (int)$_GET['booked']; ?>">Unduh PDF</a></div><?php endif; ?>
  <p>Selamat datang, <strong><?php echo htmlspecialchars(currentUser()['name']); ?></strong>. <a href="index.php">Buat Appointment Baru</a></p>
  <table class="table table-striped mt-4">
    <thead><tr><th>ID</th><th>Tanggal</th><th>Waktu</th><th>Nama</th><th>Email</th><th>Telepon</th><th>Catatan</th><th>Aksi</th></tr></thead>
    <tbody>
      <?php foreach ($appointments as $a): ?>
        <tr>
          <td><?php echo (int)$a['id']; ?></td>
          <td><?php echo htmlspecialchars($a['date']); ?></td>
          <td><?php echo htmlspecialchars($a['time']); ?></td>
          <td><?php echo htmlspecialchars($a['full_name']); ?></td>
          <td><?php echo htmlspecialchars($a['email']); ?></td>
          <td><?php echo htmlspecialchars($a['phone']); ?></td>
          <td><?php echo htmlspecialchars($a['notes']); ?></td>
          <td><a class="btn btn-sm btn-outline-secondary" target="_blank" href="appointment_pdf.php?id=<?php echo (int)$a['id']; ?>">PDF</a></td>
        </tr>
      <?php endforeach; ?>
      <?php if (!$appointments): ?><tr><td colspan="8" class="text-center">Belum ada appointment.</td></tr><?php endif; ?>
    </tbody>
  </table>
</div>
<?php include __DIR__ . '/components/footer.php'; ?>