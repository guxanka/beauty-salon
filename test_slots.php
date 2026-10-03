<?php
require_once __DIR__ . '/config/db.php';

$date = '2026-05-15'; // Завтрашняя дата для теста

echo "<h3>Все записи на $date:</h3>";
$stmt = $pdo->prepare("
    SELECT b.id, b.booking_time, b.status, s.name AS service, s.duration_min, m.name AS master
    FROM bookings b
    JOIN services s ON b.service_id = s.id
    LEFT JOIN masters m ON b.master_id = m.id
    WHERE b.booking_date = ?
    ORDER BY b.booking_time
");
$stmt->execute([$date]);
$all = $stmt->fetchAll();

echo "<table border='1' cellpadding='8'>";
echo "<tr><th>ID</th><th>Время</th><th>Статус</th><th>Услуга</th><th>Длит.</th><th>Мастер</th></tr>";
foreach ($all as $row) {
    $color = $row['status'] === 'cancelled' ? '#fcc' : '#cfc';
    echo "<tr style='background:$color'>";
    echo "<td>{$row['id']}</td>";
    echo "<td>{$row['booking_time']}</td>";
    echo "<td>{$row['status']}</td>";
    echo "<td>{$row['service']}</td>";
    echo "<td>{$row['duration_min']} мин</td>";
    echo "<td>{$row['master']}</td>";
    echo "</tr>";
}
echo "</table>";

echo "<h3>Занятые слоты (без cancelled):</h3>";
$stmt2 = $pdo->prepare("
    SELECT b.booking_time, s.duration_min 
    FROM bookings b 
    JOIN services s ON b.service_id = s.id
    WHERE b.booking_date = ? 
      AND b.status != 'cancelled'
");
$stmt2->execute([$date]);
$booked = $stmt2->fetchAll();

echo "<pre>";
print_r($booked);
echo "</pre>";