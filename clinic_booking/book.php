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

$errors = [];
if (!$full_name) $errors[] = 'Nama lengkap wajib diisi';
if (!$email) $errors[] = 'Email wajib diisi';
if (!$phone) $errors[] = 'Nomor telepon wajib diisi';
if (!$date) $errors[] = 'Tanggal wajib diisi';
if (!$time) $errors[] = 'Waktu wajib diisi';

if ($errors) {
    $_SESSION['form_error'] = implode(". ", $errors);
    header('Location: index.php#appointment');
    exit;
}

// Prevent double booking same hour
$check = $pdo->prepare('SELECT COUNT(*) FROM appointments WHERE date = ? AND time LIKE ?');
$check->execute([$date, substr($time,0,5).'%']);
if ($check->fetchColumn() > 0) {
    $_SESSION['form_error'] = 'Slot waktu sudah dibooking.';
    header('Location: index.php#appointment');
    exit;
}

$stmt = $pdo->prepare('INSERT INTO appointments (user_id, full_name, email, phone, date, time, notes) VALUES (?,?,?,?,?,?,?)');
$stmt->execute([ currentUser()['id'], $full_name, $email, $phone, $date, $time, $notes ]);
$appointmentId = $pdo->lastInsertId();

header('Location: user_dashboard.php?booked=' . urlencode($appointmentId));
