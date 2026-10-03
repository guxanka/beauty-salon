<?php
/**
 * Возвращает доступные временные слоты в JSON
 */

require_once __DIR__ . '/../config/db.php';

$date = $_GET['date'] ?? '';
$serviceId = $_GET['service_id'] ?? '';
$masterId = $_GET['master_id'] ?? '';

if (empty($date) || empty($serviceId)) {
    echo json_encode(['error' => 'Не указана дата или услуга']);
    exit;
}

// Получаем длительность услуги
$stmt = $pdo->prepare("SELECT duration_min FROM services WHERE id = ?");
$stmt->execute([$serviceId]);
$service = $stmt->fetch();

if (!$service) {
    echo json_encode(['error' => 'Услуга не найдена']);
    exit;
}

$duration = (int)$service['duration_min'];

// Получаем занятые слоты для выбранного мастера (или всех, если мастер не выбран)
if (!empty($masterId)) {
    $stmt = $pdo->prepare("
        SELECT b.booking_time, s.duration_min 
        FROM bookings b 
        JOIN services s ON b.service_id = s.id
        WHERE b.booking_date = ? 
          AND b.master_id = ? 
          AND b.status NOT IN ('cancelled')
    ");
    $stmt->execute([$date, $masterId]);
} else {
    $stmt = $pdo->prepare("
        SELECT b.booking_time, s.duration_min 
        FROM bookings b 
        JOIN services s ON b.service_id = s.id
        WHERE b.booking_date = ? 
          AND b.status NOT IN ('cancelled')
    ");
    $stmt->execute([$date]);
}

$bookedSlots = $stmt->fetchAll();

// Генерируем все возможные слоты с 10:00 до 20:00 с шагом 30 мин
$allSlots = [];
for ($h = 10; $h < 20; $h++) {
    for ($m = 0; $m < 60; $m += 30) {
        $time = sprintf('%02d:%02d', $h, $m);
        $allSlots[] = $time;
    }
}

// Функция: блокирует ли занятая запись наш слот
function isSlotBlocked($slotTime, $bookedTime, $bookedDuration) {
    $slotMinutes = timeToMinutes($slotTime);
    $slotEnd = $slotMinutes + 30; // наш слот длится 30 мин (минимальный шаг)
    
    $bookedMinutes = timeToMinutes($bookedTime);
    $bookedEnd = $bookedMinutes + $bookedDuration;
    
    // Слот занят, если он пересекается с бронью
    return ($slotMinutes < $bookedEnd && $slotEnd > $bookedMinutes);
}

function timeToMinutes($time) {
    list($h, $m) = explode(':', $time);
    return (int)$h * 60 + (int)$m;
}

// Фильтруем свободные слоты
$freeSlots = [];
foreach ($allSlots as $slot) {
    $isFree = true;
    foreach ($bookedSlots as $booked) {
        if (isSlotBlocked($slot, $booked['booking_time'], (int)$booked['duration_min'])) {
            $isFree = false;
            break;
        }
    }
    if ($isFree) {
        $freeSlots[] = $slot;
    }
}

// Группируем
$morning = [];
$day = [];
$evening = [];

foreach ($freeSlots as $slot) {
    $h = (int)substr($slot, 0, 2);
    if ($h >= 10 && $h < 12) {
        $morning[] = $slot;
    } elseif ($h >= 12 && $h < 17) {
        $day[] = $slot;
    } elseif ($h >= 17 && $h <= 20) {
        $evening[] = $slot;
    }
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode([
    'morning' => array_values($morning),
    'day' => array_values($day),
    'evening' => array_values($evening)
]);