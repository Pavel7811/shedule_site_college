<?php
require_once('../includes/config.php');
require_once('../includes/functions.php');

// Проверка авторизации администратора
check_admin_auth();

// Получение ID элемента расписания из GET-параметра
$schedule_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($schedule_id > 0) {
    $schedule_item = get_schedule_item($schedule_id);
    if (!$schedule_item) {
        header("Location: schedule.php");
        exit;
    }
} else {
    header("Location: schedule.php");
    exit;
}

// Получение списка групп, предметов, преподавателей и аудиторий
$groups = get_groups();
$subjects = get_subjects();
$teachers = get_teachers();
$classrooms = get_classrooms();

// Обработка формы редактирования элемента расписания
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_schedule_item'])) {
    $group_id = intval($_POST['group_id']);
    $subject_id = intval($_POST['subject_id']);
    $teacher_id = intval($_POST['teacher_id']);
    $classroom_id = intval($_POST['classroom_id']);
    $day_of_week = intval($_POST['weekday']);
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    if ($group_id > 0 && $subject_id > 0 && $teacher_id > 0 && $classroom_id > 0 && $day_of_week >= 1 && $day_of_week <= 6 && !empty($start_time) && !empty($end_time)) {
        $db = get_db_connection();
        $sql = "UPDATE schedule SET group_id = :group_id, subject_id = :subject_id, teacher_id = :teacher_id, classroom_id = :classroom_id, day_of_week = :day_of_week, start_time = :start_time, end_time = :end_time WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':group_id' => $group_id,
            ':subject_id' => $subject_id,
            ':teacher_id' => $teacher_id,
            ':classroom_id' => $classroom_id,
            ':day_of_week' => $day_of_week,
            ':start_time' => $start_time,
            ':end_time' => $end_time,
            ':id' => $schedule_id,
        ]);

        header("Location: schedule.php");
        exit;
    }
}

// Включаем шапку
include('../templates/header.php');
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактировать элемент расписания - Административная панель</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="container">
        <h1>Редактировать элемент расписания</h1>
        <a href="schedule.php">Назад к расписанию</a>
        <hr>

        <form method="post" id="edit_schedule_item_form">
            <label for="group_id">Группа:</label>
            <select id="group_id" name="group_id" required>
            <?php foreach ($groups as $group) : ?>
                    <option value="<?php echo $group['id']; ?>" <?php echo ($group['id'] == $schedule_item['group_id']) ? 'selected' : ''; ?>><?php echo $group['name']; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="subject_id">Предмет:</label>
            <select id="subject_id" name="subject_id" required>
                <?php foreach ($subjects as $subject) : ?>
                    <option value="<?php echo $subject['id']; ?>" <?php echo ($subject['id'] == $schedule_item['subject_id']) ? 'selected' : ''; ?>><?php echo $subject['name']; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="teacher_id">Преподаватель:</label>
            <select id="teacher_id" name="teacher_id" required>
                <?php foreach ($teachers as $teacher) : ?>
                    <option value="<?php echo $teacher['id']; ?>" <?php echo ($teacher['id'] == $schedule_item['teacher_id']) ? 'selected' : ''; ?>><?php echo $teacher['name']; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="classroom_id">Аудитория:</label>
            <select id="classroom_id" name="classroom_id" required>
                <?php foreach ($classrooms as $classroom) : ?>
                    <option value="<?php echo $classroom['id']; ?>" <?php echo ($classroom['id'] == $schedule_item['classroom_id']) ? 'selected' : ''; ?>><?php echo $classroom['name']; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="weekday">День недели:</label>
            <select id="weekday" name="weekday" required>
                <?php for ($i = 1; $i <= 6; $i++) : ?>
                    <option value="<?php echo $i; ?>" <?php echo ($i == $schedule_item['day_of_week']) ? 'selected' : ''; ?>><?php echo get_day_name($i); ?></option>
                <?php endfor; ?>
            </select>

            <label for="start_time">Время начала:</label>
            <input type="time" id="start_time" name="start_time" value="<?php echo $schedule_item['start_time']; ?>" required>

            <label for="end_time">Время окончания:</label>
            <input type="time" id="end_time" name="end_time" value="<?php echo $schedule_item['end_time']; ?>" required>

            <input type="submit" name="edit_schedule_item" value="Сохранить изменения">
        </form>
    </div>
</body>
</html>

<?php
// Включаем подвал
include('../templates/footer.php');
?>

