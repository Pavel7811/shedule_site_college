<?php
require_once('../includes/config.php');
require_once('../includes/functions.php');

// Проверка авторизации администратора
check_admin_auth();

// Получение ID предмета из GET-параметра
$subject_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($subject_id > 0) {
    $subject = get_subject($subject_id);
    if (!$subject) {
        header("Location: subjects.php");
        exit;
    }
} else {
    header("Location: subjects.php");
    exit;
}

// Обработка формы редактирования предмета
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_subject'])) {
    $subject_name = trim($_POST['subject_name']);
    if (!empty($subject_name)) {
        $db = get_db_connection();
        $sql = "UPDATE subjects SET name = :name WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([':name' => $subject_name, ':id' => $subject_id]);
        header("Location: subjects.php");
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
    <title>Редактировать предмет - Административная панель</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="container">
        <h1>Редактировать предмет</h1>
        <a href="subjects.php">Назад к списку предметов</a>
        <hr>

        <form method="post" id="edit_subject_form">
            <label for="subject_name">Название предмета:</label>
            <input type="text" id="subject_name" name="subject_name" value="<?php echo htmlspecialchars($subject['name']); ?>" required>
            <input type="submit" value="Сохранить изменения" name="edit_subject">
        </form>
    </div>

    <script src="../js/admin.js"></script>
</body>
</html>

<?php
// Включаем подвал
include('../templates/footer.php');
?>
