<?php
require 'vendor/autoload.php';
session_start();
require_once 'src/database.php';

// Проверка remember_token
if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_token'])) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE remember_token = ?");
    $stmt->execute([$_COOKIE['remember_token']]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        setcookie('background_color', $user['background_color'], time() + 30 * 24 * 60 * 60);
        setcookie('font_color', $user['font_color'], time() + 30 * 24 * 60 * 60);
        header("Location: src/dashboard.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Установка cookie и remember_token
        $remember_token = bin2hex(random_bytes(32));
        setcookie('remember_token', $remember_token, time() + 30 * 24 * 60 * 60);
        setcookie('background_color', $user['background_color'], time() + 30 * 24 * 60 * 60);
        setcookie('font_color', $user['font_color'], time() + 30 * 24 * 60 * 60);

        $stmt = $conn->prepare("UPDATE users SET remember_token = ? WHERE id = ?");
        $stmt->execute([$remember_token, $user['id']]);

        header("Location: src/dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Авторизация</title>
</head>
<body>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
    <a href="src/register.php">Register</a>
</body>
</html>
