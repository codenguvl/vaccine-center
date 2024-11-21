<?php
require_once '../config/mysql_connection.php';
require_once '../controllers/khachhang_controller.php';

header('Content-Type: application/json');

$search = isset($_GET['search']) ? $_GET['search'] : '';

if (strlen($search) >= 2) {
    $khachhang_controller = new KhachHangController($conn);
    $results = $khachhang_controller->searchKhachHang($search);
    echo json_encode($results);
} else {
    echo json_encode([]);
}