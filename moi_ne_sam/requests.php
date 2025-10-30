<?php
require_once "db/db.php";

if (!isLoggedIn()) {
    header("Location: index.php");
    exit;
}

$user = getUserInfo();
$requests = getUserRequests($user['id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мои заявки</title>
    <link rel='stylesheet' href='style/style.css'>
</head>
<body>
    <header>
        <h1>Мои заявки</h1>
    </header>
    
    <?php include 'struktura.php'; ?>
    
    <main>
        <h2>Список заявок</h2>
        
        <?php if (empty($requests)): ?>
            <p>У вас пока нет заявок</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Адрес</th>
                        <th>Тип услуги</th>
                        <th>Дата</th>
                        <th>Время</th>
                        <th>Тип оплаты</th>
                        <th>Статус</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($requests as $request): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($request['address']); ?></td>
                        <td><?php echo htmlspecialchars($request['sevice_name']); ?></td>
                        <td><?php echo htmlspecialchars($request['data']); ?></td>
                        <td><?php echo htmlspecialchars($request['time']); ?></td>
                        <td><?php echo htmlspecialchars($request['pay_type_id']); ?></td>
                        <td><?php echo htmlspecialchars($request['status_name']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        
        <a href="create_request.php" class="button">Создать новую заявку</a>
    </main>
</body>
</html>