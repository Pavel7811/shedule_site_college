<?php
// Включаем файл с конфигурацией и функциями
require_once('../includes/config.php');
require_once('../includes/functions.php');

// Выход из административной панели (реализуйте функцию logout_admin() в файле functions.php)
logout_admin();

// Перенаправление на корневой index.php
header('Location: ../index.php');
exit;
?>
