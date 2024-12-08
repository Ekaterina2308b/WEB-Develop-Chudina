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
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
<div class="layout">
    <div class="menu">
        <h1>Артисты</h1>
        <a href="index.php">Главная страница</a>
        <a href="clips.php">Популярные клипы</a>
        <a href="album.php">Альбомы</a>
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
            <div class="card" style="background-image: url('https://images.genius.com/6a1be4cad9ae449d180faaf441db0643.614x614x1.jpg');">
                <a href="https://genius.com/artists/Tdd" target="_blank">
                <div class="card-body">
                    <h3>Три Дня Дождя</h3>
                </div>
                </a>
            </div>
            <div class="card" style="background-image: url('https://images.genius.com/09be92b8cac43055bf20c3ac5c910d88.1000x1000x1.jpg');">
                <a href="https://genius.com/artists/Klava-coca" target="_blank">
                <div class="card-body">
                    <h3>Клава Кока</h3>
                </div>
                </a>
            </div>
            <div class="card" style="background-image: url('https://images.genius.com/20ca7e30cbeee62546bcdee319368f4d.800x800x1.jpg');">
                <a href="https://genius.com/artists/Egor-kreed" target="_blank">
                <div class="card-body">
                    <h3>Егор Крид</h3>
                </div>
                </a>
            </div>
            <div class="card" style="background-image: url('https://images.genius.com/b9d653e5c694c2f5d76fa6caf006f2a9.1000x1000x1.jpg');">
                <a href="https://genius.com/artists/Anna-asti" target="_blank">
                <div class="card-body">
                    <h3>Анна Асти</h3>
                </div>
                </a>
            </div>
        </div>

        <div class="cards-container">
            <div class="card" style="background-image: url('https://images.genius.com/dfe1652d83589d9d7b39b996c1dfc2ea.1000x1000x1.jpg');">
                <a href="https://genius.com/artists/Geegun" target="_blank">
                <div class="card-body">
                    <h3>Джиган</h3>
                </div>
                </a>
            </div>

            <div class="card" style="background-image: url('https://images.genius.com/9c0f540ae52f21de3dfaa40453dba836.750x750x1.jpg');">
                <a href="https://genius.com/artists/Timati" target="_blank">
                <div class="card-body">
                    <h3>Тимати</h3>
                </div>
                </a>
            </div>

            <div class="card" style="background-image: url('https://images.genius.com/d4907184d0bec2baf1009d0b615b313c.1000x1000x1.jpg');">
                <a href="https://genius.com/artists/Shaman" target="_blank">
                <div class="card-body">
                    <h3>Шаман</h3>
                </div>
                </a>
            </div>

            <div class="card" style="background-image: url('https://images.genius.com/988914a6e5bc0a28a9f814e97470e2a0.612x612x1.jpg');">
                <a href="https://genius.com/artists/Macan" target="_blank">
                <div class="card-body">
                    <h3>Macan</h3>
                </div>
                </a>
            </div>
        </div>
    </div>

    
</div>
</body>
</html>
