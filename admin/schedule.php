<?php
require_once('../includes/config.php');
require_once('../includes/functions.php');

// Проверка авторизации администратора
check_admin_auth();

// Обработка формы добавления в расписание
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_schedule'])) {
    $group_id = intval($_POST['group_id']);
    $subject_id = intval($_POST['subject_id']);
    $teacher_id = intval($_POST['teacher_id']);
    $classroom_id = intval($_POST['classroom_id']);
    $day_of_week = intval($_POST['day_of_week']);
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    $db = get_db_connection();
    $sql = "INSERT INTO schedule (group_id, subject_id, teacher_id, classroom_id, day_of_week, start_time, end_time) VALUES (:group_id, :subject_id, :teacher_id, :classroom_id, :day_of_week, :start_time, :end_time)";
    $stmt = $db->prepare($sql);
    $stmt->execute([':group_id' => $group_id, ':subject_id' => $subject_id, ':teacher_id' => $teacher_id, ':classroom_id' => $classroom_id, ':day_of_week' => $day_of_week, ':start_time' => $start_time, ':end_time' => $end_time]);
}

$groups = get_groups();
$subjects = get_subjects();
$teachers = get_teachers();
$classrooms = get_classrooms();

// Включаем шапку
include('../templates/header.php');
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Расписание занятий - Административная панель</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="container">
        <h1>Расписание занятий</h1>
        <a href="index.php">Назад к главной административной панели</a>
        <hr>

        <form method="post" id="add_schedule_form">
            <label for="group_id">Группа:</label>
            <select id="group_id" name="group_id">
                <?php foreach ($groups as $group): ?>
                    <option value="<?php echo $group['id']; ?>"><?php echo htmlspecialchars($group['name']); ?></option>
                <?php endforeach; ?>
            </select>
            <br>

            <label for="subject_id">Предмет:</label>
            <select id="subject_id" name="subject_id">
                <?php foreach ($subjects as $subject): ?>
                    <option value="<?php echo $subject['id']; ?>"><?php echo htmlspecialchars($subject['name']); ?></option>
                <?php endforeach; ?>
            </select>
            <br>

            <label for="teacher_id">Преподаватель:</label>
            <select id="teacher_id" name="teacher_id">
                <?php foreach ($teachers as $teacher): ?>
                    <option value="<?php echo $teacher['id']; ?>"><?php echo htmlspecialchars($teacher['name']); ?></option>
                <?php endforeach; ?>
            </select>
            <br>

            <label for="classroom_id">Аудитория:</label>
            <select id="classroom        _id" name="classroom_id">
            <?php foreach ($classrooms as $classroom): ?>
                <option value="<?php echo $classroom['id']; ?>"><?php echo htmlspecialchars($classroom['name']); ?></option>
            <?php endforeach; ?>
        </select>
        <br>

        <label for="day_of_week">День недели:</label>
        <select id="day_of_week" name="day_of_week">
            <?php for ($i = 1; $i <= 7; $i++): ?>
                <option value="<?php echo $i; ?>"><?php echo get_day_name($i); ?></option>
            <?php endfor; ?>
        </select>
        <br>

        <label for="start_time">Время начала:</label>
        <input type="time" id="start_time" name="start_time" required>
        <br>

        <label for="end_time">Время окончания:</label>
        <input type="time" id="end_time" name="end_time" required>
        <br>

        <input type="submit" value="Добавить в расписание" name="add_schedule">
    </form>
    <hr>

    <h2>Список занятий:</h2>
    <table>
        <tr>
            <th>Группа</th>
            <th>Предмет</th>
            <th>Преподаватель</th>
            <th>Аудитория</th>
            <th>День недели</th>
            <th>Время</th>
            <th>Действия</th>
        </tr>
        <?php
        $schedule_items = get_schedule_items();
        foreach ($schedule_items as $item) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($item['group_name']) . "</td>";
            echo "<td>" . htmlspecialchars($item['subject_name']) . "</td>";
            echo "<td>" . htmlspecialchars($item['teacher_name']) . "</td>";
            echo "<td>" . htmlspecialchars($item['classroom_name']) . "</td>";
            echo "<td>" . get_day_name($item['weekday']) . "</td>";
            echo "<td>" . htmlspecialchars($item['time']) . "</td>";
            echo "<td>";
            echo "<a href='edit_schedule_item.php?id=" . htmlspecialchars($item['id']) . "'>Редактировать</a> | ";
            echo "<a href='delete_schedule_item.php?id=" . htmlspecialchars($item['id']) . "'>Удалить</a>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>

<script src="../js/admin.js"></script>
</body>
</html>
<?php
// Включаем подвал
include('../templates/footer.php');
?>
