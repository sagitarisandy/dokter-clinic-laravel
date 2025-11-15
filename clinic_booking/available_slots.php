<?php
require_once __DIR__ . '/auth.php';
header('Content-Type: application/json');

$date = $_GET['date'] ?? '';
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
    echo json_encode(['error' => 'Invalid date']);
    exit;
}

$start = 8; // 08:00
$end = 17; // last slot ends at 17:00 -> last start 16:00
$slots = [];
for ($h=$start; $h<$end; $h++) {
    $slots[] = sprintf('%02d:00', $h);
}

$stmt = $pdo->prepare('SELECT time FROM appointments WHERE date = ? AND status = "paid"');
$stmt->execute([$date]);
$booked = array_column($stmt->fetchAll(PDO::FETCH_ASSOC),'time');
$booked = array_map(function($t){ return substr($t,0,5); }, $booked);

$result = [];
foreach ($slots as $t) {
    $result[] = [
        'time' => $t,
        'label' => $t . ' - ' . sprintf('%02d:00', (int)substr($t,0,2)+1),
        'available' => !in_array($t, $booked, true)
    ];
}

echo json_encode(['date'=>$date,'slots'=>$result]);