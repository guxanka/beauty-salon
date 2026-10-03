<?php
// Параметры подключения
$host = 'localhost';
$dbname = 'beauty_lab';
$username = 'root';
$password = '';
$charset = 'utf8mb4';

// DSN для PDO
$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

// Настройки PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    // В продакшене — запись в лог, а не вывод на экран
    die('Ошибка подключения к базе данных. Пожалуйста, попробуйте позже.');
}