<?php
require 'includes/db.php';
require 'includes/auth.php';

if (!isLoggedIn() || !isAdmin()) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $stmt = $pdo->prepare("INSERT INTO users (email, password, role) VALUES (:email, :password, :role)");
    $stmt->execute(['email' => $email, 'password' => $password, 'role' => $role]);

    header('Location: admin.php');
    exit();
}
?>

<h2>Добавить пользователя</h2>

<form action="add_user.php" method="post">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required><br>

    <label for="password">Пароль:</label>
    <input type="password" name="password" id="password" required><br>

    <label for="role">Роль:</label>
    <select name="role" id="role">
        <option value="user">Пользователь</option>
        <option value="admin">Администратор</option>
    </select><br>

    <button type="submit">Добавить</button>
</form>