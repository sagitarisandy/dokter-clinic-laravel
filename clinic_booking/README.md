# Klinik Booking Monolith (PHP + SQLite)

Sistem sederhana untuk booking janji klinik gigi: registrasi user, login, membuat appointment, dashboard user & dokter, dan unduh PDF konfirmasi.

## Fitur
- Halaman utama dengan form "Make Appointment"
- Registrasi & Login user (session based)
- Booking appointment (nama lengkap, email, telepon, tanggal, waktu, catatan)
- Dashboard User: daftar appointment + unduh PDF konfirmasi
- Dashboard Dokter (email: `dokterclinic@mail.com`, password: `password`)
- Database SQLite tunggal `clinic.sqlite`
- Relasi foreign key `appointments.user_id -> users.id`
- PDF konfirmasi (generator sederhana tanpa library eksternal)
- Bootstrap via CDN + CSS ringan

## Struktur
```
clinic_booking/
  index.php
  login.php
  register.php
  logout.php
  book.php
  user_dashboard.php
  doctor_dashboard.php
  appointment_pdf.php
  database.php
  init_db.php
  auth.php
  components/ (header/footer)
  assets/style.css
  clinic.sqlite (dibuat otomatis saat pertama jalan)
```

## Cara Menjalankan
Pastikan PHP CLI tersedia.

1. Inisialisasi database (opsional, akan otomatis jika belum ada tabel):
```powershell
php .\clinic_booking\init_db.php
```
2. Jalankan server built-in:
```powershell
php -S localhost:8000 -t clinic_booking
```
3. Buka di browser: `http://localhost:8000/`

## Akun Dokter
- Email: `dokterclinic@mail.com`
- Password: `password`

## Catatan
- Contoh gambar diambil dari Unsplash (URL langsung). Ganti sesuai kebutuhan produksi.
- Sistem ini minimal: belum ada validasi lanjutan seperti pencegahan double-booking atau sanitasi catatan mendalam.
- Tambahkan HTTPS, CSRF token, dan rate limiting untuk produksi.

## Lisensi
Contoh kode bebas digunakan / dimodifikasi.
