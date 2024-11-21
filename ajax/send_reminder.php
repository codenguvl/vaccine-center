<?php
require_once '../helpers/sms_helper.php';
require_once '../config/mysql_connection.php';
require_once '../models/lich_hen_model.php';
require_once '../controllers/khachhang_controller.php'; // Include the controller

header('Content-Type: application/json');

$smsHelper = new SMSHelper();
$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'] ?? null; // Sử dụng null nếu không có
$message = $data['message'] ?? null; // Sử dụng null nếu không có

if ($email === null || $message === null) {
    echo json_encode(['status' => 'error', 'message' => 'Email hoặc message không được cung cấp.']);
    exit;
}

// Create a new instance of the controller
$khachhangController = new KhachHangController($conn);
$result = $khachhangController->sendReminderEmail($email, $message); // Call the controller method

echo json_encode(['status' => $result ? 'success' : 'error']);