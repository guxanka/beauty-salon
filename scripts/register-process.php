<?php
/**
 * Обработчик регистрации клиента
 */

session_start();
require_once __DIR__ . '/../config/db.php';

// Проверяем, что запрос пришёл методом POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /beauty-salon/pages/register.php');
    exit;
}

// Получаем и очищаем данные
$name = trim($_POST['name'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$passwordConfirm = $_POST['password_confirm'] ?? '';

// Массив для ошибок
$errors = [];

// === ВАЛИДАЦИЯ ===

// Имя
if (empty($name)) {
    $errors['name'] = 'Укажите ваше имя';
} elseif (mb_strlen($name) < 2) {
    $errors['name'] = 'Имя должно содержать не менее 2 символов';
} elseif (mb_strlen($name) > 100) {
    $errors['name'] = 'Имя не должно превышать 100 символов';
}

// Телефон
$phone = preg_replace('/[^\d+]/', '', $phone);
if (empty($phone)) {
    $errors['phone'] = 'Укажите номер телефона';
} elseif (!preg_match('/^\+?\d{10,15}$/', $phone)) {
    $errors['phone'] = 'Некорректный формат телефона';
}

// Email
if (empty($email)) {
    $errors['email'] = 'Укажите email';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Некорректный формат email';
}

// Пароль
if (empty($password)) {
    $errors['password'] = 'Придумайте пароль';
} elseif (mb_strlen($password) < 8) {
    $errors['password'] = 'Пароль должен содержать не менее 8 символов';
} elseif (!preg_match('/[a-z]/', $password)) {
    $errors['password'] = 'Пароль должен содержать строчные латинские буквы';
} elseif (!preg_match('/[A-Z]/', $password)) {
    $errors['password'] = 'Пароль должен содержать заглавные латинские буквы';
} elseif (!preg_match('/\d/', $password)) {
    $errors['password'] = 'Пароль должен содержать цифры';
}

// Подтверждение пароля
if ($password !== $passwordConfirm) {
    $errors['password_confirm'] = 'Пароли не совпадают';
}

// Проверка уникальности телефона и email
if (empty($errors)) {
    $stmt = $pdo->prepare("SELECT id FROM clients WHERE phone = ? OR email = ?");
    $stmt->execute([$phone, $email]);
    $existing = $stmt->fetchAll();
    
    foreach ($existing as $row) {
        $stmtCheck = $pdo->prepare("SELECT phone, email FROM clients WHERE id = ?");
        $stmtCheck->execute([$row['id']]);
        $client = $stmtCheck->fetch();
        
        if ($client['phone'] === $phone) {
            $errors['phone'] = 'Этот телефон уже зарегистрирован';
        }
        if ($client['email'] === $email) {
            $errors['email'] = 'Этот email уже зарегистрирован';
        }
    }
}

// === ЕСЛИ ЕСТЬ ОШИБКИ — ВОЗВРАЩАЕМ НА ФОРМУ ===
if (!empty($errors)) {
    $_SESSION['register_errors'] = $errors;
    $_SESSION['register_old'] = [
        'name' => $name,
        'phone' => $_POST['phone'],
        'email' => $email,
    ];
    header('Location: /beauty-salon/pages/register.php');
    exit;
}

// === УСПЕШНАЯ ВАЛИДАЦИЯ — СОХРАНЯЕМ В БД ===
try {
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    
    $stmt = $pdo->prepare("
        INSERT INTO clients (name, phone, email, password_hash) 
        VALUES (?, ?, ?, ?)
    ");
    $stmt->execute([$name, $phone, $email, $passwordHash]);
    
    // Получаем ID нового клиента
    $clientId = $pdo->lastInsertId();
    
    // Сохраняем в сессию — сразу авторизуем
    $_SESSION['client_id'] = $clientId;
    $_SESSION['client_name'] = $name;
    
    // Очищаем временные данные
    unset($_SESSION['register_errors'], $_SESSION['register_old']);
    
    // Перенаправляем в личный кабинет (пока на главную)
    header('Location: /beauty-salon/index.php?registered=1');
    exit;
    
} catch (PDOException $e) {
    $_SESSION['register_errors']['general'] = 'Ошибка при регистрации. Попробуйте позже.';
    header('Location: /beauty-salon/pages/register.php');
    exit;
}