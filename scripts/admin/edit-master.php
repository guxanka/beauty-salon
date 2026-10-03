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
    $specialization = trim($_POST['specialization'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $isActive = isset($_POST['is_active']) ? 1 : 0;
    
    // Получаем старое фото
    $stmt = $pdo->prepare("SELECT photo FROM masters WHERE id = ?");
    $stmt->execute([$id]);
    $oldPhoto = $stmt->fetchColumn();
    $photoName = $oldPhoto;
    
    // Загрузка нового фото
    if (!empty($_FILES['photo']['name'])) {
        $uploadDir = __DIR__ . '/../../assets/images/masters/';
        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $photoName = 'master_' . time() . '.' . $ext;
        move_uploaded_file($_FILES['photo']['tmp_name'], $uploadDir . $photoName);
        
        // Удаляем старое фото (если не заглушка)
        if ($oldPhoto && file_exists($uploadDir . $oldPhoto)) {
            unlink($uploadDir . $oldPhoto);
        }
    }
    
    if ($id && !empty($name) && !empty($specialization)) {
        $stmt = $pdo->prepare("UPDATE masters SET name = ?, specialization = ?, description = ?, photo = ?, is_active = ? WHERE id = ?");
        $stmt->execute([$name, $specialization, $description, $photoName, $isActive, $id]);
    }
}

header('Location: /beauty-salon/pages/admin/manage-masters.php');
exit;