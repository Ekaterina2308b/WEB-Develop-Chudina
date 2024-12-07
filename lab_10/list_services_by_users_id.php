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

<h2>Управление услугами</h2>

<table>
    <thead>
        <tr>
            <th>Название услуги</th>
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

<a href="add_services_by_users_id.php?id=<?php echo $id; ?>">Добавить услугу</a> |
<a href="admin.php">Выйти</a>

