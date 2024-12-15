<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'includes/db.php';
require 'includes/auth.php';

if (!isLoggedIn() || !isAdmin()) {
    header('Location: login.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM users");
$stmt->execute();
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Музыкальный портал</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<div class="layout">
    <div class="menu">
        <h1>Управление пользователями</h1>
        <a href="index.php">Главная страница</a>
        <a href="add_services.php">Добавить услугу</a>
        <a href="add_album.php">Управление альбомами</a>
        <a href="add_artist.php">Управление артистами</a>
        <a href="add_clips.php">Управление клипами</a>
        <div class="logout">
            <a href="logout.php">Выйти из аккаунта</a>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Email</th>
                <th>Роль</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                    <td>
                        <a href="edit_profile.php?id=<?php echo $user['id']; ?>">Редактировать</a> |
                        <a href="delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Вы уверены?')">Удалить</a> |
                        <a href="list_services_by_users_id.php?id=<?php echo $user['id']; ?>">Список услуг</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
