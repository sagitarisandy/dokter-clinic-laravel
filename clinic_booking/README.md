# Klinik Booking Monolith (PHP + SQLite)

Sistem sederhana untuk booking janji klinik gigi. Fitur: registrasi & login user, pembuatan appointment dengan slot per jam, dashboard user & dokter, dan unduh PDF konfirmasi (tanpa library tambahan). Dirancang agar langsung jalan memakai server built-in PHP.

## 1. Prasyarat
Pastikan terpasang:
- PHP 8.x CLI (disarankan) dengan ekstensi `pdo_sqlite` aktif.
- Browser modern (Chrome/Firefox/Edge).
Tidak diperlukan Composer, web server (Apache/Nginx), atau framework tambahan.

## 2. Kloning / Salin Proyek
Letakkan folder `clinic_booking` di dalam workspace Anda (sudah dilakukan jika Anda membaca ini di repo yang sama).

## 3. Struktur Direktori
```
clinic_booking/
  auth.php                # Helper session & login
  available_slots.php     # Endpoint JSON daftar slot per jam
  appointment_pdf.php     # Generator PDF sederhana
  book.php                # Proses submit booking
  components/
    header.php            # Navbar & bootstrap
    footer.php            # Footer + script bootstrap
  database.php            # Koneksi PDO SQLite
  doctor_dashboard.php    # Dashboard dokter (semua appointment)
  index.php               # Landing page + form booking
  init_db.php             # Inisialisasi tabel & seed akun dokter
  login.php               # Form login
  logout.php              # Logout session
  register.php            # Form registrasi user baru
  user_dashboard.php      # Daftar appointment milik user
  assets/
    style.css             # CSS tambahan
  clinic.sqlite           # File database (dibuat otomatis saat pertama akses)
```

## 4. Inisialisasi Database (Opsional)
Secara otomatis tabel akan dibuat jika belum ada saat pertama kali halaman diakses. Jika ingin manual:
```powershell
php .\clinic_booking\init_db.php
```
Output: `Database initialized.`

Seed otomatis memasukkan akun dokter:
- Email: `dokterclinic@mail.com`
- Password: `password`

## 5. Menjalankan Aplikasi
Jalankan server built-in PHP dari root workspace (bukan di dalam folder itu sendiri jika -t dipakai):
```powershell
php -S localhost:8000 -t clinic_booking
```
Buka: http://localhost:8000/

## 6. Alur Penggunaan
1. Buka halaman utama (`index.php`).
2. Registrasi user baru melalui link "Registrasi".
3. Login sebagai user.
4. Pilih tanggal, slot waktu (per jam mulai 08:00–16:00 start). Slot yang sudah dibooking akan disabled.
5. Isi data dan klik "Booking Sekarang".
6. Redirect ke Dashboard User menampilkan appointment baru + link PDF.
7. Unduh PDF konfirmasi (single page). Dokter dapat login untuk melihat semua jadwal.

## 7. Endpoint / Halaman Penting
| Path | Metode | Deskripsi |
|------|--------|-----------|
| `/index.php` | GET | Landing + form booking (login diperlukan untuk submit) |
| `/register.php` | GET/POST | Registrasi user baru |
| `/login.php` | GET/POST | Login (user atau dokter) |
| `/logout.php` | GET | Logout session |
| `/book.php` | POST | Simpan appointment baru (validasi slot unik) |
| `/available_slots.php?date=YYYY-MM-DD` | GET (JSON) | Daftar slot per jam + status tersedia |
| `/user_dashboard.php` | GET | Daftar appointment user login |
| `/doctor_dashboard.php` | GET | Daftar semua appointment (hanya role dokter) |
| `/appointment_pdf.php?id=ID` | GET | Unduh PDF konfirmasi appointment |

## 8. Format Data Appointment
Kolom: `id`, `user_id`, `full_name`, `email`, `phone`, `date` (YYYY-MM-DD), `time` (HH:MM), `notes`, `created_at`.
Satu slot (misal 08:00) merepresentasikan jam 08:00–09:00.

## 9. Customisasi Slot Waktu
Ubah rentang jam di `available_slots.php`:
```php
$start = 8; // jam mulai
$end = 17; // jam terakhir (slot terakhir mulai 16:00)
```
Tambahkan interval 30 menit? Ganti loop menjadi per 30 menit dan penyesuaian label serta validasi di `book.php`.

## 10. PDF Konfirmasi
Dibuat manual tanpa library (Type1 Helvetica). Jika ingin styling lebih kaya, bisa integrasi library seperti `FPDF` atau `TCPDF` (tambahkan file/library lalu ubah `appointment_pdf.php`).

## 11. Keamanan & Peningkatan yang Disarankan
- Tambahkan CSRF token pada form (saat ini belum ada).
- Batasi panjang `notes` & lakukan sanitasi tambahan (HTML saat ini di-escape).
- Cegah brute force login (rate limiting / delay).
- Implementasi verifikasi email user (opsional).
- Validasi agar user tidak bisa booking tanggal lampau.
- Tambahkan fitur pembatalan appointment + status (pending / confirmed / canceled).

## 12. Backup Database
File SQLite: `clinic_booking/clinic.sqlite`
Backup cukup salin file tersebut. Pastikan server tidak menulis saat proses backup (atau lakukan copy cepat ketika idle).

## 13. Contoh Cek Slot (curl)
```powershell
curl http://localhost:8000/available_slots.php?date=2025-11-11
```
Response JSON berisi array `slots` dengan `time`, `label`, `available`.

## 14. Troubleshooting
| Masalah | Penyebab Umum | Solusi |
|---------|---------------|--------|
| Gagal koneksi DB | File tidak bisa dibuat | Pastikan hak tulis folder `clinic_booking` |
| Slot tetap muncul available padahal sudah booking | Cache browser | Refresh pakai Ctrl+F5 / cek request JSON |
| PDF kosong / error | Output terpotong | Pastikan tidak ada spasi / echo sebelum header di `appointment_pdf.php` |
| Tidak bisa login dokter | Seed belum jalan | Jalankan `init_db.php` manual |

## 15. Lisensi
Contoh kode bebas digunakan / dimodifikasi untuk kebutuhan belajar / internal.

---
Selamat mencoba! Silakan kembangkan lebih lanjut sesuai kebutuhan klinik Anda.
