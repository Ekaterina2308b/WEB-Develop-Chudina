<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'includes/auth.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Музыкальный портал</title>
    <link rel="stylesheet" href="css/album.css">
</head>
<body>
<div class="layout">
    <div class="menu">
        <h1>Альбомы</h1>
        <a href="index.php">Главная страница</a>
        <a href="yandex.php">Рекомендации музыки в Yandex</a>
        <a href="vk.php">Рекомендации музыки в VK</a>
        <?php if (isAdmin()): ?>
            <a href="admin.php" class="admin-btn">Панель администратора</a>
        <?php else: ?>
            <a href="profile.php" class="user-btn">Панель пользователя</a>
        <?php endif; ?>
        <div class="logout">
            <a href="logout.php" class="btn logout-btn">Выйти из аккаунта</a>
        </div>
    </div>

    <div class="cards-block">
        <div class="cards-container">
            <div class="card" style="background-image: url('img/tdd.jpg');">
                <div class="card-body">
                    <h3>Три Дня Дождя</h3>
                </div>
            </div>
            <div class="card" style="background-image: url('img/klava.jpg');">
                <div class="card-body">
                    <h3>Клава Кока</h3>
                </div>
            </div>
            <div class="card" style="background-image: url('img/egorkreed.jpg');">
                <div class="card-body">
                    <h3>Егор Крид</h3>
                </div>
            </div>
            <div class="card" style="background-image: url('img/annaasti.jpg');">
                <div class="card-body">
                    <h3>Анна Асти</h3>
                </div>
            </div>
        </div>

        <div class="cards-container">
            <div class="card" style="background-image: url('img/tdd.jpg');">
                <div class="card-body">
                    <h3>Три Дня Дождя</h3>
                </div>
            </div>
            <div class="card" style="background-image: url('img/klava.jpg');">
                <div class="card-body">
                    <h3>Клава Кока</h3>
                </div>
            </div>
            <div class="card" style="background-image: url('img/egorkreed.jpg');">
                <div class="card-body">
                    <h3>Егор Крид</h3>
                </div>
            </div>
            <div class="card" style="background-image: url('img/annaasti.jpg');">
                <div class="card-body">
                    <h3>Анна Асти</h3>
                </div>
            </div>
        </div>

        <div class="cards-container">
            <div class="card" style="background-image: url('img/tdd.jpg');">
                <div class="card-body">
                    <h3>Три Дня Дождя</h3>
                </div>
            </div>
            <div class="card" style="background-image: url('img/klava.jpg');">
                <div class="card-body">
                    <h3>Клава Кока</h3>
                </div>
            </div>
            <div class="card" style="background-image: url('img/egorkreed.jpg');">
                <div class="card-body">
                    <h3>Егор Крид</h3>
                </div>
            </div>
            <div class="card" style="background-image: url('img/annaasti.jpg');">
                <div class="card-body">
                    <h3>Анна Асти</h3>
                </div>
            </div>
        </div>
    </div>

    
</div>
</body>
</html>
