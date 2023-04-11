<?php
require_once('../includes/config.php');
require_once('../includes/functions.php');

// Проверка авторизации администратора
check_admin_auth();

// Получение ID преподавателя из GET-параметра
$teacher_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($teacher_id > 0) {
    $teacher = get_teacher($teacher_id);
    if (!$teacher) {
        header("Location: teachers.php");
        exit;
    }
} else {
    header("Location: teachers.php");
    exit;
}

// Обработка формы редактирования преподавателя
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_teacher'])) {
    $teacher_name = trim($_POST['teacher_name']);
    if (!empty($teacher_name)) {
        $db = get_db_connection();
        $sql = "UPDATE teachers SET name = :name WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([':name' => $teacher_name, ':id' => $teacher_id]);
        header("Location: teachers.php");
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
    <title>Редактировать преподавателя - Административная панель</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="container">
        <h1>Редактировать преподавателя</h1>
        <a href="teachers.php">Назад к списку преподавателей</a>
        <hr>

        <form method="post" id="edit_teacher_form">
            <label for="teacher_name">Имя преподавателя:</label>
            <input type="text" id="teacher_name" name="teacher_name" value="<?php echo htmlspecialchars($teacher['name']); ?>" required>
            <input type="submit" value="Сохранить изменения" name="edit_teacher">
        </form>
    </div>

    <script src="../js/admin.js"></script>
</body>
</html>

<?php
// Включаем подвал
include('../templates/footer.php');
?>
