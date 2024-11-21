<?php
require_once __DIR__ . '/config/mysql_connection.php';
require_once __DIR__ . '/controllers/tai_khoan_controller.php';

$tai_khoan_controller = new TaiKhoanController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten_dang_nhap = $_POST['ten_dang_nhap'];
    $mat_khau = $_POST['mat_khau'];

    $login_result = $tai_khoan_controller->login($ten_dang_nhap, $mat_khau);

    if ($login_result['success']) {
        header('Location: ./index.php');
        exit;
    } else {
        if ($login_result['message'] === 'locked') {
            $error = "locked";
        } else {
            $error = "invalid";
        }
    }
}

include __DIR__ . '/views/login.php';