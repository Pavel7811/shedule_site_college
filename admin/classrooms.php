<?php
require_once('../includes/config.php');
require_once('../includes/functions.php');

// Проверка авторизации администратора
check_admin_auth();

// Обработка формы добавления аудитории
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_classroom'])) {
    $classroom_name = trim($_POST['classroom_name']);
    if (!empty($classroom_name)) {
        $db = get_db_connection();
        $sql = "INSERT INTO classrooms (name) VALUES (:name)";
        $stmt = $db->prepare($sql);
        $stmt->execute([':name' => $classroom_name]);
    }
}

// Включаем шапку
include('../templates/header.php');
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Управление аудиториями - Административная панель</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="container">
        <h1>Управление аудиториями</h1>
        <a href="index.php">Назад к главной административной панели</a>
        <hr>

        <form method="post" id="add_classroom_form">
            <label for="classroom_name">Название аудитории:</label>
            <input type="text" id="classroom_name" name="classroom_name" required>
            <input type="submit" value="Добавить аудиторию" name="add_classroom">
        </form>
        <hr>

        <h2>Список аудиторий:</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Действия</th>
            </tr>
            <?php
            $classrooms = get_classrooms();
            foreach ($classrooms as $classroom) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($classroom['id']) . "</td>";
                echo "<td>" . htmlspecialchars($classroom['name']) . "</td>";
                echo "<td>";
                echo "<a href='edit_classroom.php?id=" . htmlspecialchars($classroom['id']) . "'>Редактировать</a> | ";
                echo "<a href='delete_classroom.php?id=" . htmlspecialchars($classroom['id']) . "'>Удалить</a>";
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
