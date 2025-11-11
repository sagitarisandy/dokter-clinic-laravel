<?php
// database.php - SQLite connection helper
$DB_FILE = __DIR__ . '/clinic.sqlite';
try {
    $pdo = new PDO('sqlite:' . $DB_FILE);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('PRAGMA foreign_keys = ON');
} catch (Exception $e) {
    die('Database connection failed: ' . htmlspecialchars($e->getMessage()));
}
