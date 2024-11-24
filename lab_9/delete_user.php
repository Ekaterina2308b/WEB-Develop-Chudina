<?php
session_start();
require 'includes/db.php';
require 'includes/auth.php';

if (!isLoggedIn() || !isAdmin()) {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
$stmt->execute(['id' => $id]);

header('Location: admin.php');
exit();
?>
