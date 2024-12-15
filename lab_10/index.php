<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'includes/auth.php';
require 'includes/db.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['news_text'])) {
    $news_text = $_POST['news_text'];

    $stmt = $pdo->prepare("INSERT INTO news (text, created_at) VALUES (:text, NOW())");
    $stmt->execute(['text' => $news_text]);

    header('Location: index.php');
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM news ORDER BY created_at DESC");
$stmt->execute();
$news = $stmt->fetchAll();
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
        <h1>Главная страница</h1>
        <a href="artist.php">Артисты</a>
        <a href="clips.php">Популярные клипы</a>
        <a href="album.php">Альбомы</a>
        <?php if (isAdmin()): ?>
            <a href="admin.php">Панель администратора</a>
        <?php else: ?>
            <a href="profile.php">Панель пользователя</a>
        <?php endif; ?>
        <div class="logout">
            <a href="logout.php">Выйти из аккаунта</a>
        </div>
    </div>

    <div class="news-section">
        <h1>Что у вас нового?</h1>
        <?php if (isLoggedIn()): ?>
            <form action="index.php" method="post" class="news-form">
                <textarea name="news_text" rows="4" required placeholder="Что у вас нового?"></textarea><br>
                <button type="submit">Опубликовать</button>
            </form>
        <?php else: ?>
            <p>Для публикации новостей необходимо <a href="login.php">войти в аккаунт</a>.</p>
        <?php endif; ?>

        <div class="news-feed">
            <?php foreach ($news as $item): ?>
                <div class="news-item">
                    <p><?php echo htmlspecialchars($item['text']); ?></p>
                    <small>Опубликовано: <?php echo htmlspecialchars($item['created_at']); ?></small>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
</body>
</html>
