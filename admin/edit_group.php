<?php
require_once('../includes/config.php');
require_once('../includes/functions.php');

// Проверка авторизации администратора
check_admin_auth();

// Получение ID группы из GET-параметра
$group_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($group_id > 0) {
    $group = get_group($group_id);
    if (!$group) {
        header("Location: groups.php");
        exit;
    }
} else {
    header("Location: groups.php");
    exit;
}

// Обработка формы редактирования группы
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_group'])) {
    $group_name = trim($_POST['group_name']);
    if (!empty($group_name)) {
        $db = get_db_connection();
        $sql = "UPDATE groups SET name = :name WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([':name' => $group_name, ':id' => $group_id]);
        header("Location: groups.php");
        exit;
    }
}

// Включаем шапку
include('../templates/header.php');
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактировать группу - Административная панель</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="container">
        <h1>Редактировать группу</h1>
        <a href="groups.php">Назад к списку групп</a>
        <hr>

        <form method="post" id="edit_group_form">
            <label for="group_name">Название группы:</label>
            <input type="text" id="group_name" name="group_name" value="<?php echo htmlspecialchars($group['name']); ?>" required>
            <input type="submit" value="Сохранить изменения" name="edit_group">
        </form>
    </div>

    <script src="../js/admin.js"></script>
</body>
</html>

<?php
// Включаем подвал
include('../templates/footer.php');
?>
