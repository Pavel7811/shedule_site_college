<?php
require_once('../includes/config.php');
require_once('../includes/functions.php');

// Проверка авторизации администратора
check_admin_auth();

// Получение ID преподавателя из GET-параметра
$teacher_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($teacher_id > 0) {
    $teacher = get_teacher($teacher_id);
    if ($teacher) {
        $db = get_db_connection();
        $sql = "DELETE FROM teachers WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([':id' => $teacher_id]);
    }
}

header("Location: teachers.php");
exit;
