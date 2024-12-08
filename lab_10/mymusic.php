<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'includes/auth.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

echo "<h2>Моя музыка</h2>";

echo "<h1>Трек 1</h1>";
echo "<h1>Трек 2</h1>";
echo "<h1>Трек 3</h1>";
?>

<a href="index.php">Выйти</a>
