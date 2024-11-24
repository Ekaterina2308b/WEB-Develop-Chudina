<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'includes/auth.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

if (isAdmin()) {
    echo " <a href='admin.php'>Панель администратора</a>";
} else {
    echo " <a href='profile.php'>Панель пользователя</a>";
}
?>

<a href="logout.php">Выйти</a>
