<?php
require_once __DIR__ . '/config/db.php';

$hash = password_hash('admin123', PASSWORD_DEFAULT);
echo "Новый хеш: " . $hash . "<br><br>";

$stmt = $pdo->prepare("UPDATE admins SET password_hash = ? WHERE login = 'director'");
$stmt->execute([$hash]);
echo "Пароль для director обновлён.<br><br>";

$stmt = $pdo->prepare("SELECT * FROM admins WHERE login = 'director'");
$stmt->execute();
$admin = $stmt->fetch();

echo "Запись найдена: " . ($admin ? 'Да' : 'Нет') . "<br>";
echo "Проверка пароля: " . (password_verify('admin123', $admin['password_hash']) ? 'РАБОТАЕТ' : 'ОШИБКА') . "<br>";