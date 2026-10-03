<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: /beauty-salon/pages/admin/login.php');
    exit;
}

require_once __DIR__ . '/../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $duration = (int)($_POST['duration_min'] ?? 0);
    $price = (float)($_POST['price'] ?? 0);
    
    if (!empty($name) && !empty($category) && $duration > 0 && $price > 0) {
        $stmt = $pdo->prepare("INSERT INTO services (name, category, duration_min, price) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $category, $duration, $price]);
    }
}

header('Location: /beauty-salon/pages/admin/manage-services.php');
exit;