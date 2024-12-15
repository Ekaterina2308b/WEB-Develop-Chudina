<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'includes/db.php';
require 'includes/auth.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

// Функция для получения URL миниатюры YouTube
function getYoutubeThumbnail($url) {
    $parsed_url = parse_url($url);
    if (isset($parsed_url['query'])) {
        parse_str($parsed_url['query'], $query);
        return 'https://img.youtube.com/vi/' . $query['v'] . '/hqdefault.jpg';
    } elseif (isset($parsed_url['path'])) {
        $path_parts = explode('/', trim($parsed_url['path'], '/'));
        $video_id = end($path_parts);
        return 'https://img.youtube.com/vi/' . $video_id . '/hqdefault.jpg';
    }
    return '';
}

// Пагинация клипов
$items_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $items_per_page;

$stmt = $pdo->prepare("SELECT * FROM clips LIMIT :offset, :items_per_page");
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->bindParam(':items_per_page', $items_per_page, PDO::PARAM_INT);
$stmt->execute();
$clips = $stmt->fetchAll();

$stmt = $pdo->query("SELECT COUNT(*) FROM clips");
$total_clips = $stmt->fetchColumn();
$total_pages = ceil($total_clips / $items_per_page);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Популярные клипы</title>
    <link rel="stylesheet" href="css/album.css">
</head>
<body>
<div class="layout">
    <div class="menu">
        <h1>Популярные клипы</h1>
        <a href="index.php">Главная страница</a>
        <a href="album.php">Альбомы</a>
        <a href="artist.php">Артисты</a>
        <?php if (isAdmin()): ?>
            <a href="admin.php">Панель администратора</a>
        <?php else: ?>
            <a href="profile.php">Панель пользователя</a>
        <?php endif; ?>
        <div class="logout">
            <a href="logout.php">Выйти из аккаунта</a>
        </div>
    </div>

    <div class="cards-block">
        <div class="cards-container">
            <?php foreach ($clips as $clip): ?>
                <div class="card" style="background-image: url('<?php echo getYoutubeThumbnail($clip['video_url']); ?>');">
                    <a href="<?php echo htmlspecialchars($clip['video_url']); ?>" target="_blank"></a>
                    <div class="card-body">
                        <h3><?php echo htmlspecialchars($clip['title']); ?></h3>
                        <p><?php echo htmlspecialchars($clip['description']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="clips.php?page=<?php echo $page - 1; ?>">&laquo; Предыдущая</a>
        <?php endif; ?>
        <?php if ($page < $total_pages): ?>
            <a href="clips.php?page=<?php echo $page + 1; ?>">Следующая &raquo;</a>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
