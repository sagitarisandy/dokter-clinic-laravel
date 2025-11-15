<?php
require_once __DIR__ . '/auth.php';
requireLogin();

$token = $_GET['token'] ?? '';
if (!$token || !isset($_SESSION['payment_token']) || $token !== $_SESSION['payment_token'] || empty($_SESSION['pending_appointment'])) {
    header('Location: index.php');
    exit;
}
$ap = $_SESSION['pending_appointment'];

// Double-check availability
$check = $pdo->prepare('SELECT COUNT(*) FROM appointments WHERE date = ? AND time LIKE ? AND status = "paid"');
$check->execute([$ap['date'], substr($ap['time'],0,5).'%']);
if ($check->fetchColumn() > 0) {
    $_SESSION['form_error'] = 'Slot waktu barusan telah terisi. Silakan pilih slot lain.';
    unset($_SESSION['pending_appointment'], $_SESSION['payment_token']);
    header('Location: index.php#appointment');
    exit;
}

// Insert as PAID
$stmt = $pdo->prepare('INSERT INTO appointments (user_id, full_name, email, phone, date, time, notes, service_id, price, status) VALUES (?,?,?,?,?,?,?,?,?,"paid")');
$stmt->execute([
    $ap['user_id'], $ap['full_name'], $ap['email'], $ap['phone'], $ap['date'], $ap['time'], $ap['notes'], $ap['service_id'], $ap['price']
]);
$id = $pdo->lastInsertId();

unset($_SESSION['pending_appointment'], $_SESSION['payment_token']);
header('Location: user_dashboard.php?booked=' . urlencode($id));
