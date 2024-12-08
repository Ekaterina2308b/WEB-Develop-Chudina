<?php
require 'includes/db.php';
require 'includes/auth.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$user_email = $_SESSION['user']['email'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$stmt->execute(['email' => $user_email]);
$user = $stmt->fetch();

$stmt = $pdo->prepare("SELECT s.id, s.name
                        FROM services s
                        JOIN users_services us ON s.id = us.services_id
                        JOIN users u ON us.users_id = u.id
                        WHERE u.id = :id");
$stmt->execute(['id' => $user['id']]);
$services = $stmt->fetchAll();

if (!$user) {
    echo "Пользователь не найден";
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
        <h1>Профиль пользователя</h1>
        <a href="index.php">Главная страница</a>
        <a href="edit_profile.php">Редактировать профиль</a>
        <div class="logout">
            <a href="logout.php">Выйти из аккаунта</a>
        </div>
    </div>



<table>
    <thead>
        <tr>
            <th>Email</th>
            <th>Роль</th>
        </tr>
    </thead>
    <tbody>
        <td><?php echo htmlspecialchars($user['email']); ?></td>
        <td><?php echo htmlspecialchars($user['role']); ?></td>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th>Услуги</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($services as $service): ?>
            <tr>
                <td><?php echo htmlspecialchars($service['name']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</div>      
</body>
</html>
