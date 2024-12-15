<?php
require 'includes/db.php';
require 'includes/auth.php';

if (!isLoggedIn() || !isAdmin()) {
    header('Location: login.php');
    exit;
}

$upload_dir = 'img/';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['artist_name'];
    $bio = $_POST['artist_bio'];
    $genius_url = $_POST['genius_url'];
    $artist_id = isset($_POST['artist_id']) ? (int)$_POST['artist_id'] : null;

    if (isset($_FILES['artist_image']) && $_FILES['artist_image']['error'] == UPLOAD_ERR_OK) {
        $artist_image = $_FILES['artist_image'];
        $image_path = $upload_dir . basename($artist_image['name']);
        move_uploaded_file($artist_image['tmp_name'], $image_path);
    } else {
        $image_path = isset($_POST['current_image']) ? $_POST['current_image'] : '';
    }

    if ($artist_id) {
        $stmt = $pdo->prepare("UPDATE artists SET name = :name, bio = :bio, image_url = :image_url, genius_url = :genius_url WHERE id = :id");
        $stmt->execute(['name' => $name, 'bio' => $bio, 'image_url' => $image_path, 'genius_url' => $genius_url, 'id' => $artist_id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO artists (name, bio, image_url, genius_url) VALUES (:name, :bio, :image_url, :genius_url)");
        $stmt->execute(['name' => $name, 'bio' => $bio, 'image_url' => $image_path, 'genius_url' => $genius_url]);
    }

    header('Location: add_artist.php');
    exit();
}

if (isset($_GET['delete_artist_id'])) {
    $artist_id = $_GET['delete_artist_id'];
    $stmt = $pdo->prepare("DELETE FROM artists WHERE id = :id");
    $stmt->execute(['id' => $artist_id]);
    header('Location: add_artist.php');
    exit();
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

$edit_artist = null;
if (isset($_GET['edit_artist_id'])) {
    $artist_id = $_GET['edit_artist_id'];
    $stmt = $pdo->prepare("SELECT * FROM artists WHERE id = :id");
    $stmt->execute(['id' => $artist_id]);
    $edit_artist = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление артистами</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<div class="layout">
    <div class="menu">
        <h1>Управление артистами</h1>
        <a href="admin.php">Панель администратора</a>
        <div class="logout">
            <a href="logout.php">Выйти из аккаунта</a>
        </div>
    </div>

    <form class="menu_user" action="add_artist.php" method="post" enctype="multipart/form-data">
        <h2><?php echo $edit_artist ? 'Редактирование артиста' : 'Добавление артиста'; ?></h2>
        <?php if ($edit_artist): ?>
            <input type="hidden" name="artist_id" value="<?php echo $edit_artist['id']; ?>">
            <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($edit_artist['image_url']); ?>">
        <?php endif; ?>

        <label for="artist_name">Имя артиста:</label>
        <input type="text" name="artist_name" id="artist_name" value="<?php echo $edit_artist['name'] ?? ''; ?>" required><br>

        <label for="artist_bio">Биография:</label>
        <textarea name="artist_bio" id="artist_bio" required><?php echo $edit_artist['bio'] ?? ''; ?></textarea><br>

        <label for="genius_url">URL на Genius:</label>
        <input type="url" name="genius_url" id="genius_url" value="<?php echo $edit_artist['genius_url'] ?? ''; ?>" required><br>

        <label for="artist_image">Загрузить изображение:</label>
        <input type="file" name="artist_image" id="artist_image"><br>
        <?php if ($edit_artist && $edit_artist['image_url']): ?>
            <img src="<?php echo htmlspecialchars($edit_artist['image_url']); ?>" alt="<?php echo htmlspecialchars($edit_artist['name']); ?>" style="max-width: 100px;"><br>
        <?php endif; ?>

        <button type="submit"><?php echo $edit_artist ? 'Сохранить изменения' : 'Добавить артиста'; ?></button>
    </form>

    <div class="menu">
        <table class="table">
            <thead>
                <tr>
                    <th>Имя артиста</th>
                    <th>Биография</th>
                    <th>Изображение</th>
                    <th>URL на Genius</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($artists as $artist): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($artist['name']); ?></td>
                        <td><?php echo htmlspecialchars($artist['bio']); ?></td>
                        <td>
                            <?php if (!empty($artist['image_url'])): ?>
                                <img src="<?php echo htmlspecialchars($artist['image_url']); ?>" alt="<?php echo htmlspecialchars($artist['name']); ?>" style="max-width: 100px;">
                            <?php endif; ?>
                        </td>
                        <td><a href="<?php echo htmlspecialchars($artist['genius_url']); ?>" target="_blank"><?php echo htmlspecialchars($artist['genius_url']); ?></a></td>
                        <td>
                            <a href="add_artist.php?edit_artist_id=<?php echo $artist['id']; ?>">Редактировать</a> |
                            <a href="add_artist.php?delete_artist_id=<?php echo $artist['id']; ?>" onclick="return confirm('Вы уверены?')">Удалить</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="add_artist.php?page=<?php echo $page - 1; ?>">&laquo; Предыдущая</a>
            <?php endif; ?>
            <?php if ($page < $total_pages): ?>
                <a href="add_artist.php?page=<?php echo $page + 1; ?>">Следующая &raquo;</a>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>
