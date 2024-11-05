<?php
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $background_color = $_POST['background_color'] ?? '#ffffff';
    $font_color = $_POST['font_color'] ?? '#000000';

    try {
        $stmt = $conn->prepare("INSERT INTO users (username, password, background_color, font_color) VALUES (?, ?, ?, ?)");
        $stmt->execute([$username, $password, $background_color, $font_color]);
        header("Location: ../index.php");
        exit();
    } catch(PDOException $e) {
        $error = "Registration failed: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Имя пользователя" required><br>
        <input type="password" name="password" placeholder="Пароль" required><br>
        <input type="color" name="background_color" value="#ffffff"> Фоновый цвет<br>
        <input type="color" name="font_color" value="#000000"> Цвет шрифта<br>
        <button type="submit">Register</button>
    </form>
</body>
</html>
