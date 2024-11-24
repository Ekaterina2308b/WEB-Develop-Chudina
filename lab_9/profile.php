<?php
session_start();
require 'includes/db.php';
require 'includes/auth.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$user_email = $_SESSION['user']['email'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$stmt->execute(['email' => $user_email]);
$user = $stmt->fetch();

if (!$user) {
    echo "Пользователь не найден";
    exit;
}
?>

<h2>Профиль пользователя</h2>

<p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
<p>Роль: <?php echo htmlspecialchars($user['role']); ?></p>

<a href="edit_profile.php">Редактировать профиль</a>
<a href="logout.php">Выйти</a>
