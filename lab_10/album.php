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
        <a href="artist.php">Артисты</a>
        <a href="clips.php">Популярные клипы</a>
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
            <div class="card" style="background-image: url('img/bandana.jpg');" onclick="location.href='https://genius.com/Big-baby-tape-and-kizaru-bandana-lyrics';" >
                <div class="card-body"></div>
            </div>
            <div class="card" style="background-image: url('img/egoralbum.jpg');" onclick="location.href='https://genius.com/albums/Egor-kreed/3';">
                <div class="card-body">
                </div>
            </div>
            <div class="card" style="background-image: url('img/weliveonly.jpg');" onclick="location.href='https://genius.com/albums/Aarne-and-bushido-zho/We-live-only-once';">
                <div class="card-body">
                </div>
            </div>
            <div class="card" style="background-image: url('img/peekaboo.jpg');" onclick="location.href='https://genius.com/albums/Big-baby-tape-and-aarne/Peekaboo';">
                <div class="card-body">
                </div>
            </div>
        </div>

        <div class="cards-container">
            <div class="card" style="background-image: url('img/mona.jpg');" onclick="location.href='https://genius.com/albums/Mona/Deluxe-edition';">
                <div class="card-body">
                </div>
            </div>
            <div class="card" style="background-image: url('img/annaalbum.jpg');" onclick="location.href='https://genius.com/albums/Anna-asti/Deluxe-tsarina';">
                <div class="card-body">
                </div>
            </div>
            <div class="card" style="background-image: url('img/buster.jpg');" onclick="location.href='https://genius.com/albums/Miyagi/Buster-keaton';">
                <div class="card-body">
                </div>
            </div>
            <div class="card" style="background-image: url('img/shut.jpg');" onclick="location.href='https://genius.com/albums/Korol-i-shut/Acoustic-album';">
                <div class="card-body">
                </div>
            </div>
        </div>

        <div class="cards-container">
            <div class="card" style="background-image: url('img/macan.jpg');" onclick="location.href='https://genius.com/albums/Korol-i-shut/Acoustic-album';">
                <div class="card-body">
                </div>
            </div>
            <div class="card" style="background-image: url('img/korzh.jpg');" onclick="location.href='https://genius.com/albums/Korol-i-shut/Acoustic-album';">
                <div class="card-body">
                </div>
            </div>
            <div class="card" style="background-image: url('img/melancholia.jpg');" onclick="location.href='https://genius.com/albums/Tdd/Melancholia';">
                <div class="card-body">
                </div>
            </div>
            <div class="card" style="background-image: url('img/mayot.jpg');" onclick="location.href='https://genius.com/albums/Mayot/Both';">
                <div class="card-body">
                </div>
            </div>
        </div>
    </div>

    
</div>
</body>
</html>
