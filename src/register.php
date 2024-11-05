<?php
session_start();
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
  $background_color = $_POST[background_color];
  $font_color = $_POST['font_color'];

  $stmt = $conn->prepare("INSERT INTO users (username, password, background_color, font_color) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $username, $password, $background_color, $font_color);

  if ($stmt->execute()) {
    echo "Регистрация прошла успешно!";
    // Реализацтя перенаправления в аккаунт или страницу логина
  } else {
    echo "Ошибка" . $stmt->error;
  }

  $stmt->close();
  $conn->close();
}
?>
