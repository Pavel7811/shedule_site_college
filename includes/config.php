<?php
// Настройки ошибок
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Путь к файлу базы данных SQLite
define('DB_FILE', __DIR__ . '/../database/college_schedule.sqlite3');

// Настройки сессии
session_start();
