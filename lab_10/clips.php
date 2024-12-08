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
        <h1>Популярные клипы</h1>
        <a href="index.php">Главная страница</a>
        <a href="artist.php">Артисты</a>
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
            <div class="card" style="background-image: url('https://img.youtube.com/vi/sfd2xj9xtN0/hqdefault.jpg');">
            <a href="https://youtu.be/sfd2xj9xtN0" target="_blank">
            <div class="card-body"></div></a>
            </div>

            <div class="card" style="background-image: url('https://img.youtube.com/vi/UwxTUXB8peI/hqdefault.jpg');">
                <a href="https://youtu.be/UwxTUXB8peI" target="_blank">
                <div class="card-body"></div></a>
            </div>

            <div class="card" style="background-image: url('https://img.youtube.com/vi/ZOI8ib7k4Ic/hqdefault.jpg');">
                <a href="https://youtu.be/ZOI8ib7k4Ic" target="_blank">
                <div class="card-body"></div></a>
            </div>

            <div class="card" style="background-image: url('https://img.youtube.com/vi/nidQCt_HEsY/hqdefault.jpg');">
                <a href="https://youtu.be/nidQCt_HEsY" target="_blank">
                <div class="card-body"></div></a>
            </div>
        </div>

        <div class="cards-container">
            <div class="card" style="background-image: url('https://img.youtube.com/vi/i9AHJkHqkpw/hqdefault.jpg');">
                <a href="https://youtu.be/i9AHJkHqkpw" target="_blank">
                <div class="card-body"></div></a>
            </div>

            <div class="card" style="background-image: url('https://img.youtube.com/vi/Jg3gwyoUrhE/hqdefault.jpg');">
                <a href="https://youtu.be/Jg3gwyoUrhE" target="_blank">
                <div class="card-body"></div></a>
            </div>

            <div class="card" style="background-image: url('https://img.youtube.com/vi/Zki6xPc7hK0/hqdefault.jpg');">
                <a href="https://youtu.be/Zki6xPc7hK0" target="_blank">
                <div class="card-body"></div></a>
            </div>

            <div class="card" style="background-image: url('https://img.youtube.com/vi/wOBnq0Ewz5k/hqdefault.jpg');">
                <a href="https://youtu.be/wOBnq0Ewz5k" target="_blank">
                <div class="card-body"></div></a>
            </div>
        </div>

        <div class="cards-container">
            <div class="card" style="background-image: url('https://img.youtube.com/vi/0-7IHOXkiV8/hqdefault.jpg');">
                <a href="https://youtu.be/0-7IHOXkiV8" target="_blank">
                <div class="card-body"></div></a>
            </div>

            <div class="card" style="background-image: url('https://img.youtube.com/vi/RgKAFK5djSk/hqdefault.jpg');">
                <a href="https://youtu.be/RgKAFK5djSk" target="_blank">
                <div class="card-body"></div></a>
            </div>

            <div class="card" style="background-image: url('https://img.youtube.com/vi/n70xejQ4tXs/hqdefault.jpg');">
                <a href="https://youtu.be/n70xejQ4tXs" target="_blank">
                <div class="card-body"></div></a>
            </div>

            <div class="card" style="background-image: url('https://img.youtube.com/vi/UprcpdwuwCg/hqdefault.jpg');">
                <a href="https://youtu.be/UprcpdwuwCg" target="_blank">
                <div class="card-body"></div></a>
            </div>
        </div>
    </div>

    
</div>
</body>
</html>
