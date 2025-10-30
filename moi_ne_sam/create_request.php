<?php
require_once "db/db.php";

if (!isLoggedIn()) {
    header("Location: index.php");
    exit;
}

$service_types = getServiceTypes();
$pay_types = getPayTypes();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = getUserInfo();
    $address = strip_tags($_POST['address'] ?? '');
    $service_type_id = intval($_POST['service_type_id'] ?? 0);
    $data = $_POST['data'] ?? '';
    $time = $_POST['time'] ?? '';
    $pay_type_id = intval($_POST['pay_type_id'] ?? 0);
    
    if (createRequest($user['id'], $address, $service_type_id, $data, $time, $pay_type_id)) {
        header("Location: requests.php?message=created");
        exit;
    } else {
        $error = "Ошибка при создании заявки";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создать заявку</title>
    <link rel='stylesheet' href='style/style.css'>
</head>
<body>
    <header>
        <h1>Создать заявку</h1>
    </header>
    
    <?php include 'struktura.php'; ?>
    
    <main>
        <h2>Новая заявка</h2>
        
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        
        <form method="POST" action="create_request.php">
            <label>Адрес
                <input type="text" name="address" required>
            </label>
            <label>Тип услуги
                <select name="service_type_id" required>
                    <option value="">Выберите тип услуги</option>
                    <?php foreach ($service_types as $type): ?>
                        <option value="<?php echo $type['Id_service_type']; ?>">
                            <?php echo htmlspecialchars($type['sevice_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>Дата
                <input type="date" name="data" required>
            </label>
            <label>Время
                <input type="time" name="time" required>
            </label>
            <label>Тип оплаты
                <select name="pay_type_id" required>
                    <option value="">Выберите тип оплаты</option>
                    <?php foreach ($pay_types as $type): ?>
                        <option value="<?php echo $type['id_pay_type']; ?>">
                            <?php echo htmlspecialchars($type['pay_type_id']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
            <button type="submit">Создать заявку</button>
        </form>
    </main>
</body>
</html>