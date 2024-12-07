<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'includes/db.php';  
require 'includes/auth.php';  

if (isAuthenticated()) {
    header("Location: index.php");
    exit();
}

$stmt = $pdo->query("SELECT id, name FROM services");
$services = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (checkUserCredentials($email, $password)) {
        $_SESSION['user'] = getUserByEmail($email);
        header("Location: index.php"); 
        exit();
    } else {
        $error = "Неверные данные для входа";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
</head>
<body>
    <h2>Вход в систему</h2>

    <?php if (isset($error)): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="login.php" method="post">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br>
        <label for="password">Пароль:</label>
        <input type="password" name="password" id="password" required><br>
        <button type="submit">Войти</button>
    </form>
    <p>Нет аккаунта? <a href="register.php">Зарегистрироваться</a></p>

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
</body>
</html>
