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

if (!$user) {
    echo "Пользователь не найден";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    $stmt = $pdo->prepare("UPDATE users SET email = :email WHERE id = :id");
    $stmt->execute(['email' => $email, 'id' => $user['id']]);

    $_SESSION['user']['email'] = $email;

    header('Location: profile.php');
    exit();
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
        <h1>Редактирование пользователя</h1>
        <?php if (isAdmin()): ?>
            <a href="admin.php">Панель администратора</a>
        <?php else: ?>
            <a href="profile.php">Панель пользователя</a>
        <?php endif; ?>
        <div class="logout">
            <a href="logout.php">Выйти из аккаунта</a>
        </div>
    </div>

<form class="menu_user" action="admin.php" method="post">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br>

    <button type="submit">Сохранить</button>
</form>

</div>
</body>
</html>

