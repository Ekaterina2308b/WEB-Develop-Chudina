<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'includes/auth.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

echo "<h2>Добро пожаловать на музыкальный портал!</h2>";

echo "<div style='text-align: center; margin-top: 20px;'>
        <img src='gif/minion.gif' alt='Музыкальная анимация' />
      </div>";

// Добавляем ссылку на музыкальные рекомендации
echo " <a href='yandex.php'>Рекомендации музыки в Yandex</a>";
echo " <a href='vk.php'>Рекомендации музыки в VK</a>";


if (isAdmin()) {
    echo " <a href='admin.php'>Панель администратора</a>";
} else {
    echo " <a href='profile.php'>Панель пользователя</a>";
}

?>

<a href="logout.php">Выйти</a>
