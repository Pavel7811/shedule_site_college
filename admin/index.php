<?php
// Включаем файл с конфигурацией и функциями
require_once('../includes/config.php');
require_once('../includes/functions.php');

// Проверка авторизации администратора (реализуйте функцию check_admin_auth() в файле functions.php)
check_admin_auth();

// Включаем шапку
include('../templates/header.php');
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Административная панель - Главная</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="container">
        <h1>Административная панель</h1>
        <nav>
            <ul>
                <li><a href="groups.php">Управление группами</a></li>
                <li><a href="subjects.php">Управление предметами</a></li>
                <li><a href="teachers.php">Управление преподавателями</a></li>
                <li><a href="classrooms.php">Управление аудиториями</a></li>
                <li><a href="schedule.php">Управление расписанием</a></li>
            </ul>
        </nav>
    </div>

    <script src="../js/admin.js"></script>
</body>
</html>

<?php
// Включаем подвал
include('../templates/footer.php');
?>
