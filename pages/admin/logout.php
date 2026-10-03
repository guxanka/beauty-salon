<?php
session_start();
$_SESSION = [];
session_destroy();
header('Location: /beauty-salon/pages/admin/login.php');
exit;