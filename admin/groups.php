<?php
require_once('../includes/config.php');
require_once('../includes/functions.php');

// Проверка авторизации администратора
check_admin_auth();

// Обработка формы добавления группы
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_group'])) {
    $group_name = trim($_POST['group_name']);
    if (!empty($group_name)) {
        $db = get_db_connection();
        $sql = "INSERT INTO groups (name) VALUES (:name)";
        $stmt = $db->prepare($sql);
        $stmt->execute([':name' => $group_name]);
    }
}

// Включаем шапку
include('../templates/header.php');
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Управление группами - Административная панель</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="container">
        <h1>Управление группами</h1>
        <a href="index.php">Назад к главной административной панели</a>
        <hr>

        <form method="post" id="add_group_form">
            <label for="group_name">Название группы:</label>
            <input type="text" id="group_name" name="group_name" required>
            <input type="submit" value="Добавить группу" name="add_group">
        </form>
        <hr>

        <h2>Список групп:</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Действия</th>
            </tr>
            <?php
            $groups = get_groups();
            foreach ($groups as $group) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($group['id']) . "</td>";
                echo "<td>" . htmlspecialchars($group['name']) . "</td>";
                echo "<td>";
                echo "<a href='edit_group.php?id=" . htmlspecialchars($group['id']) . "'>Редактировать</a> | ";
                echo "<a href='delete_group.php?id=" . htmlspecialchars($group['id']) . "'>Удалить</a>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>

    <script src="../js/admin.js"></script>
</body>
</html>

<?php
// Включаем подвал
include('../templates/footer.php');
?>
