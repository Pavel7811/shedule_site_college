<?php
require_once('../includes/config.php');
require_once('../includes/functions.php');

// Проверка авторизации администратора
check_admin_auth();

// Получение ID аудитории из GET-параметра
$classroom_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($classroom_id > 0) {
    $classroom = get_classroom($classroom_id);
    if (!$classroom) {
        header("Location: classrooms.php");
        exit;
    }
} else {
    header("Location: classrooms.php");
    exit;
}

// Обработка формы редактирования аудитории
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_classroom'])) {
    $classroom_name = trim($_POST['classroom_name']);
    if (!empty($classroom_name)) {
        $db = get_db_connection();
        $sql = "UPDATE classrooms SET name = :name WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([':name' => $classroom_name, ':id' => $classroom_id]);
        header("Location: classrooms.php");
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
    <title>Редактировать аудиторию - Административная панель</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="container">
        <h1>Редактировать аудиторию</h1>
        <a href="classrooms.php">Назад к списку аудиторий</a>
        <hr>

        <form method="post" id="edit_classroom_form">
            <label for="classroom_name">Название аудитории:</label>
            <input type="text" id="classroom_name" name="classroom_name" value="<?php echo htmlspecialchars($classroom['name']); ?>" required>
            <input type="submit" value="Сохранить изменения" name="edit_classroom">
        </form>
    </div>

    <script src="../js/admin.js"></script>
</body>
</html>

<?php
// Включаем подвал
include('../templates/footer.php');
?>
