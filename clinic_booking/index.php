<?php
require_once __DIR__ . '/auth.php';
include __DIR__ . '/components/header.php';
?>
<header class="bg-light border-bottom">
  <div class="container py-5 d-lg-flex align-items-center">
    <div class="flex-grow-1 pe-lg-5">
      <h1 class="display-5 fw-bold">Beautiful natural smiles</h1>
      <p class="lead">A perfect smile guaranteed. Buat janji kunjungan klinik gigi Anda dengan mudah.</p>
      <a class="btn btn-primary btn-lg" href="#appointment">Make Appointment</a>
    </div>
    <div class="text-center mt-4 mt-lg-0">
      <img class="rounded shadow" style="max-width:380px;width:100%;" src="https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?q=80&w=800&auto=format&fit=crop" alt="Smile">
    </div>
  </div>
</header>
<section id="features" class="py-5 bg-white">
  <div class="container">
    <div class="row g-4 text-center">
      <div class="col-6 col-md-3"><div class="p-3 border rounded"><div class="fs-1">🧑‍⚕️</div><div class="fw-semibold">Certified Dentists</div></div></div>
      <div class="col-6 col-md-3"><div class="p-3 border rounded"><div class="fs-1">🪥</div><div class="fw-semibold">Teeth Cleaning</div></div></div>
      <div class="col-6 col-md-3"><div class="p-3 border rounded"><div class="fs-1">✨</div><div class="fw-semibold">Teeth Whitening</div></div></div>
      <div class="col-6 col-md-3"><div class="p-3 border rounded"><div class="fs-1">🦷</div><div class="fw-semibold">Quality Brackets</div></div></div>
    </div>
  </div>
</section>
<section id="appointment" class="py-5 bg-light">
  <div class="container">
    <h2 class="mb-4">Make an Appointment</h2>
    <?php if (!currentUser()): ?>
      <div class="alert alert-info">Silakan <a href="login.php">login</a> atau <a href="register.php">registrasi</a> untuk membuat appointment.</div>
    <?php else: ?>
      <?php if (!empty($_SESSION['form_error'])): ?><div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['form_error']); unset($_SESSION['form_error']); ?></div><?php endif; ?>
      <form class="row g-3" method="post" action="book.php">
        <div class="col-md-6"><label class="form-label">Nama Lengkap</label><input name="full_name" class="form-control" required></div>
        <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" value="<?php echo htmlspecialchars(currentUser()['email']); ?>" class="form-control" required></div>
        <div class="col-md-6"><label class="form-label">Nomor Telepon</label><input name="phone" class="form-control" required></div>
        <div class="col-md-3"><label class="form-label">Tanggal</label><input type="date" id="ap-date" name="date" class="form-control" required></div>
        <div class="col-md-3"><label class="form-label">Waktu (1 jam)</label>
          <div id="slot-container" class="d-grid gap-2 small">
            <div class="text-muted">Pilih tanggal terlebih dahulu.</div>
          </div>
        </div>
        <div class="col-12"><label class="form-label">Catatan</label><textarea name="notes" class="form-control" rows="3" placeholder="Keluhan singkat..."></textarea></div>
        <div class="col-12"><button class="btn btn-success btn-lg">Booking Sekarang</button></div>
      </form>
      <script>
      const dateInput = document.getElementById('ap-date');
      const container = document.getElementById('slot-container');
      function renderSlots(data){
        container.innerHTML = '';
        if (!data || !data.slots){ container.textContent = 'Tidak ada slot.'; return; }
        const row = document.createElement('div');
        row.className = 'd-flex flex-wrap gap-2';
        data.slots.forEach((s,idx)=>{
          const id = 'slot-'+s.time.replace(':','');
          const input = Object.assign(document.createElement('input'),{type:'radio',name:'time',id:id,value:s.time,required:true});
          input.className = 'btn-check';
          if (!s.available) input.disabled = true;
          const label = document.createElement('label');
          label.className = 'btn btn-sm '+(s.available?'btn-outline-primary':'btn-outline-secondary disabled');
          label.setAttribute('for',id);
          label.textContent = s.label;
          row.appendChild(input);
          row.appendChild(label);
        });
        container.appendChild(row);
      }
      async function loadSlots(){
        const d = dateInput.value;
        if (!d){ container.innerHTML = '<div class="text-muted">Pilih tanggal terlebih dahulu.</div>'; return; }
        container.innerHTML = '<div class="text-muted">Memuat slot...</div>';
        try{
          const res = await fetch('available_slots.php?date='+encodeURIComponent(d));
          const json = await res.json();
          renderSlots(json);
        }catch(e){ container.textContent = 'Gagal memuat slot'; }
      }
      dateInput.addEventListener('change', loadSlots);
      </script>
    <?php endif; ?>
  </div>
</section>
<?php include __DIR__ . '/components/footer.php'; ?>