<?php
require_once __DIR__ . '/auth.php';
header('Content-Type: application/json');
$rows = $pdo->query('SELECT id, name, price FROM services ORDER BY id')->fetchAll(PDO::FETCH_ASSOC);
echo json_encode(['services'=>$rows]);