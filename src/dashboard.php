<?php
session_start();
require_once 'database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    echo "Вы не авторизованы";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $background_color = $_POST['background_color'];
    $font_color = $_POST['font_color'];

    $stmt = $conn->prepare("UPDATE users SET background_color = ?, font_color = ? WHERE id = ?");
    $stmt->execute([$background_color, $font_color, $_SESSION['user_id']]);

    setcookie('background_color', $background_color, time() + 30 * 24 * 60 * 60);
    setcookie('font_color', $font_color, time() + 30 * 24 * 60 * 60);

    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Личный кабинет</title>
    <style>
        body {
            background-color: <?php echo $_COOKIE['background_color'] ?? '#ffffff'; ?>;
            color: <?php echo $_COOKIE['font_color'] ?? '#000000'; ?>;
        }
    </style>
</head>
<body>
    <h1>Здравствуйте, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>

    <form method="POST">
        <label>Фоновый цвет:</label>
        <input type="color" name="background_color" value="<?php echo $_COOKIE['background_color'] ?? '#ffffff'; ?>"><br>
        <label>Цвет шрифта:</label>
        <input type="color" name="font_color" value="<?php echo $_COOKIE['font_color'] ?? '#000000'; ?>"><br>
        <button type="submit">Сохранить настройки</button>
    </form>

    <a href="logout.php">Выйти из системы</a>
</body>
</html>
