<?php
session_start();
require_once "config.php";

// Проверка существования пользователя
function userExists($login, $email) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id_user FROM user WHERE username = ? OR email = ?");
    $stmt->execute([$login, $email]);
    return $stmt->fetch() !== false;
}

// Регистрация пользователя
function registerUser($login, $password, $email, $surname = '', $name = '', $otchestvo = '', $phone = '') {
    global $pdo;
    
    // Без хеширования пароля
    $stmt = $pdo->prepare("INSERT INTO user (surname, name, otchestvo, phone, email, username, password, user_type_id) VALUES (?, ?, ?, ?, ?, ?, ?, 2)");
    return $stmt->execute([$surname, $name, $otchestvo, $phone, $email, $login, $password]);
}

// Проверка логина и пароля - БЕЗ ХЕШИРОВАНИЯ
function find($login, $password) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->execute([$login]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && $user['password'] === $password) {
        $_SESSION['user'] = [
            'id' => $user['id_user'],
            'login' => $user['username'],
            'name' => $user['name'],
            'surname' => $user['surname'],
            'otchestvo' => $user['otchestvo'],
            'email' => $user['email'],
            'role' => ($user['user_type_id'] == 1) ? 'admin' : 'user',
            'login_time' => date('Y-m-d H:i:s')
        ];
        return true;
    }
    return false;
}

// Проверка авторизации
function isLoggedIn() {
    return isset($_SESSION['user']);
}

// Получение информации о пользователе
function getUserInfo() {
    return $_SESSION['user'] ?? null;
}

// Проверка роли администратора
function isAdmin() {
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
}

// Получение заявок пользователя
function getUserRequests($user_id) {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT s.*, st.sevice_name, p.pay_type_id, st2.status_name 
        FROM service s 
        LEFT JOIN service_type st ON s.service_type_id = st.Id_service_type 
        LEFT JOIN pay_type p ON s.pay_type_id = p.id_pay_type 
        LEFT JOIN status st2 ON s.status_id = st2.id_status 
        WHERE s.user_id = ?
    ");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Создание новой заявки
function createRequest($user_id, $address, $service_type_id, $data, $time, $pay_type_id) {
    global $pdo;
    $stmt = $pdo->prepare("
        INSERT INTO service (address, user_id, service_type_id, data, time, pay_type_id, status_id) 
        VALUES (?, ?, ?, ?, ?, ?, 1)
    ");
    return $stmt->execute([$address, $user_id, $service_type_id, $data, $time, $pay_type_id]);
}

// Получение типов услуг
function getServiceTypes() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM service_type");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Получение типов оплаты
function getPayTypes() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM pay_type");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Получение всех пользователей (для админки)
function getAllUsers() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM user");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Получение всех заявок (для админки)
function getAllRequests() {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT s.*, st.sevice_name, p.pay_type_id, st2.status_name, u.surname, u.name, u.otchestvo 
        FROM service s 
        LEFT JOIN service_type st ON s.service_type_id = st.Id_service_type 
        LEFT JOIN pay_type p ON s.pay_type_id = p.id_pay_type 
        LEFT JOIN status st2 ON s.status_id = st2.id_status 
        LEFT JOIN user u ON s.user_id = u.id_user
    ");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>