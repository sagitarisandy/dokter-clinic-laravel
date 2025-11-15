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
    service_id INTEGER,
    price INTEGER DEFAULT 0,
    status TEXT NOT NULL DEFAULT "paid",
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
)');

// Add columns to appointments if DB already existed
$cols = $pdo->query("PRAGMA table_info(appointments)")->fetchAll(PDO::FETCH_ASSOC);
$names = array_column($cols, 'name');
if (!in_array('service_id', $names, true)) { $pdo->exec('ALTER TABLE appointments ADD COLUMN service_id INTEGER'); }
if (!in_array('price', $names, true)) { $pdo->exec('ALTER TABLE appointments ADD COLUMN price INTEGER DEFAULT 0'); }
if (!in_array('status', $names, true)) { $pdo->exec('ALTER TABLE appointments ADD COLUMN status TEXT NOT NULL DEFAULT "paid"'); }

// Services table
$pdo->exec('CREATE TABLE IF NOT EXISTS services (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    price INTEGER NOT NULL
)');

// Seed services if empty
$cnt = (int)$pdo->query('SELECT COUNT(*) FROM services')->fetchColumn();
if ($cnt === 0) {
    $pdo->exec("INSERT INTO services (name,price) VALUES
        ('Scaling', 200000),
        ('Teeth Cleaning', 150000),
        ('Whitening', 500000),
        ('Orthodontic Consultation', 100000)");
}

// Seed doctor
$stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE email = ?');
$stmt->execute(['dokterclinic@mail.com']);
if ($stmt->fetchColumn() == 0) {
    $pwd = password_hash('password', PASSWORD_DEFAULT);
    $insert = $pdo->prepare('INSERT INTO users (name,email,password,role) VALUES (?,?,?,?)');
    $insert->execute(['Dokter Klinik','dokterclinic@mail.com',$pwd,'doctor']);
}

if (PHP_SAPI === 'cli') {
    echo "Database initialized. You can now run the server.\n";
}