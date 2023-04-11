<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

$groups = get_groups();
$selected_group_id = isset($_GET['group_id']) ? intval($_GET['group_id']) : null;
$schedule = $selected_group_id ? get_schedule_for_group($selected_group_id) : [];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Расписание колледжа</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <h1>Расписание занятий</h1>
        
        <form method="GET">
            <label for="group_id">Выберите группу:</label>
            <select name="group_id" id="group_id" onchange="this.form.submit()">
                <option value="">-- Все группы --</option>
                <?php foreach ($groups as $group) : ?>
                    <option value="<?= $group['id'] ?>" <?= ($selected_group_id == $group['id']) ? 'selected' : '' ?>><?= htmlspecialchars($group['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </form>
        
        <?php if ($schedule) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Группа</th>
                        <th>Предмет</th>
                        <th>Преподаватель</th>
                        <th>Аудитория</th>
                        <th>День недели</th>
                        <th>Время начала</th>
                        <th>Время конца</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($schedule as $item) : ?>
                        <tr>
                            <td><?= htmlspecialchars($item['group_name']) ?></td>
                            <td><?= htmlspecialchars($item['subject_name']) ?></td>
                            <td><?= htmlspecialchars($item['teacher_name']) ?></td>
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
