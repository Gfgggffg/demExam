<?php
$pageTitle = "Панель администратора";
require_once "db/db.php";

if (!isset($_SESSION['user']) || $_SESSION['user']['user_type_id'] != 2) {
    header("Location: index.php");
    exit();
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_status'])) {
    $service_id = (int)$_POST['service_id'];
    $new_status = (int)$_POST['status_id'];
    
    $update_query = "UPDATE service SET status_id = '$new_status' WHERE id_service = '$service_id'";
    if (mysqli_query($db, $update_query)) {
        $message = "✅ Статус заявления успешно изменен!";
    } else {
        $message = "❌ Ошибка при изменении статуса: " . mysqli_error($db);
    }
}

$services_query = "SELECT s.*, u.surname, u.name, u.otchestvo, ss.name_status 
                   FROM service s 
                   LEFT JOIN user u ON s.user_id = u.id_user 
                   LEFT JOIN status ss ON s.status_id = ss.id_status 
                   ORDER BY s.data DESC, s.time DESC";
$services_result = mysqli_query($db, $services_query);

$statuses_query = mysqli_query($db, "SELECT * FROM status");
$statuses = [];
while ($row = mysqli_fetch_assoc($statuses_query)) {
    $statuses[$row['id_status']] = $row;
}

ob_start();
?>

<?php if ($message): ?>
    <div class="message <?php echo strpos($message, '✅') !== false ? 'success' : 'error'; ?>">
        <?php echo $message; ?>
    </div>
<?php endif; ?>

<h2>Все заявления о нарушениях</h2>

<?php if ($services_result && mysqli_num_rows($services_result) > 0): ?>
    <div class="cards-container">
        <?php while ($service = mysqli_fetch_assoc($services_result)): ?>
            <div class="card">
                <div class="card-header">
                    Заявление #<?= $service['id_service'] ?>
                    <span class="status-badge status-<?= $service['status_id'] ?>">
                        <?= htmlspecialchars($service['name_status']) ?>
                    </span>
                </div>
                <div class="card-field">
                    <strong>🚗 Автомобиль:</strong> <?= htmlspecialchars($service['car_number']) ?>
                </div>
                <div class="card-field">
                    <strong>⚠️ Нарушение:</strong> <?= htmlspecialchars($service['violation_description']) ?>
                </div>
                <div class="card-field">
                    <strong>📅 Дата/время:</strong> <?= htmlspecialchars($service['data']) ?> в <?= htmlspecialchars($service['time']) ?>
                </div>
                <div class="card-field">
                    <strong>👤 Заявитель:</strong> <?= htmlspecialchars($service['surname'] . ' ' . $service['name'] . ' ' . $service['otchestvo']) ?>
                </div>
                <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 2px solid var(--gray-light);">
                    <form method="POST" style="display: flex; flex-direction: column; gap: 0.75rem;">
                        <input type="hidden" name="service_id" value="<?= $service['id_service'] ?>">
                        <label>Изменить статус:</label>
                        <select name="status_id" required style="padding: 0.875rem 1rem; border: 2px solid var(--gray-light); border-radius: var(--radius-sm);">
                            <option value="">Выберите статус</option>
                            <?php foreach ($statuses as $id => $status): ?>
                                <option value="<?= $id ?>" <?= $id == $service['status_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($status['name_status']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" name="change_status">📝 Обновить статус</button>
                    </form>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
<?php else: ?>
    <div class="no-zayavki">
        <p style="text-align: center; padding: 3rem; color: var(--gray); font-size: 1.1rem;">
            📭 Заявлений о нарушениях нет
        </p>
    </div>
<?php endif; ?>

<p class="text-center mt-20"><a href="zayavka.php" class="create-link">← Вернуться к моим заявлениям</a></p>

<?php
$pageContent = ob_get_clean();
require_once "struktura.php";
?>