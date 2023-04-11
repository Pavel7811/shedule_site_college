<?php
require_once('includes/config.php');
require_once('includes/functions.php');

// Проверка отправки формы
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Проверка имени пользователя и пароля
    admin_login($username, $password);
    if ($_SESSION['admin_logged_in']) {
        // Перенаправление на административную панель
        header('Location: admin/index.php');
        exit();
    } else {
        $error_message = 'Неправильное имя пользователя или пароль.';
    }
}

include('templates/header.php');
?>

<div class="container">
    <h1 class="mt-4 mb-3">Авторизация администратора</h1>
    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <form action="login.php" method="post" class="form-login">
        <div class="form-group">
            <label for="username">Имя пользователя:</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Пароль:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Войти</button>
    </form>
</div>

<?php include('templates/footer.php'); ?>
