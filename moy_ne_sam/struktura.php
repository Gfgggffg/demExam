<?php
require_once "db/db.php"; 
$navLinks = [];
$showAuthLinks = true;

// Check if user is logged in via session
if (isset($_SESSION['user'])) {
    $showAuthLinks = false;
    $user = $_SESSION['user'];
    $userTypeId = $user['user_type_id'] ?? null;
    
    if ($userTypeId == 2) {
        $navLinks = [
            ['href' => 'admin.php', 'text' => '👑 Панель администратора'],
        ];
    } else {
        $navLinks = [
            ['href' => 'zayavka.php', 'text' => '📋 Мои заявки'],
            ['href' => 'create_zayavka.php', 'text' => '➕ Создать заявку'],
        ];
    }
    $navLinks[] = ['href' => 'logout.php', 'text' => '🚪 Выход'];
} else {
    $navLinks = [
        ['href' => 'index.php', 'text' => '🔐 Авторизация'],
        ['href' => 'registration.php', 'text' => '📝 Регистрация'],
    ];
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мой не сам | <?php echo $pageTitle; ?></title>
    <link rel="icon" href="images/logo.jpeg">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="header-container">
            <img src="images/logo.jpeg" alt="Логотип Мой не сам">
            <h1>Мой не сам</h1>
        </div>
    </header>

    <nav>
        <div class="nav-container">
            <?php foreach ($navLinks as $link): ?>
                <a href="<?php echo htmlspecialchars($link['href']); ?>">
                    <?php echo htmlspecialchars($link['text']); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </nav>

    <main>
        <h1><?php echo $pageTitle; ?></h1>
        <div class="content">
            <?php 
            if (isset($pageContent) && !empty($pageContent)) {
                echo $pageContent;
            }
            ?>
        </div>
    </main>

    <footer>
        <h3>© 2025 Сервис "Мой не сам". Все права защищены.</h3>
    </footer>

    <script src="js/script.js"></script>
</body>
</html>