<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'includes/db.php';  
require 'includes/auth.php';  

if (isAuthenticated()) {
    header("Location: index.php");
    exit();
}

$stmt = $pdo->query("SELECT id, name FROM services");
$services = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (checkUserCredentials($email, $password)) {
        $_SESSION['user'] = getUserByEmail($email);
        header("Location: index.php"); 
        exit();
    } else {
        $error = "Неверные данные для входа";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>Вход</title>
</head>
<body>

    <?php if (isset($error)): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <div class="container">
    <h1>Окно авторизации</h1>
    <form action="login.php" method="post">
        <h1>Email:</h1>
        <input type="email" name="email" id="email" required><br>
        <h1>Пароль:</h1>
        <input type="password" name="password" id="password" required><br>
        <button type="submit">Войти</button>
    </form>
    <p>Нет аккаунта? <a href="register.php">Зарегистрироваться</a></p>
    </div>
</body>
</html>

<!-- <!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
<div class="container">
    <h2>Вход</h2>
    <form method="post">
        <input type="text" name="username" placeholder="Имя" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Войти</button>
        <a href="register.php" class="btn-primary banner__link">Регистрация</a>
    </form>
</div>
</body>
</html> -->