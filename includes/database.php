<?php
require_once('config.php');

// Получение подключения к базе данных SQLite
function get_db_connection() {
    try {
        $db = new PDO('sqlite:' . DB_FILE);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Ошибка подключения к базе данных: " . $e->getMessage());
    }
    return $db;
}

// Создание таблиц в базе данных, если они не существуют
function create_tables_if_not_exists() {
    $db = get_db_connection();
    $queries = [
        "CREATE TABLE IF NOT EXISTS groups (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL)",
        "CREATE TABLE IF NOT EXISTS subjects (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL)",
        "CREATE TABLE IF NOT EXISTS teachers (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL)",
        "CREATE TABLE IF NOT EXISTS classrooms (id INTEGER PRIMARY KEY AUTOINCREMENT, number TEXT NOT NULL)",
        "CREATE TABLE IF NOT EXISTS schedule (id INTEGER PRIMARY KEY AUTOINCREMENT, group_id INTEGER NOT NULL, subject_id INTEGER NOT NULL, teacher_id INTEGER NOT NULL, classroom_id INTEGER NOT NULL, day_of_week INTEGER NOT NULL, start_time TEXT NOT NULL, end_time TEXT NOT NULL, FOREIGN KEY(group_id) REFERENCES groups(id), FOREIGN KEY(subject_id) REFERENCES subjects(id), FOREIGN KEY(teacher_id) REFERENCES teachers(id), FOREIGN KEY(classroom_id) REFERENCES classrooms(id))"
    ];

    foreach ($queries as $query) {
        $db->exec($query);
    }
}

// Вызываем функцию для создания таблиц, если они не существуют
create_tables_if_not_exists();
