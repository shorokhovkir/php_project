<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password, background_color, font_color FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password, $background_color, $font_color);

    if ($stmt->fetch() && password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $id;
        setcookie("background_color", $background_color, time() + (86400 * 30), "/"); // 30 дней
        setcookie("font_color", $font_color, time() + (86400 * 30), "/");

        echo "Авторизация прошла успешно!";
        // Перенаправление в профиль пользователя
    } else {
        echo "Неправильные имя пользователя или пароль.";
    }

    $stmt->close();
    $conn->close();
}
?>
