<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'includes/db.php';
require 'includes/auth.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$items_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $items_per_page;

$stmt = $pdo->prepare("SELECT * FROM artists LIMIT :offset, :items_per_page");
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->bindParam(':items_per_page', $items_per_page, PDO::PARAM_INT);
$stmt->execute();
$artists = $stmt->fetchAll();

$stmt = $pdo->query("SELECT COUNT(*) FROM artists");
$total_artists = $stmt->fetchColumn();
$total_pages = ceil($total_artists / $items_per_page);
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
        <h1>Артисты</h1>
        <a href="index.php">Главная страница</a>
        <a href="album.php">Альбомы</a>
        <a href="clips.php">Популярные клипы</a>
        <?php if (isAdmin()): ?>
            <a href="admin.php">Панель администратора</a>
        <?php else: ?>
            <a href="profile.php">Панель пользователя</a>
        <?php endif; ?>
        <div class="logout">
            <a href="logout.php">Выйти из аккаунта</a>
        </div>
    </div>

    <div class="artists-block">
        <?php foreach ($artists as $artist): ?>
            <div class="card" style="background-image: url('<?php echo htmlspecialchars($artist['image_url']); ?>');">
                <a href="<?php echo htmlspecialchars($artist['genius_url']); ?>" target="_blank">
                    <div class="card-body">
                        <h3><?php echo htmlspecialchars($artist['name']); ?></h3>
                        <p><?php echo htmlspecialchars($artist['bio']); ?></p>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="artist.php?page=<?php echo $page - 1; ?>">&laquo; Предыдущая</a>
        <?php endif; ?>
        <?php if ($page < $total_pages): ?>
            <a href="artist.php?page=<?php echo $page + 1; ?>">Следующая &raquo;</a>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
