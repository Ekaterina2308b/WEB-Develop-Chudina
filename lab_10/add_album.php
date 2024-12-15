<?php
require 'includes/db.php';
require 'includes/auth.php';

if (!isLoggedIn() || !isAdmin()) {
    header('Location: login.php');
    exit;
}

$upload_dir = 'img/';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['album_title'])) {
    $title = $_POST['album_title'];
    $genius_url = $_POST['genius_url'];

    if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] == UPLOAD_ERR_OK) {
        $cover_image = $_FILES['cover_image'];
        $cover_path = $upload_dir . basename($cover_image['name']);
        move_uploaded_file($cover_image['tmp_name'], $cover_path);
    } else {
        $cover_path = '';
    }

    $stmt = $pdo->prepare("INSERT INTO albums (title, cover_url, genius_url) VALUES (:title, :cover_url, :genius_url)");
    $stmt->execute(['title' => $title, 'cover_url' => $cover_path, 'genius_url' => $genius_url]);

    header('Location: add_album.php');
    exit();
}

if (isset($_GET['delete_album_id'])) {
    $album_id = $_GET['delete_album_id'];
    $stmt = $pdo->prepare("DELETE FROM albums WHERE id = :id");
    $stmt->execute(['id' => $album_id]);
    header('Location: add_album.php');
    exit();
}

$items_per_page = 10;
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
    <title>Управление альбомами</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<div class="layout">
    <div class="menu">
        <h1>Добавление альбома</h1>
        <a href="admin.php">Панель администратора</a>
        <div class="logout">
            <a href="logout.php">Выйти из аккаунта</a>
        </div>
    </div>

    <form class="menu_user" action="add_album.php" method="post" enctype="multipart/form-data">
        <label for="album_title">Название альбома:</label>
        <input type="text" name="album_title" id="album_title" required><br>

        <label for="cover_image">Загрузить обложку:</label>
        <input type="file" name="cover_image" id="cover_image" required><br>

        <label for="genius_url">URL на Genius:</label>
        <input type="url" name="genius_url" id="genius_url" required><br>

        <button type="submit">Добавить альбом</button>
    </form>

    <div class="menu">
        <h1>Управление альбомами</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Название альбома</th>
                    <th>URL обложки</th>
                    <th>URL на Genius</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($albums as $album): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($album['title']); ?></td>
                        <td><?php echo htmlspecialchars($album['cover_url']); ?></td>
                        <td><?php echo htmlspecialchars($album['genius_url']); ?></td>
                        <td>
                            <a href="add_album.php?delete_album_id=<?php echo $album['id']; ?>" onclick="return confirm('Вы уверены?')">Удалить</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="add_album.php?page=<?php echo $page - 1; ?>">&laquo; Предыдущая</a>
            <?php endif; ?>
            <?php if ($page < $total_pages): ?>
                <a href="add_album.php?page=<?php echo $page + 1; ?>">Следующая &raquo;</a>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>
