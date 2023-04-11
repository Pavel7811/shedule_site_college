<?php
require_once('../includes/config.php');
require_once('../includes/functions.php');

// Проверка авторизации администратора
check_admin_auth();

// Получение ID предмета из GET-параметра
$subject_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($subject_id > 0) {
    $subject = get_subject($subject_id);
    if ($subject) {
        $db = get_db_connection();
        $sql = "DELETE FROM subjects WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([':id' => $subject_id]);
    }
}

header("Location: subjects.php");
exit;
