<?php
require 'includes/db.php';
require 'includes/auth.php';

if (!isLoggedIn() || !isAdmin()) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['clip_title'];
    $video_url = $_POST['video_url'];
    $description = $_POST['description'];
    $clip_id = isset($_POST['clip_id']) ? (int)$_POST['clip_id'] : null;

    if ($clip_id) {
        $stmt = $pdo->prepare("UPDATE clips SET title = :title, video_url = :video_url, description = :description WHERE id = :id");
        $stmt->execute(['title' => $title, 'video_url' => $video_url, 'description' => $description, 'id' => $clip_id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO clips (title, video_url, description) VALUES (:title, :video_url, :description)");
        $stmt->execute(['title' => $title, 'video_url' => $video_url, 'description' => $description]);
    }

    header('Location: add_clip.php');
    exit();
}

if (isset($_GET['delete_clip_id'])) {
    $clip_id = $_GET['delete_clip_id'];
    $stmt = $pdo->prepare("DELETE FROM clips WHERE id = :id");
    $stmt->execute(['id' => $clip_id]);
    header('Location: add_clip.php');
    exit();
}

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

$edit_clip = null;
if (isset($_GET['edit_clip_id'])) {
    $clip_id = $_GET['edit_clip_id'];
    $stmt = $pdo->prepare("SELECT * FROM clips WHERE id = :id");
    $stmt->execute(['id' => $clip_id]);
    $edit_clip = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление клипами</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<div class="layout">
    <div class="menu">
        <h1>Управление клипами</h1>
        <a href="admin.php">Панель администратора</a>
        <div class="logout">
            <a href="logout.php">Выйти из аккаунта</a>
        </div>
    </div>

    <form class="menu_user" action="add_clip.php" method="post">
        <h2><?php echo $edit_clip ? 'Редактирование клипа' : 'Добавление клипа'; ?></h2>
        <?php if ($edit_clip): ?>
            <input type="hidden" name="clip_id" value="<?php echo $edit_clip['id']; ?>">
        <?php endif; ?>

        <label for="clip_title">Название клипа:</label>
        <input type="text" name="clip_title" id="clip_title" value="<?php echo $edit_clip['title'] ?? ''; ?>" required><br>

        <label for="video_url">URL видео:</label>
        <input type="url" name="video_url" id="video_url" value="<?php echo $edit_clip['video_url'] ?? ''; ?>" required><br>

        <label for="description">Описание:</label>
        <textarea name="description" id="description" required><?php echo $edit_clip['description'] ?? ''; ?></textarea><br>

        <button type="submit"><?php echo $edit_clip ? 'Сохранить изменения' : 'Добавить клип'; ?></button>
    </form>

    <div class="menu">
        <table class="table">
            <thead>
                <tr>
                    <th>Название клипа</th>
                    <th>URL видео</th>
                    <th>Описание</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clips as $clip): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($clip['title']); ?></td>
                        <td><a href="<?php echo htmlspecialchars($clip['video_url']); ?>" target="_blank"><?php echo htmlspecialchars($clip['video_url']); ?></a></td>
                        <td><?php echo htmlspecialchars($clip['description']); ?></td>
                        <td>
                            <a href="add_clip.php?edit_clip_id=<?php echo $clip['id']; ?>">Редактировать</a> |
                            <a href="add_clip.php?delete_clip_id=<?php echo $clip['id']; ?>" onclick="return confirm('Вы уверены?')">Удалить</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="add_clip.php?page=<?php echo $page - 1; ?>">&laquo; Предыдущая</a>
            <?php endif; ?>
            <?php if ($page < $total_pages): ?>
                <a href="add_clip.php?page=<?php echo $page + 1; ?>">Следующая &raquo;</a>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>
