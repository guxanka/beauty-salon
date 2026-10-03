<?php
/**
 * Выход из личного кабинета
 */

session_start();

// Очищаем сессию
$_SESSION = [];
session_destroy();

// Перенаправляем на главную
header('Location: /beauty-salon/');
exit;