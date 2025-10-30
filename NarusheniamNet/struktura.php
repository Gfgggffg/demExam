<nav>
    <a href='index.php'>Главное</a>
    <?php if (isLoggedIn()): ?>
        <?php if (isAdmin()): ?>
            <a href='admin.php'>Админ</a>
        <?php else: ?>
            <a href='requests.php'>Мои заявки</a>
            <a href='create_request.php'>Создать заявку</a>
        <?php endif; ?>
        <span style="margin-left: auto;">
            Добро пожаловать, <?php echo getUserInfo()['surname'] . ' ' . getUserInfo()['name'] . ' ' . getUserInfo()['otchestvo']; ?>!
            <br>Время входа: <?php echo getUserInfo()['login_time']; ?>
        </span>
        <a href='logout.php'>Выход</a>
    <?php else: ?>
        <a href='index.php'>Вход</a>
        <a href='register.php'>Регистрация</a>
    <?php endif; ?>
</nav>