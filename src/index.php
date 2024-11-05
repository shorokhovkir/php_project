<?php
session_start();
if (isset($_SESSION['user_id'])) {
    // Пользователь уже авторизован
    $background_color = $_COOKIE['background_color'] ?? '#ffffff';
    $font_color = $_COOKIE['font_color'] ?? '#000000';
} else {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Главная</title>
    <style>
        body {
            background-color: <?= $background_color ?>;
            color: <?= $font_color ?>;
        }
    </style>
</head>
<body>
    <h1>Добро пожаловать!</h1>
    <a href="logout.php">Выйти</a>
</body>
</html>
