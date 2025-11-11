<?php
// init_db.php - Creates tables and seeds doctor user if not exists
require_once __DIR__ . '/database.php';

$pdo->exec('CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL,
    role TEXT NOT NULL DEFAULT "user",
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)');

$pdo->exec('CREATE TABLE IF NOT EXISTS appointments (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    full_name TEXT NOT NULL,
    email TEXT NOT NULL,
    phone TEXT NOT NULL,
    date TEXT NOT NULL,
    time TEXT NOT NULL,
    notes TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
)');

// Seed doctor
$stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE email = ?');
$stmt->execute(['dokterclinic@mail.com']);
if ($stmt->fetchColumn() == 0) {
    $pwd = password_hash('password', PASSWORD_DEFAULT);
    $insert = $pdo->prepare('INSERT INTO users (name,email,password,role) VALUES (?,?,?,?)');
    $insert->execute(['Dokter Klinik','dokterclinic@mail.com',$pwd,'doctor']);
}

echo "Database initialized. You can now run the server.\n";