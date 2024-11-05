<?php
session_start();
require_once 'database.php';

if (isset($_SESSION['user_id'])) {
    // Очистка remember_token в базе данных
    $stmt = $conn->prepare("UPDATE users SET remember_token = NULL WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
}

// Удаление всех cookie
setcookie('remember_token', '', time() - 3600);
setcookie('background_color', '', time() - 3600);
setcookie('font_color', '', time() - 3600);

// Уничтожение сессии
session_destroy();

header("Location: login.php");
exit();
?>
