<?php
require_once('../includes/config.php');
require_once('../includes/functions.php');

// Проверка авторизации администратора
check_admin_auth();

// Обработка формы добавления преподавателя
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_teacher'])) {
    $teacher_name = trim($_POST['teacher_name']);
    if (!empty($teacher_name)) {
        $db = get_db_connection();
        $sql = "INSERT INTO teachers (name) VALUES (:name)";
        $stmt = $db->prepare($sql);
        $stmt->execute([':name' => $teacher_name]);
    }
}

// Включаем шапку
include('../templates/header.php');
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Управление преподавателями - Административная панель</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="container">
        <h1>Управление преподавателями</h1>
        <a href="index.php">Назад к главной административной панели</a>
        <hr>

        <form method="post" id="add_teacher_form">
            <label for="teacher_name">Имя преподавателя:</label>
            <input type="text" id="teacher_name" name="teacher_name" required>
            <input type="submit" value="Добавить преподавателя" name="add_teacher">
        </form>
        <hr>

        <h2>Список преподавателей:</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Действия</th>
            </tr>
            <?php
            $teachers = get_teachers();
            foreach ($teachers as $teacher) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($teacher['id']) . "</td>";
                echo "<td>" . htmlspecialchars($teacher['name']) . "</td>";
                echo "<td>";
                echo "<a href='edit_teacher.php?id=" . htmlspecialchars($teacher['id']) . "'>Редактировать</a> | ";
                echo "<a href='delete_teacher.php?id=" . htmlspecialchars($teacher['id']) . "'>Удалить</a>";
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
