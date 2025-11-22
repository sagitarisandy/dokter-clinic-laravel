<?php
require_once __DIR__ . '/auth.php';
include __DIR__ . '/components/header.php';
?>

<!-- Hero -->
<header class="hero-landing">
  <div class="container py-5 py-lg-6">
    <div class="row align-items-center g-4 py-4">
      <div class="col-lg-7">
        <div class="small text-white-50 heading-inverse">Family Dental Care</div>
        <h1 class="display-5 heading-inverse">Elevating Smiles with Expert Care and a Gentle Touch</h1>
        <p class="lead heading-inverse">Buat janji klinik gigi Anda secara online. Layanan profesional untuk senyum sehat semua usia.</p>
        <div class="hero-actions d-flex flex-wrap gap-2">
          <a class="btn btn-light" href="#appointment">Book Appointment</a>
          <a class="btn btn-outline-light" href="#services">Lihat Layanan</a>
        </div>
      </div>
    </div>
  </div>
</header>

<!-- Info strip -->
<div class="info-strip">
  <div class="container">
    <div class="row text-white text-center text-lg-start">
      <div class="col-12 col-lg-4"> <div class="col"><span>🆘</span> <span>Need Dental Services? +62 812 0000 0000</span></div></div>
      <div class="col-6 col-lg-4"> <div class="col"><span>⏰</span> <span>Opening Hours: 08.00–17.00</span></div></div>
      <div class="col-6 col-lg-4"> <div class="col"><span>✉️</span> <span>care@klinik.demo</span></div></div>
    </div>
  </div>
  </div>

<!-- About -->
<section id="about" class="section bg-white">
  <div class="container">
    <div class="row g-4 align-items-center">
      <div class="col-lg-6">
        <h2 class="section-title">Professionals and Personalized Dental Excellence</h2>
        <p class="subtitle">Tim dokter gigi ramah berpengalaman yang mengutamakan kenyamanan Anda.</p>
        <div class="row g-3 mt-3">
          <div class="col-6"><div class="card-tile"><div class="tile-icon">🪥</div><div class="fw-semibold">Care Plans</div><div class="small text-muted">Perawatan gigi rutin</div></div></div>
          <div class="col-6"><div class="card-tile"><div class="tile-icon">🦷</div><div class="fw-semibold">Modern Tech</div><div class="small text-muted">Teknologi mutakhir</div></div></div>
        </div>
      </div>
      <div class="col-lg-6 text-center">
  <img class="rounded shadow" style="max-width:420px;width:100%" src="../assets/smiling-woman-dentist-chair.jpg" alt="Pasien sedang perawatan gigi" loading="lazy">
      </div>
    </div>
  </div>
</section>

<!-- Services -->
<section id="services" class="section">
  <div class="container">
    <div class="text-center mb-4">
      <div class="subtitle">Our Services</div>
      <h2 class="section-title">Complete Care for Every Smile</h2>
    </div>
    <div class="row g-4 services-grid">
      <div class="col-6 col-md-3"><div class="card-tile text-center"><div class="tile-icon">🦷</div><div class="title">General Dentistry</div><div class="desc">Perawatan dasar</div></div></div>
      <div class="col-6 col-md-3"><div class="card-tile text-center"><div class="tile-icon">✨</div><div class="title">Cosmetic</div><div class="desc">Whitening & veneer</div></div></div>
      <div class="col-6 col-md-3"><div class="card-tile text-center"><div class="tile-icon">🪥</div><div class="title">Pediatric</div><div class="desc">Anak-anak</div></div></div>
      <div class="col-6 col-md-3"><div class="card-tile text-center"><div class="tile-icon">🧩</div><div class="title">Restorative</div><div class="desc">Tambal gigi</div></div></div>
    </div>
  </div>
</section>

<!-- KPIs -->
<div class="kpi-band py-4">
  <div class="container">
    <div class="row text-center">
      <div class="col-6 col-md-3"><div class="kpi-item"><div class="kpi-value">10000+</div><div class="kpi-label">Happy Patients</div></div></div>
      <div class="col-6 col-md-3"><div class="kpi-item"><div class="kpi-value">2500+</div><div class="kpi-label">Teeth Whitened</div></div></div>
      <div class="col-6 col-md-3"><div class="kpi-item"><div class="kpi-value">800+</div><div class="kpi-label">Dental Implants</div></div></div>
      <div class="col-6 col-md-3"><div class="kpi-item"><div class="kpi-value">15+</div><div class="kpi-label">Years Experience</div></div></div>
    </div>
  </div>
</div>

<!-- Team -->
<section id="team" class="section bg-white">
  <div class="container">
    <div class="text-center mb-4">
      <div class="subtitle">Meet Our Dental Team</div>
      <h2 class="section-title">Committed to Your Smile</h2>
    </div>
    <div class="row g-4 justify-content-center">
  <div class="col-md-4"><div class="team-card"><img class="w-100" src="../assets/doctor-1.jpg" alt="Dr. Sarah Bennett - Lead Dentist" loading="lazy"><div class="meta"><div class="name">Dr. Sarah Bennett</div><div class="role">Lead Dentist</div></div></div></div>
  <div class="col-md-4"><div class="team-card"><img class="w-100" src="../assets/doctor-2.jpg" alt="Dr. Maya Lin - Cosmetic Dentist" loading="lazy"><div class="meta"><div class="name">Dr. Maya Lin</div><div class="role">Cosmetic Dentist</div></div></div></div>
  <div class="col-md-4"><div class="team-card"><img class="w-100" src="../assets/doctor-3.jpg" alt="Dr. Michael Reyes - Prosthodontist" loading="lazy"><div class="meta"><div class="name">Dr. Michael Reyes</div><div class="role">Prosthodontist</div></div></div></div>
    </div>
  </div>
</section>

<!-- FAQ & Testimonials -->
<section id="faq" class="section">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-6">
        <h3 class="section-title">Frequently Asked Questions</h3>
        <div class="accordion faq" id="faqAcc">
          <div class="accordion-item">
            <h2 class="accordion-header" id="q1"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#a1">Apa yang harus dibawa?</button></h2>
            <div id="a1" class="accordion-collapse collapse show" data-bs-parent="#faqAcc"><div class="accordion-body">Bawa identitas dan riwayat medis ringkas bila ada. Datang 10 menit lebih awal.</div></div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="q2"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a2">Bisakah ubah jadwal?</button></h2>
            <div id="a2" class="accordion-collapse collapse" data-bs-parent="#faqAcc"><div class="accordion-body">Tentu. Hubungi kami minimal H-1 untuk mengubah jadwal.</div></div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="q3"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a3">Apakah menerima anak-anak?</button></h2>
            <div id="a3" class="accordion-collapse collapse" data-bs-parent="#faqAcc"><div class="accordion-body">Ya, kami melayani pasien anak dengan pendekatan ramah.</div></div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <h3 class="section-title">Our Happy Customers</h3>
        <div class="row g-3">
          <div class="col-12"><div class="testimonial"><div class="quote">“Pelayanan ramah dan cepat. Rasa takut ke dokter gigi jadi hilang.”</div><div class="small text-muted mt-2">— Rina</div></div></div>
          <div class="col-12"><div class="testimonial"><div class="quote">“Hasil whitening memuaskan dan penjelasan dokter sangat jelas.”</div><div class="small text-muted mt-2">— Mardial</div></div></div>
          <div class="col-12"><div class="testimonial"><div class="quote">“Tempat bersih, anak saya betah selama tindakan.”</div><div class="small text-muted mt-2">— Robert</div></div></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Appointment -->
<section id="appointment" class="section bg-soft">
  <div class="container">
    <div class="text-center mb-4">
      <h2 class="section-title color-black">Make an Appointment</h2>
      <p class="subtitle">Login untuk memesan jadwal dan pilih layanan yang tersedia.</p>
    </div>
    <?php if (!currentUser()): ?>
      <div class="cta text-center">
        <p class="mb-2">Silakan <a href="login.php">login</a> atau <a href="register.php">registrasi</a> untuk membuat appointment.</p>
        <a class="btn btn-primary" href="login.php">Login untuk Melanjutkan</a>
      </div>
    <?php else: ?>
      <?php if (!empty($_SESSION['form_error'])): ?><div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['form_error']); unset($_SESSION['form_error']); ?></div><?php endif; ?>
      <form class="row g-3 booking-form" method="post" action="book.php">
        <div class="col-md-6"><label class="form-label">Nama Lengkap</label><input name="full_name" class="form-control" required></div>
        <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" value="<?php echo htmlspecialchars(currentUser()['email']); ?>" class="form-control" required></div>
        <div class="col-md-6"><label class="form-label">Nomor Telepon</label><input name="phone" class="form-control" required></div>
        <div class="col-md-3"><label class="form-label">Tanggal</label><input type="date" id="ap-date" name="date" class="form-control" required></div>
        <div class="col-md-3"><label class="form-label">Waktu (1 jam)</label>
          <div id="slot-container" class="d-grid gap-2 small">
            <div class="text-muted">Pilih tanggal terlebih dahulu.</div>
          </div>
        </div>
        <div class="col-md-6"><label class="form-label">Layanan</label>
          <select name="service_id" id="service-select" class="form-select" required>
            <option value="">Memuat layanan...</option>
          </select>
        </div>
        <div class="col-12"><label class="form-label">Catatan</label><textarea name="notes" class="form-control" rows="3" placeholder="Keluhan singkat..."></textarea></div>
        <div class="col-12"><button class="btn btn-success btn-lg">Booking Sekarang</button></div>
      </form>
      <script>
      const dateInput = document.getElementById('ap-date');
      const container = document.getElementById('slot-container');
      const serviceSelect = document.getElementById('service-select');
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

      async function loadServices(){
        try {
          const res = await fetch('services.php');
          const json = await res.json();
          serviceSelect.innerHTML = '<option value="">-- Pilih Layanan --</option>';
          json.services.forEach(s=>{
            const opt = document.createElement('option');
            opt.value = s.id;
            opt.textContent = s.name + ' (Rp ' + new Intl.NumberFormat('id-ID').format(s.price) + ')';
            serviceSelect.appendChild(opt);
          });
        } catch(e) {
          serviceSelect.innerHTML = '<option value="">Gagal memuat layanan</option>';
        }
      }
      loadServices();
      </script>
    <?php endif; ?>
  </div>
</section>

<?php include __DIR__ . '/components/footer.php'; ?>