<?php
session_start();

function isLoggedIn() {
    return isset($_SESSION['user']);
}

function isAdmin() {
    return isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin';
}

function isAuthenticated() {
    return isset($_SESSION['user']);
}

function checkUserCredentials($email, $password) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && $password === $user['password']) {
        $_SESSION['user'] = [
            'role' => $user['role'],  
            'email' => $user['email'] 
        ];
        return true;
    }

    return false;
}

function getUserByEmail($email) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    return $stmt->fetch();
}
?>
