<?php
require 'includes/db.php';
require 'includes/auth.php';

if (!isLoggedIn() || !isAdmin()) {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'];

$stmt = $pdo->query("SELECT id, name FROM services");
$services = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $services_id = $_POST['services_id'];

    try {
        $stmt = $pdo->prepare("INSERT INTO users_services (users_id, services_id) VALUES (:users_id, :services_id)");
        $stmt->execute(['users_id' => $id, 'services_id' => $services_id]);
        header('Location: admin.php');
        exit();

    } catch (PDOException $e) {
        header('Location: admin.php');
        exit();
    }   
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
<form action="add_services_by_users_id.php?id=<?php echo htmlspecialchars($id); ?>" method="post">
    <h1 for="services_id">Выберите услугу:</h1>
    <select name="services_id" id="services_id">
        <?php foreach ($services as $service): ?>
            <option value="<?php echo $service['id']; ?>"><?php echo htmlspecialchars($service['name']); ?></option>
        <?php endforeach; ?>
    </select><br>

    <button type="submit">Добавить</button>
</form>

</div>
</body>
</html>