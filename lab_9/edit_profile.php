<?php
session_start();
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

<h2>Редактировать профиль</h2>

<form action="admin.php" method="post">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br>

    <button type="submit">Сохранить</button>
</form>
