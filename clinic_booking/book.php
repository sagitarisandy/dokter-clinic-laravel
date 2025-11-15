<?php
require_once __DIR__ . '/auth.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$full_name = trim($_POST['full_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$date = trim($_POST['date'] ?? '');
$time = trim($_POST['time'] ?? '');
$notes = trim($_POST['notes'] ?? '');
$service_id = (int)($_POST['service_id'] ?? 0);

$errors = [];
if (!$full_name) $errors[] = 'Nama lengkap wajib diisi';
if (!$email) $errors[] = 'Email wajib diisi';
if (!$phone) $errors[] = 'Nomor telepon wajib diisi';
if (!$date) $errors[] = 'Tanggal wajib diisi';
if (!$time) $errors[] = 'Waktu wajib diisi';

if (!$service_id) $errors[] = 'Pilih layanan';
if ($errors) {
    $_SESSION['form_error'] = implode(". ", $errors);
    header('Location: index.php#appointment');
    exit;
}

// Fetch service
$s = $pdo->prepare('SELECT * FROM services WHERE id = ?');
$s->execute([$service_id]);
$service = $s->fetch(PDO::FETCH_ASSOC);
if (!$service) {
    $_SESSION['form_error'] = 'Layanan tidak ditemukan';
    header('Location: index.php#appointment');
    exit;
}

// Prevent double booking same hour among paid appointments
$check = $pdo->prepare('SELECT COUNT(*) FROM appointments WHERE date = ? AND time LIKE ? AND status = "paid"');
$check->execute([$date, substr($time,0,5).'%']);
if ($check->fetchColumn() > 0) {
    $_SESSION['form_error'] = 'Slot waktu sudah dibooking.';
    header('Location: index.php#appointment');
    exit;
}

// Store pending appointment in session and redirect to payment page
$_SESSION['pending_appointment'] = [
    'user_id' => currentUser()['id'],
    'full_name' => $full_name,
    'email' => $email,
    'phone' => $phone,
    'date' => $date,
    'time' => substr($time,0,5),
    'notes' => $notes,
    'service_id' => $service['id'],
    'service_name' => $service['name'],
    'price' => (int)$service['price']
];
$_SESSION['payment_token'] = bin2hex(random_bytes(8));

header('Location: pay.php?token=' . urlencode($_SESSION['payment_token']));
