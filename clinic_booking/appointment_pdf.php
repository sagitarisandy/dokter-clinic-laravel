<?php
// Simple PDF generator for appointment confirmation (single page)
require_once __DIR__ . '/auth.php';
requireLogin();

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT a.*, u.name AS user_name FROM appointments a JOIN users u ON u.id = a.user_id WHERE a.id = ?');
$stmt->execute([$id]);
$ap = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$ap || (!isDoctor() && (int)$ap['user_id'] !== (int)currentUser()['id'])) {
    http_response_code(404);
    echo 'Appointment not found';
    exit;
}

function pdf_escape($s) {
    $s = str_replace(['\\','(',')'], ['\\\\','\\(','\\)'], $s);
    return $s;
}

$lines = [
    'Appointment Confirmation',
    '-------------------------',
    'Appointment ID: ' . $ap['id'],
    'Patient Name  : ' . $ap['full_name'],
    'Email         : ' . $ap['email'],
    'Phone         : ' . $ap['phone'],
    'Date          : ' . $ap['date'],
    'Time          : ' . $ap['time'],
    'Booked By     : ' . $ap['user_name'],
    'Notes         : ' . ($ap['notes'] ?: '-')
];

// Build content stream
$y = 780; $leading = 22; $content = "BT\n/F1 18 Tf\n";
foreach ($lines as $i => $line) {
    $fontSize = $i === 0 ? 24 : 12 + ($i===1?0:0);
    $content .= ($i === 0 ? "/F1 24 Tf\n" : "/F1 12 Tf\n");
    $content .= sprintf("1 0 0 1 72 %d Tm (%s) Tj\n", $y, pdf_escape($line));
    $y -= ($i === 0 ? 34 : $leading);
}
$content .= "ET\n";
$len = strlen($content);

// Objects
$obj1 = "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n";
$obj2 = "2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n";
$obj3 = "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Resources << /Font << /F1 4 0 R >> >> /Contents 5 0 R >>\nendobj\n";
$obj4 = "4 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n";
$obj5 = "5 0 obj\n<< /Length $len >>\nstream\n$content\nendstream\nendobj\n";

$header = "%PDF-1.4\n";
$body = $obj1 . $obj2 . $obj3 . $obj4 . $obj5;
$offsets = [];
$offsets[1] = strlen($header);
$offsets[2] = $offsets[1] + strlen($obj1);
$offsets[3] = $offsets[2] + strlen($obj2);
$offsets[4] = $offsets[3] + strlen($obj3);
$offsets[5] = $offsets[4] + strlen($obj4);

$xref = "xref\n0 6\n0000000000 65535 f \n";
for ($i=1; $i<=5; $i++) { $xref .= sprintf("%010d 00000 n \n", $offsets[$i]); }
$start = strlen($header.$body);
$trailer = "trailer\n<< /Size 6 /Root 1 0 R >>\nstartxref\n$start\n%%EOF";

$pdf = $header . $body . $xref . $trailer;

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="appointment-'.$ap['id'].'.pdf"');
echo $pdf;