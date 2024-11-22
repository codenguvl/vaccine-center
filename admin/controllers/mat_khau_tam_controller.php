<?php
require_once __DIR__ . '/../models/mat_khau_tam_model.php';

class MatKhauTamController
{
    private $mat_khau_tam_model;

    public function __construct($conn)
    {
        $this->mat_khau_tam_model = new MatKhauTamModel($conn);
    }

    public function createTempPassword($tai_khoan_id)
    {
        // Tạo mật khẩu tạm ngẫu nhiên
        $temp_password = substr(md5(rand()), 0, 8);

        // Lưu vào database
        $result = $this->mat_khau_tam_model->createTempPassword($tai_khoan_id, $temp_password);

        if ($result) {
            return ['success' => true, 'password' => $temp_password];
        }
        return ['success' => false, 'message' => 'Không thể tạo mật khẩu tạm'];
    }

    public function verifyTempPassword($tai_khoan_id, $mat_khau_tam)
    {
        return $this->mat_khau_tam_model->verifyTempPassword($tai_khoan_id, $mat_khau_tam);
    }

    public function cleanupOldPasswords()
    {
        return $this->mat_khau_tam_model->cleanupOldPasswords();
    }
}