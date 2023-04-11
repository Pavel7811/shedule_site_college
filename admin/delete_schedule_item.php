<?php
require_once('../includes/config.php');
require_once('../includes/functions.php');

// Проверка авторизации администратора
check_admin_auth();

// Проверка наличия параметра ID в запросе
if (isset($_GET['id'])) {
    $schedule_item_id = intval($_GET['id']);

    // Удаление элемента расписания из базы данных
    $db = get_db_connection();
    $sql = "DELETE FROM schedule WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->execute([':id' => $schedule_item_id]);
}

// Перенаправление обратно на страницу расписания
header('Location: schedule.php');
exit();
