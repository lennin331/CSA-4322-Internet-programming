<?php
// inc/auth.php
session_start();
require_once __DIR__ . '/config.php';

function is_logged_in() {
    return isset($_SESSION['user']);
}

function require_login() {
    if (!is_logged_in()) {
        header('Location: /library/index.php');
        exit;
    }
}

function require_admin() {
    require_login();
    if ($_SESSION['user']['role'] !== 'admin') {
        die("Access denied");
    }
}
?>
