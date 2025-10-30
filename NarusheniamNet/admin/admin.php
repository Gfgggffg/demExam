<?php
require_once "db/db.php";

if (!isLoggedIn() || !isAdmin()) {
    header("Location: index.php");
    exit;
}

$users = getAllUsers();
$requests = getAllRequests();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ панель</title>
    <link rel='stylesheet' href='style/style.css'>
</head>
<body>
    <header>
        <h1>Админ панель</h1>
    </header>
    
    <?php include 'struktura.php'; ?>
    
    <main>
        <h2>Управление пользователями</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ФИО</th>
                    <th>Email</th>
                    <th>Логин</th>
                    <th>Телефон</th>
                    <th>Роль</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['id_user']; ?></td>
                    <td><?php echo $user['surname'] . ' ' . $user['name'] . ' ' . $user['otchestvo']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['phone']; ?></td>
                    <td><?php echo $user['user_type_id'] == 1 ? 'Администратор' : 'Пользователь'; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Все заявки</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Пользователь</th>
                    <th>Адрес</th>
                    <th>Услуга</th>
                    <th>Дата</th>
                    <th>Время</th>
                    <th>Оплата</th>
                    <th>Статус</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($requests as $request): ?>
                <tr>
                    <td><?php echo $request['id_service']; ?></td>
                    <td><?php echo $request['surname'] . ' ' . $request['name'] . ' ' . $request['otchestvo']; ?></td>
                    <td><?php echo $request['address']; ?></td>
                    <td><?php echo $request['sevice_name']; ?></td>
                    <td><?php echo $request['data']; ?></td>
                    <td><?php echo $request['time']; ?></td>
                    <td><?php echo $request['pay_type_id']; ?></td>
                    <td><?php echo $request['status_name']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>