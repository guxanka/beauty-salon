<?php
/**
 * Обработчик входа в личный кабинет
 */

session_start();
require_once __DIR__ . '/../config/db.php';

// Проверяем метод запроса
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /beauty-salon/pages/login.php');
    exit;
}

// Получаем данные
$login = trim($_POST['login'] ?? '');
$password = $_POST['password'] ?? '';

// Валидация
$errors = [];

if (empty($login)) {
    $errors['login'] = 'Введите телефон или email';
}

if (empty($password)) {
    $errors['password'] = 'Введите пароль';
}

if (!empty($errors)) {
    $_SESSION['login_errors'] = $errors;
    $_SESSION['login_old'] = ['login' => $login];
    header('Location: /beauty-salon/pages/login.php');
    exit;
}

// Ищем клиента по телефону или email
try {
    $stmt = $pdo->prepare("
        SELECT id, name, phone, email, password_hash 
        FROM clients 
        WHERE phone = ? OR email = ?
    ");
    $stmt->execute([$login, $login]);
    $client = $stmt->fetch();
    
    if ($client && password_verify($password, $client['password_hash'])) {
        // Успешный вход
        $_SESSION['client_id'] = $client['id'];
        $_SESSION['client_name'] = $client['name'];
        
        unset($_SESSION['login_errors'], $_SESSION['login_old']);
        
        // Перенаправляем в личный кабинет (пока на главную)
        header('Location: /beauty-salon/index.php?logged_in=1');
        exit;
    } else {
        // Неверные данные
        $_SESSION['login_errors']['general'] = 'Неверный телефон/email или пароль';
        $_SESSION['login_old'] = ['login' => $login];
        header('Location: /beauty-salon/pages/login.php');
        exit;
    }
    
} catch (PDOException $e) {
    $_SESSION['login_errors']['general'] = 'Ошибка входа. Попробуйте позже.';
    header('Location: /beauty-salon/pages/login.php');
    exit;
}