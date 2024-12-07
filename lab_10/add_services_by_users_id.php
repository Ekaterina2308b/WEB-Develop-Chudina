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

<h2>Добавить услугу</h2>

<form action="add_services_by_users_id.php?id=<?php echo htmlspecialchars($id); ?>" method="post">
    <label for="services_id">Выберите услугу:</label>
    <select name="services_id" id="services_id">
        <?php foreach ($services as $service): ?>
            <option value="<?php echo $service['id']; ?>"><?php echo htmlspecialchars($service['name']); ?></option>
        <?php endforeach; ?>
    </select><br>

    <button type="submit">Добавить</button>
</form>