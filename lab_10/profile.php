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

<h2>Профиль пользователя</h2>

<p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
<p>Роль: <?php echo htmlspecialchars($user['role']); ?></p>

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

<a href="edit_profile.php">Редактировать профиль</a>
<a href="logout.php">Выйти</a>
