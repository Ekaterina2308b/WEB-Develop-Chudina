<?php
require 'includes/db.php';
require 'includes/auth.php';

if (!isLoggedIn() || !isAdmin()) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];

    $stmt = $pdo->prepare("INSERT INTO services (name) VALUES (:name)");
    $stmt->execute(['name' => $name]);

    header('Location: admin.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Музыкальный портал</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
<div class="layout">
    <div class="menu">
        <h1>Добавление услуги</h1>
        <?php if (isAdmin()): ?>
            <a href="admin.php">Панель администратора</a>
        <?php else: ?>
            <a href="profile.php">Панель пользователя</a>
        <?php endif; ?>
        <div class="logout">
            <a href="logout.php">Выйти из аккаунта</a>
        </div>
    </div>

<form class="menu_user" action="add_services.php" method="post">
    <label for="name">Название услуги:</label>
    <input type="name" name="name" id="name" required><br>
    <button type="submit">Добавить</button>
</form>

</div>
</body>
</html>