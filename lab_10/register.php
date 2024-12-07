<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'includes/db.php'; 
require 'includes/auth.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Пароли не совпадают";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user) {
            $error = "Пользователь с таким email уже существует";
        } else {
            $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
            $stmt->execute(['email' => $email, 'password' => $password]);
            
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            $_SESSION['user'] = [
                'email' => $email,
                'role' => $user['role'] 
            ];

            header("Location: index.php");  
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
</head>
<body>
    <h2>Регистрация</h2>

    <?php if (isset($error)): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="register.php" method="post">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br>

        <label for="password">Пароль:</label>
        <input type="password" name="password" id="password" required><br>

        <label for="confirm_password">Подтверждение пароля:</label>
        <input type="password" name="confirm_password" id="confirm_password" required><br>

        <button type="submit">Зарегистрироваться</button>
    </form>

    <p>Уже есть аккаунт? <a href="login.php">Войти</a></p>
</body>
</html>
