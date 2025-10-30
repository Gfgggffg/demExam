<?php
require_once "db/db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мой не сам</title>
    <link rel='icon' href='images/nugget.jpg'>
    <link rel='stylesheet' href='style/style.css'>
</head>
<body>
    <header>
        <img src='images/nugget.jpg' alt='логотип'> 
        <h1>Мой не сам</h1> 
    </header>
    
    <?php include 'struktura.php'; ?>
    
    <main>    
        <?php if (!isLoggedIn()): ?>
            <h1>Авторизация</h1> 
            <form method="POST" action="auth.php">
                <label>Логин
                    <input type="text" name="login" required minlength="3"> 
                </label> 
                <label>Пароль
                    <input type="password" name="password" required minlength="6"> 
                </label> 
                <button type="submit">Войти</button>
            </form>
            
            <p>Нет аккаунта? <a href="register.php">Зарегистрируйтесь</a></p>
            
            <p class="error">
                <?php
                if (isset($_GET['error'])) {
                    switch ($_GET['error']) {
                        case 'empty':
                            echo "Заполните все поля";
                            break;
                        case 'invalid':
                            echo "Неверный логин или пароль";
                            break;
                        case 'not_found':
                            echo "Пользователь не найден";
                            break;
                    }
                }
                if (isset($_GET['message']) && $_GET['message'] === 'registered') {
                    echo "Регистрация успешна! Теперь вы можете войти.";
                }
                ?>
            </p>
        <?php else: ?>
            <?php
            $user = getUserInfo();
            if (isAdmin()) {
                header("Location: admin.php");
                exit;
            } else {
                header("Location: requests.php");
                exit;
            }
            ?>
        <?php endif; ?>
    </main>
    
    <footer>
        <h3>2025</h3>
    </footer>
    <script src='script/script.js'></script>
</body>
</html>