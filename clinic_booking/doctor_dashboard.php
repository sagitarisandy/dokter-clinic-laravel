<?php
require_once __DIR__ . '/auth.php';
requireLogin();
if (!isDoctor()) { header('Location: index.php'); exit; }
include __DIR__ . '/components/header.php';

$stmt = $pdo->query('SELECT a.*, u.name AS user_name FROM appointments a JOIN users u ON u.id = a.user_id ORDER BY a.date ASC, a.time ASC');
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container py-5">
  <h2 class="mb-4">Dashboard Dokter</h2>
  <p>Semua jadwal appointment dari pasien.</p>
  <table class="table table-hover">
    <thead><tr><th>ID</th><th>Tanggal</th><th>Waktu</th><th>Pasien</th><th>Kontak</th><th>Dibuat oleh</th><th>Catatan</th></tr></thead>
    <tbody>
      <?php foreach ($appointments as $a): ?>
        <tr>
          <td><?php echo (int)$a['id']; ?></td>
          <td><?php echo htmlspecialchars($a['date']); ?></td>
          <td><?php echo htmlspecialchars($a['time']); ?></td>
          <td><?php echo htmlspecialchars($a['full_name']); ?></td>
          <td><?php echo htmlspecialchars($a['email']); ?><br><?php echo htmlspecialchars($a['phone']); ?></td>
          <td><?php echo htmlspecialchars($a['user_name']); ?></td>
          <td><?php echo htmlspecialchars($a['notes']); ?></td>
        </tr>
      <?php endforeach; ?>
      <?php if (!$appointments): ?><tr><td colspan="7" class="text-center">Belum ada appointment.</td></tr><?php endif; ?>
    </tbody>
  </table>
</div>
<?php include __DIR__ . '/components/footer.php'; ?>