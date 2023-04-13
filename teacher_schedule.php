<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

$teachers = get_teachers();
$selected_teacher_id = isset($_GET['teacher_id']) ? intval($_GET['teacher_id']) : null;
$schedule = $selected_teacher_id ? get_schedule_for_teacher($selected_teacher_id) : [];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Расписание по преподавателям</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <h1>Расписание по преподавателям</h1>
        
        <form method="GET">
            <label for="teacher_id">Выберите преподавателя:</label>
            <select name="teacher_id" id="teacher_id" onchange="this.form.submit()">
                <option value="">-- Все преподаватели --</option>
                <?php foreach ($teachers as $teacher) : ?>
                    <option value="<?= $teacher['id'] ?>" <?= ($selected_teacher_id == $teacher['id']) ? 'selected' : '' ?>><?= htmlspecialchars($teacher['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </form>
        
        <?php if ($schedule) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Преподаватель</th>
                        <th>Предмет</th>
                        <th>Группа</th>
                        <th>Аудитория</th>
                        <th>День недели</th>
                        <th>Время начала</th>
                        <th>Время конца</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($schedule as $item) : ?>
                        <tr>
                            <td><?= htmlspecialchars($item['teacher_name']) ?></td>
                            <td><?= htmlspecialchars($item['subject_name']) ?></td>
                            <td><?= htmlspecialchars($item['group_name']) ?></td>
                            <td><?= htmlspecialchars($item['classroom_name']) ?></td>
                            <td><?= htmlspecialchars(get_day_name($item['weekday'])) ?></td>
                            <td><?= htmlspecialchars($item['start_time']) ?></td>
                            <td><?= htmlspecialchars($item['end_time']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>Расписание не найдено.</p>
        <?php endif; ?>
    </main>

    <?php include 'templates/footer.php'; ?>
</body>
</html>
