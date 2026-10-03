<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: /beauty-salon/pages/admin/login.php');
    exit;
}

require_once __DIR__ . '/../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'];
    $name = trim($_POST['name'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $duration = (int)($_POST['duration_min'] ?? 0);
    $price = (float)($_POST['price'] ?? 0);
    $isActive = isset($_POST['is_active']) ? 1 : 0;
    
    if ($id && !empty($name) && !empty($category) && $duration > 0 && $price > 0) {
        $stmt = $pdo->prepare("UPDATE services SET name = ?, category = ?, duration_min = ?, price = ?, is_active = ? WHERE id = ?");
        $stmt->execute([$name, $category, $duration, $price, $isActive, $id]);
    }
}

header('Location: /beauty-salon/pages/admin/manage-services.php');
exit;