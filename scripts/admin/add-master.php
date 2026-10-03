<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: /beauty-salon/pages/admin/login.php');
    exit;
}

require_once __DIR__ . '/../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $specialization = trim($_POST['specialization'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $photoName = null;
    
    // Загрузка фото
    if (!empty($_FILES['photo']['name'])) {
        $uploadDir = __DIR__ . '/../../assets/images/masters/';
        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $photoName = 'master_' . time() . '.' . $ext;
        move_uploaded_file($_FILES['photo']['tmp_name'], $uploadDir . $photoName);
    }
    
    if (!empty($name) && !empty($specialization)) {
        $stmt = $pdo->prepare("INSERT INTO masters (name, specialization, description, photo) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $specialization, $description, $photoName]);
    }
}

header('Location: /beauty-salon/pages/admin/manage-masters.php');
exit;