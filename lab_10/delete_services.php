<?php
require 'includes/db.php';
require 'includes/auth.php';

if (!isLoggedIn() || !isAdmin()) {
    header('Location: login.php');
    exit;
}

$users_id = $_GET['users_id'];
$services_id = $_GET['services_id'];

$stmt = $pdo->prepare("DELETE FROM users_services WHERE users_id = :users_id AND services_id = :services_id");
$stmt->execute(['users_id' => $users_id, 'services_id' => $services_id]);

header('Location: admin.php');
exit();
?>
