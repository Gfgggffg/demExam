<?php
session_start();
session_destroy(); // Уничтожаем все данные сессии
header("Location: index.php"); // Перенаправляем на страницу входа
exit;
?>