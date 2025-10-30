<?php
require_once "db/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = strip_tags($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $surname = strip_tags($_POST['surname'] ?? '');
    $name = strip_tags($_POST['name'] ?? '');
    $otchestvo = strip_tags($_POST['otchestvo'] ?? '');
    $phone = strip_tags($_POST['phone'] ?? '');

    $errors = [];

    // Валидация
    if (empty($login) || strlen($login) < 3) {
        $errors[] = "Логин должен быть не менее 3 символов";
    }

    if (empty($password) || strlen($password) < 6) {
        $errors[] = "Пароль должен быть не менее 6 символов";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Пароли не совпадают";
    }

    if (!$email) {
        $errors[] = "Введите корректный email";
    }

    // Проверка существующего пользователя
    if (userExists($login, $email)) {
        $errors[] = "Пользователь с таким логином или email уже существует";
    }

    if (empty($errors)) {
        // Регистрация пользователя
        if (registerUser($login, $password, $email, $surname, $name, $otchestvo, $phone)) {
            header("Location: index.php?message=registered");
            exit;
        } else {
            $errors[] = "Ошибка при регистрации";
        }
    }

    // Вывод ошибок
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p class='error'>$error</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel='stylesheet' href='style/style.css'>
</head>
<body>
    <header>
        <h1>Регистрация</h1>
    </header>
    
    <?php include 'struktura.php'; ?>
    
    <main>
        <form method="POST" action="register.php">
            <label>Фамилия
                <input type="text" name="surname" required>
            </label>
            <label>Имя
                <input type="text" name="name" required>
            </label>
            <label>Отчество
                <input type="text" name="otchestvo" required>
            </label>
            <label>Телефон
                <input type="tel" name="phone" required>
            </label>
            <label>Email
                <input type="email" name="email" required>
            </label>
            <label>Логин
                <input type="text" name="login" required minlength="3">
            </label>
            <label>Пароль
                <input type="password" name="password" required minlength="6">
            </label>
            <label>Подтверждение пароля
                <input type="password" name="confirm_password" required>
            </label>
            <button type="submit">Зарегистрироваться</button>
        </form>
        <p>Уже есть аккаунт? <a href="index.php">Войдите</a></p>
    </main>
</body>
</html>