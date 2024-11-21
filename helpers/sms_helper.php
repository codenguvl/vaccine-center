<?php
require_once __DIR__ . '/../libs/SpeedSMSAPI/SpeedSMSAPI.php'; // Đường dẫn đến thư viện SpeedSMS

class SMSHelper
{
    private $smsAPI;

    public function __construct()
    {
        // Khởi tạo SpeedSMSAPI với api access token của bạn
        // $this->smsAPI = new SpeedSMSAPI("NPHiZSHOJK0qVQPCi2xF1RxYXQ5ey1ki"); // Thay thế bằng access token của bạn
    }

    // Gửi nhắc nhở qua email
    public function sendReminderEmail($email, $message)
    {
        $khachhang_model = new KhachHangModel($this->conn); // Khởi tạo model
        return $khachhang_model->sendReminderEmail($email, $message); // Gửi email
    }
}