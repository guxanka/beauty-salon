<?php
session_start();
require_once __DIR__ . '/../config/db.php';

// Проверяем метод запроса
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /beauty-salon/pages/booking.php');
    exit;
}

// Получаем данные из формы
$serviceId = !empty($_POST['service_id']) ? (int)$_POST['service_id'] : null;
$masterId = !empty($_POST['master_id']) ? (int)$_POST['master_id'] : null;
$date = $_POST['booking_date'] ?? null;
$time = $_POST['booking_time'] ?? null;
$clientName = trim($_POST['client_name'] ?? '');
$clientPhone = trim($_POST['client_phone'] ?? '');
$clientEmail = trim($_POST['client_email'] ?? '');
$comment = trim($_POST['comment'] ?? '');

// Очистка телефона
$clientPhone = preg_replace('/[^\d+]/', '', $clientPhone);

// Валидация
$errors = [];
if (!$serviceId) $errors[] = 'Не выбрана услуга';
if (!$date) $errors[] = 'Не выбрана дата';
if (!$time) $errors[] = 'Не выбрано время';
if (empty($clientName)) $errors[] = 'Укажите имя';
if (empty($clientPhone)) $errors[] = 'Укажите телефон';

if (!empty($errors)) {
    $_SESSION['booking_errors'] = $errors;
    header('Location: /beauty-salon/pages/booking.php');
    exit;
}

// Проверяем, что услуга существует
$stmtDur = $pdo->prepare("SELECT duration_min FROM services WHERE id = ? AND is_active = 1");
$stmtDur->execute([$serviceId]);
$service = $stmtDur->fetch();

if (!$service) {
    $_SESSION['booking_errors'] = ['Услуга не найдена или недоступна.'];
    header('Location: /beauty-salon/pages/booking.php');
    exit;
}

$serviceDuration = (int)$service['duration_min'];

// Проверяем, что мастер существует (если выбран)
if ($masterId) {
    $stmtMaster = $pdo->prepare("SELECT id FROM masters WHERE id = ? AND is_active = 1");
    $stmtMaster->execute([$masterId]);
    if (!$stmtMaster->fetch()) {
        $masterId = null;
    }
}

// Проверка занятости времени
$sqlCheck = "
    SELECT b.booking_time, s.duration_min 
    FROM bookings b 
    JOIN services s ON b.service_id = s.id
    WHERE b.booking_date = ? 
      AND b.status NOT IN ('cancelled')
";
$paramsCheck = [$date];

if ($masterId) {
    $sqlCheck .= " AND b.master_id = ?";
    $paramsCheck[] = $masterId;
}

$stmtCheck = $pdo->prepare($sqlCheck);
$stmtCheck->execute($paramsCheck);
$existingBookings = $stmtCheck->fetchAll();

$newStartMinutes = timeToMinutes($time);
$newEndMinutes = $newStartMinutes + $serviceDuration;
$isTimeBusy = false;

foreach ($existingBookings as $booking) {
    $bookStartMinutes = timeToMinutes($booking['booking_time']);
    $bookEndMinutes = $bookStartMinutes + (int)$booking['duration_min'];
    
    if ($newStartMinutes < $bookEndMinutes && $newEndMinutes > $bookStartMinutes) {
        $isTimeBusy = true;
        break;
    }
}

if ($isTimeBusy) {
    $_SESSION['booking_errors'] = ['Это время уже занято. Выберите другой слот.'];
    header('Location: /beauty-salon/pages/booking.php?error=busy');
    exit;
}

// Ищем или создаём клиента
$clientId = $_SESSION['client_id'] ?? null;

if (!$clientId && !empty($clientPhone)) {
    // Ищем по телефону
    $stmt = $pdo->prepare("SELECT id, name FROM clients WHERE phone = ?");
    $stmt->execute([$clientPhone]);
    $existing = $stmt->fetch();
    
    if ($existing) {
        $clientId = $existing['id'];
        $_SESSION['client_id'] = $clientId;
        $_SESSION['client_name'] = $existing['name'];
    } else {
        // Создаём нового клиента
        $tempPassword = password_hash(uniqid(), PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO clients (name, phone, email, password_hash) VALUES (?, ?, ?, ?)");
        $stmt->execute([$clientName, $clientPhone, $clientEmail ?: null, $tempPassword]);
        $clientId = $pdo->lastInsertId();
        $_SESSION['client_id'] = $clientId;
        $_SESSION['client_name'] = $clientName;
    }
}

// Создаём запись
try {
    $stmt = $pdo->prepare("
        INSERT INTO bookings (client_id, master_id, service_id, booking_date, booking_time, comment, status) 
        VALUES (?, ?, ?, ?, ?, ?, 'new')
    ");
    $stmt->execute([
        $clientId,
        $masterId,
        $serviceId,
        $date,
        $time . ':00',
        $comment
    ]);
    
    $_SESSION['booking_success'] = 'Запись на ' . date('d.m.Y', strtotime($date)) . ' в ' . $time . ' успешно создана! Ожидайте подтверждения.';
    header('Location: /beauty-salon/pages/booking-success.php');
    exit;
    
} catch (PDOException $e) {
    // Логируем ошибку для отладки
    error_log('Booking error: ' . $e->getMessage());
    
    if ($e->getCode() == 23000) {
        $_SESSION['booking_errors'] = ['Это время уже занято. Выберите другой слот.'];
    } else {
        $_SESSION['booking_errors'] = ['Ошибка при создании записи. Попробуйте позже.'];
    }
    header('Location: /beauty-salon/pages/booking.php?error=system');
    exit;
}

// Функция перевода времени в минуты
function timeToMinutes($time) {
    if (!$time) return 0;
    $parts = explode(':', $time);
    return (int)$parts[0] * 60 + (int)$parts[1];
}