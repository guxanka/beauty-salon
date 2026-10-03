<?php
/**
 * Отмена записи клиентом
 */

session_start();
require_once __DIR__ . '/../config/db.php';

// Проверяем авторизацию
if (!isset($_SESSION['client_id'])) {
    header('Location: /beauty-salon/pages/login.php');
    exit;
}

// Проверяем наличие ID записи
$bookingId = $_GET['id'] ?? null;
if (!$bookingId) {
    header('Location: /beauty-salon/pages/account/cabinet.php');
    exit;
}

try {
    // Получаем запись и проверяем принадлежность клиенту
    $stmt = $pdo->prepare("SELECT * FROM bookings WHERE id = ? AND client_id = ?");
    $stmt->execute([$bookingId, $_SESSION['client_id']]);
    $booking = $stmt->fetch();
    
    if (!$booking) {
        $_SESSION['cabinet_error'] = 'Запись не найдена.';
        header('Location: /beauty-salon/pages/account/cabinet.php');
        exit;
    }
    
    // Проверяем 24 часа
    $bookingDateTime = strtotime($booking['booking_date'] . ' ' . $booking['booking_time']);
    $hoursUntil = ($bookingDateTime - time()) / 3600;
    
    if ($hoursUntil < 24) {
        $_SESSION['cabinet_error'] = 'Отмена возможна не позднее чем за 24 часа. Позвоните нам для отмены.';
        header('Location: /beauty-salon/pages/account/cabinet.php');
        exit;
    }
    
    // Отменяем запись
    $stmt = $pdo->prepare("UPDATE bookings SET status = 'cancelled' WHERE id = ?");
    $stmt->execute([$bookingId]);
    
    $_SESSION['cabinet_success'] = 'Запись успешно отменена.';
    header('Location: /beauty-salon/pages/account/cabinet.php');
    exit;
    
} catch (PDOException $e) {
    $_SESSION['cabinet_error'] = 'Ошибка при отмене записи. Попробуйте позже.';
    header('Location: /beauty-salon/pages/account/cabinet.php');
    exit;
}