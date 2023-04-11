<?php
require_once('../includes/config.php');
require_once('../includes/functions.php');

// Проверка авторизации администратора
check_admin_auth();

// Получение ID группы из GET-параметра
$group_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($group_id > 0) {
    $group = get_group($group_id);
    if ($group) {
        $db = get_db_connection();
        $sql = "DELETE FROM groups WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([':id' => $group_id]);
    }
}

header("Location: groups.php");
exit;
