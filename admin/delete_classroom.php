<?php
require_once('../includes/config.php');
require_once('../includes/functions.php');

// Проверка авторизации администратора
check_admin_auth();

// Получение ID аудитории из GET-параметра
$classroom_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($classroom_id > 0) {
    $classroom = get_classroom($classroom_id);
    if ($classroom) {
        $db = get_db_connection();
        $sql = "DELETE FROM classrooms WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([':id' => $classroom_id]);
    }
}

header("Location: classrooms.php");
exit;
