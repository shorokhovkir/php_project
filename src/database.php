<?php
$host = 'MySQL-8.2';
$dbname = 'lab_3';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Соединение не установено: " . $e->getMessage());
}
?>
