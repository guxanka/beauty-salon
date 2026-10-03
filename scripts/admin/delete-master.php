<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: /beauty-salon/pages/admin/login.php');
    exit;
}

require_once __DIR__ . '/../../config/db.php';

$id = (int)($_GET['id'] ?? 0);

if ($id) {
    $stmt = $pdo->prepare("DELETE FROM masters WHERE id = ?");
    $stmt->execute([$id]);
}

header('Location: /beauty-salon/pages/admin/manage-masters.php');
exit;