<?php
// auth.php - session + helpers
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/database.php';

function currentUser() {
    return $_SESSION['user'] ?? null;
}

function requireLogin() {
    if (!currentUser()) {
        header('Location: login.php');
        exit;
    }
}

function isDoctor() {
    return currentUser() && currentUser()['role'] === 'doctor';
}

function login($email, $password) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user; // store whole row (safe enough for demo)
        return true;
    }
    return false;
}

function logout() {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time()-42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();
}
