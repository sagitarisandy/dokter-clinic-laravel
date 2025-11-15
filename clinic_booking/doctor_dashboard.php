<?php
require_once __DIR__ . '/auth.php';
requireLogin();
if (!isDoctor()) { header('Location: index.php'); exit; }
include __DIR__ . '/components/header.php';

$stmt = $pdo->query('SELECT a.*, u.name AS user_name, s.name AS service_name FROM appointments a JOIN users u ON u.id = a.user_id LEFT JOIN services s ON s.id = a.service_id ORDER BY a.date ASC, a.time ASC');
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container py-5">
  <h2 class="mb-4">Dashboard Dokter</h2>
  <p>Semua jadwal appointment dari pasien.</p>
  <div class="row mb-4">
    <div class="col-md-4">
      <label class="form-label">Filter Tanggal</label>
      <input type="date" id="filter-date" class="form-control" />
    </div>
    <div class="col-md-4">
      <label class="form-label">Filter Status</label>
      <select id="filter-status" class="form-select">
        <option value="">Semua</option>
        <option value="paid">Paid</option>
      </select>
    </div>
    <div class="col-md-4">
      <label class="form-label">Filter Layanan</label>
      <select id="filter-service" class="form-select">
        <option value="">Semua</option>
      </select>
    </div>
    <div class="col-md-4 mt-3">
      <label class="form-label">Filter Waktu</label>
      <select id="filter-time" class="form-select">
        <option value="">Semua</option>
        <option>08:00</option>
        <option>09:00</option>
        <option>10:00</option>
        <option>11:00</option>
        <option>12:00</option>
        <option>13:00</option>
        <option>14:00</option>
        <option>15:00</option>
        <option>16:00</option>
      </select>
    </div>
  </div>
  <div class="mb-5">
    <canvas id="chartDaily" height="140"></canvas>
  </div>
  <table class="table table-hover" id="appt-table">
    <thead><tr><th>ID</th><th>Tanggal</th><th>Waktu</th><th>Layanan</th><th>Harga</th><th>Pasien</th><th>Kontak</th><th>Dibuat oleh</th><th>Status</th><th>Catatan</th></tr></thead>
    <tbody>
      <?php foreach ($appointments as $a): ?>
        <tr>
          <td><?php echo (int)$a['id']; ?></td>
          <td><?php echo htmlspecialchars($a['date']); ?></td>
          <td><?php echo htmlspecialchars($a['time']); ?></td>
          <td><?php echo htmlspecialchars($a['service_name'] ?? '-'); ?></td>
          <td>Rp <?php echo number_format((int)$a['price'],0,',','.'); ?></td>
          <td><?php echo htmlspecialchars($a['full_name']); ?></td>
          <td><?php echo htmlspecialchars($a['email']); ?><br><?php echo htmlspecialchars($a['phone']); ?></td>
          <td><?php echo htmlspecialchars($a['user_name']); ?></td>
          <td><span class="badge bg-<?php echo $a['status']==='paid'?'success':'secondary'; ?>"><?php echo htmlspecialchars($a['status']); ?></span></td>
          <td><?php echo htmlspecialchars($a['notes']); ?></td>
        </tr>
      <?php endforeach; ?>
      <?php if (!$appointments): ?><tr><td colspan="7" class="text-center">Belum ada appointment.</td></tr><?php endif; ?>
    </tbody>
  </table>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
const originalRows = [...document.querySelectorAll('#appt-table tbody tr')];
const serviceSelect = document.getElementById('filter-service');
// Build service options from table content
const serviceSet = new Set();
originalRows.forEach(r=>{ const s = r.children[3].textContent.trim(); if(s) serviceSet.add(s); });
serviceSet.forEach(s=>{ const opt=document.createElement('option'); opt.value=s; opt.textContent=s; serviceSelect.appendChild(opt); });

function applyFilter(){
  const d = document.getElementById('filter-date').value;
  const st = document.getElementById('filter-status').value;
  const sv = document.getElementById('filter-service').value;
  const tm = document.getElementById('filter-time').value;
  originalRows.forEach(r=>{
    const date = r.children[1].textContent.trim();
    const time = r.children[2].textContent.trim();
    const status = r.children[7].textContent.trim();
    const service = r.children[3].textContent.trim();
    let show = true;
    if (d && date !== d) show = false;
    if (st && status !== st) show = false;
    if (sv && service !== sv) show = false;
    if (tm && time !== tm) show = false;
    r.style.display = show ? '' : 'none';
  });
}
['filter-date','filter-status','filter-service','filter-time'].forEach(id=>document.getElementById(id).addEventListener('change',applyFilter));

// Chart: appointments per date (paid only)
const counts = {};
originalRows.forEach(r=>{ const status = r.children[8].textContent.trim(); if(status==='paid'){ const date=r.children[1].textContent.trim(); counts[date]=(counts[date]||0)+1; }});
const labels = Object.keys(counts).sort();
const dataVals = labels.map(l=>counts[l]);
new Chart(document.getElementById('chartDaily'),{
  type:'bar',
  data:{labels, datasets:[{label:'Jumlah Appointment (Paid)', data:dataVals, backgroundColor:'#0d6efd'}]},
  options:{plugins:{legend:{display:true}},scales:{y:{beginAtZero:true, ticks:{precision:0}}}}
});
</script>
</div>
<?php include __DIR__ . '/components/footer.php'; ?>