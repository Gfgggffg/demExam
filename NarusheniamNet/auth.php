<?php
require_once "db/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = strip_tags($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($login) || empty($password)) {
        header("Location: index.php?error=empty");
        exit;
    }
    
    if (find($login, $password)) {
        // Успешная авторизация
        $user = getUserInfo();
        if ($user['role'] === 'admin') {
            header("Location: admin.php");
        } else {
            header("Location: requests.php");
        }
        exit;
    } else {
        header("Location: index.php?error=invalid");
        exit;
    }
}
?>