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



<h2>Добавить услугу</h2>

<form action="add_services.php" method="post">
    <label for="name">Название услуги:</label>
    <input type="name" name="name" id="name" required><br>
    <button type="submit">Добавить</button>
</form>