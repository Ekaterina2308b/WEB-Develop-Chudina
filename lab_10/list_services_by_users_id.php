<?php
require 'includes/db.php';
require 'includes/auth.php';

if (!isLoggedIn() || !isAdmin()) {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT s.id, s.name
                        FROM services s
                        JOIN users_services us ON s.id = us.services_id
                        JOIN users u ON us.users_id = u.id
                        WHERE u.id = :id");
$stmt->execute(['id' => $id]);
$services = $stmt->fetchAll();
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
        <h1>Добавление услуги</h1>
        <?php if (isAdmin()): ?>
            <a href="admin.php">Панель администратора</a>
        <?php else: ?>
            <a href="profile.php">Панель пользователя</a>
        <?php endif; ?>
        <div class="logout">
            <a href="logout.php">Выйти из аккаунта</a>
        </div>
    </div>

<table>
    <thead>
        <tr>
            <th>Название услуги</th>
            <th>Действие</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($services as $service): ?>
            <tr>
                <td><?php echo htmlspecialchars($service['name']); ?></td>
                <td>
                    <a href="delete_services.php?users_id=<?php echo $id; ?>&services_id=<?php echo $service['id']; ?>" onclick="return confirm('Вы уверены?')">Удалить</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>
</body>
</html>
