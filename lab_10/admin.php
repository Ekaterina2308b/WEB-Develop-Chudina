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

<h2>Управление пользователями</h2>

<table>
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
                    <a href="delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Вы уверены?')">Удалить</a>
                    <a href="list_services_by_users_id.php?id=<?php echo $user['id']; ?>">Список услуг</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="add_user.php">Добавить пользователя</a>
<a href="add_services.php">Добавить услугу</a>
<a href="logout.php">Выйти</a>

