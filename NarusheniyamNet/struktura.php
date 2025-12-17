<?php
require_once "db/db.php"; 
$navLinks = [];
$showAuthLinks = true;

if (isset($_SESSION['user'])) {
    $showAuthLinks = false;
    $user = $_SESSION['user'];
    $userTypeId = $user['user_type_id'] ?? null;
    
    if ($userTypeId == 2) {
        $navLinks = [
            ['href' => 'admin.php', 'text' => '👨‍💼 Панель администратора'],
        ];
    } else {
        $navLinks = [
            ['href' => 'zayavka.php', 'text' => '📋 Список заявок'],
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
    <title>НарушениямНет | <?php echo $pageTitle; ?></title>
    <link rel='icon' href='images/logo.jpeg'>
    <link rel='stylesheet' href='css/style.css'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <img src='images/logo.jpeg' alt='Логотип НарушениямНет'>
        <h1>НарушениямНет</h1>
    </header>

    <nav>
        <?php foreach ($navLinks as $link): ?>
            <a href="<?php echo htmlspecialchars($link['href']); ?>">
                <?php echo htmlspecialchars($link['text']); ?>
            </a>
        <?php endforeach; ?>
    </nav>

    <main>
        <h1><?php echo $pageTitle;?></h1>
        <div class="content">
            <?php 
            if (isset($pageContent) && !empty($pageContent)) {
                echo $pageContent;
            }
            ?>
        </div>
        <footer>
            <h3>© 2025 Система мониторинга нарушений ПДД</h3>
        </footer>
    </main>

    <script src="js/script.js"></script>
</body>
</html>