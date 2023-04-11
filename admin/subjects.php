<?php
require_once('../includes/config.php');
require_once('../includes/functions.php');

// Проверка авторизации администратора
check_admin_auth();

// Обработка формы добавления предмета
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_subject'])) {
    $subject_name = trim($_POST['subject_name']);
    if (!empty($subject_name)) {
        $db = get_db_connection();
        $sql = "INSERT INTO subjects (name) VALUES (:name)";
        $stmt = $db->prepare($sql);
        $stmt->execute([':name' => $subject_name]);
    }
}

// Включаем шапку
include('../templates/header.php');
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Управление предметами - Административная панель</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="container">
        <h1>Управление предметами</h1>
        <a href="index.php">Назад к главной административной панели</a>
        <hr>

        <form method="post" id="add_subject_form">
            <label for="subject_name">Название предмета:</label>
            <input type="text" id="subject_name" name="subject_name" required>
            <input type="submit" value="Добавить предмет" name="add_subject">
        </form>
        <hr>

        <h2>Список предметов:</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Действия</th>
            </tr>
            <?php
            $subjects = get_subjects();
            foreach ($subjects as $subject) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($subject['id']) . "</td>";
                echo "<td>" . htmlspecialchars($subject['name']) . "</td>";
                echo "<td>";
                echo "<a href='edit_subject.php?id=" . htmlspecialchars($subject['id']) . "'>Редактировать</a> | ";
                echo "<a href='delete_subject.php?id=" . htmlspecialchars($subject['id']) . "'>Удалить</a>";
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
