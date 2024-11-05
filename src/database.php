<?php
$servername = "MySQL-8.2";
$username = "root";
$password = "";
$dbname = "lab_3";

// Создание подключения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}
?>
