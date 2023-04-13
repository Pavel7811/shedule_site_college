<?php
require_once('config.php');
require_once('database.php');

// Проверка авторизации администратора
function check_admin_auth() {
    // Если пользователь не авторизован, перенаправить на страницу авторизации (реализуйте login.php)
    if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
        header('Location: ../login.php');
        exit();
    }
}

// Авторизация администратора
function admin_login($username, $password) {
    // Задаем допустимые имя пользователя и пароль
    $valid_username = "admin";
    $valid_password = "12345678";

    // Сравниваем введенные значения с допустимыми
    if ($username === $valid_username && $password === $valid_password) {
        // Если имя пользователя и пароль верны, установить флаг авторизации в сессии
        $_SESSION['admin_logged_in'] = true;
    } else {
        // Если имя пользователя или пароль неверны, устанавливаем флаг авторизации в false
        $_SESSION['admin_logged_in'] = false;
    }
}

// Получение списка групп из базы данных
function get_groups() {
    $db = get_db_connection();
    $sql = "SELECT * FROM groups ORDER BY name";
    $result = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

// Получение списка предметов из базы данных
function get_subjects() {
    $db = get_db_connection();
    $sql = "SELECT * FROM subjects ORDER BY name";
    $result = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

// Получение списка преподавателей из базы данных
function get_teachers() {
    $db = get_db_connection();
    $sql = "SELECT * FROM teachers ORDER BY name";
    $result = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

// Получение информации о преподавателе из базы данных
function get_teacher($teacher_id) {
    $db = get_db_connection();
    $sql = "SELECT * FROM teachers WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->execute([':id' => $teacher_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}


// Получение списка аудиторий из базы данных
function get_classrooms() {
    $db = get_db_connection();
    $sql = "SELECT * FROM classrooms ORDER BY name";
    $result = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

// Получение расписания для определенной группы
function get_schedule_for_group($group_id) {
    $db = get_db_connection();
    $sql = "SELECT schedule.id, groups.name AS group_name, subjects.name AS subject_name, 
            teachers.name AS teacher_name, classrooms.name AS classroom_name, 
            schedule.day_of_week AS weekday, schedule.start_time AS start_time, schedule.end_time AS end_time 
            FROM schedule 
            JOIN groups ON schedule.group_id = groups.id 
            JOIN subjects ON schedule.subject_id = subjects.id 
            JOIN teachers ON schedule.teacher_id = teachers.id 
            JOIN classrooms ON schedule.classroom_id = classrooms.id 
            WHERE schedule.group_id = :group_id
            ORDER BY schedule.day_of_week, schedule.start_time";
    $stmt = $db->prepare($sql);
    $stmt->execute([':group_id' => $group_id]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}



// Получение информации о предмете из базы данных
function get_subject($subject_id) {
    $db = get_db_connection();
    $sql = "SELECT * FROM subjects WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->execute([':id' => $subject_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

// Получение информации о группе из базы данных
function get_group($group_id) {
    $db = get_db_connection();
    $sql = "SELECT * FROM groups WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->execute([':id' => $group_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

// Получение информации об аудитории из базы данных
function get_classroom($classroom_id) {
    $db = get_db_connection();
    $sql = "SELECT * FROM classrooms WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->execute([':id' => $classroom_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function get_schedule_items() {
    $db = get_db_connection();
    $sql = "SELECT schedule.id, groups.name AS group_name, subjects.name AS subject_name, 
            teachers.name AS teacher_name, classrooms.name AS classroom_name, 
            schedule.day_of_week AS weekday, schedule.start_time AS time 
            FROM schedule 
            JOIN groups ON schedule.group_id = groups.id 
            JOIN subjects ON schedule.subject_id = subjects.id 
            JOIN teachers ON schedule.teacher_id = teachers.id 
            JOIN classrooms ON schedule.classroom_id = classrooms.id 
            ORDER BY schedule.day_of_week, schedule.start_time";
    $result = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function get_day_name($weekday) {
    $days = ['Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота', 'Воскресенье'];
    return isset($days[$weekday - 1]) ? $days[$weekday - 1] : '';
}

// Получение информации об элементе расписания из базы данных
function get_schedule_item($schedule_id) {
    $db = get_db_connection();
    $sql = "SELECT * FROM schedule WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->execute([':id' => $schedule_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function logout_admin() {

    // Удаляем информацию об администраторе из сессии
    unset($_SESSION['admin_id']);
    unset($_SESSION['admin_name']);

    // Завершаем сессию
    session_destroy();
}

function get_schedule_for_teacher($teacher_id) {
    $db = get_db_connection();
    $sql = "SELECT schedule.id, groups.name AS group_name, subjects.name AS subject_name, 
            teachers.name AS teacher_name, classrooms.name AS classroom_name, 
            schedule.day_of_week AS weekday, schedule.start_time AS start_time, schedule.end_time AS end_time 
            FROM schedule 
            JOIN groups ON schedule.group_id = groups.id 
            JOIN subjects ON schedule.subject_id = subjects.id 
            JOIN teachers ON schedule.teacher_id = teachers.id 
            JOIN classrooms ON schedule.classroom_id = classrooms.id 
            WHERE schedule.teacher_id = :teacher_id
            ORDER BY schedule.day_of_week, schedule.start_time";
    $stmt = $db->prepare($sql);
    $stmt->execute([':teacher_id' => $teacher_id]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

