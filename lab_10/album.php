<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'includes/db.php';
require 'includes/auth.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$items_per_page = 12;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $items_per_page;

$stmt = $pdo->prepare("SELECT * FROM albums LIMIT :offset, :items_per_page");
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->bindParam(':items_per_page', $items_per_page, PDO::PARAM_INT);
$stmt->execute();
$albums = $stmt->fetchAll();

$stmt = $pdo->query("SELECT COUNT(*) FROM albums");
$total_albums = $stmt->fetchColumn();
$total_pages = ceil($total_albums / $items_per_page);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Музыкальный портал</title>
    <link rel="stylesheet" href="css/album.css">
</head>
<body>
<div class="layout">
    <div class="menu">
        <h1>Альбомы</h1>
        <a href="index.php">Главная страница</a>
        <a href="artist.php">Артисты</a>
        <a href="clips.php">Популярные клипы</a>
        <?php if (isAdmin()): ?>
            <a href="admin.php" class="admin-btn">Панель администратора</a>
        <?php else: ?>
            <a href="profile.php" class="user-btn">Панель пользователя</a>
        <?php endif; ?>
        <div class="logout">
            <a href="logout.php" class="btn logout-btn">Выйти из аккаунта</a>
        </div>
    </div>

    <div class="cards-block">
        <div class="cards-container">
            <?php foreach ($albums as $album): ?>
                <div class="card" style="background-image: url('<?php echo htmlspecialchars($album['cover_url']); ?>');" onclick="location.href='<?php echo htmlspecialchars($album['genius_url']); ?>';">
                    <div class="card-body"></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="album.php?page=<?php echo $page - 1; ?>">&laquo; Предыдущая</a>
        <?php endif; ?>
        <?php if ($page < $total_pages): ?>
            <a href="album.php?page=<?php echo $page + 1; ?>">Следующая &raquo;</a>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
