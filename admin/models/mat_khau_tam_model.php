<?php
class MatKhauTamModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function createTempPassword($tai_khoan_id, $mat_khau_tam)
    {
        $hashed_password = password_hash($mat_khau_tam, PASSWORD_DEFAULT);
        $ngay_het_han = date('Y-m-d H:i:s', strtotime('+24 hours'));

        $sql = "INSERT INTO mat_khau_tam (tai_khoan_id, mat_khau_tam, ngay_het_han) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iss", $tai_khoan_id, $hashed_password, $ngay_het_han);
        return $stmt->execute();
    }

    public function verifyTempPassword($tai_khoan_id, $mat_khau_tam)
    {
        $sql = "SELECT * FROM mat_khau_tam 
                WHERE tai_khoan_id = ? 
                AND ngay_het_han > NOW() 
                AND da_su_dung = 0 
                ORDER BY ngay_tao DESC 
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $tai_khoan_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $temp_pass = $result->fetch_assoc();

        if ($temp_pass && password_verify($mat_khau_tam, $temp_pass['mat_khau_tam'])) {
            // Đánh dấu mật khẩu tạm đã được sử dụng
            $this->markAsUsed($temp_pass['id']);
            return true;
        }
        return false;
    }

    private function markAsUsed($id)
    {
        $sql = "UPDATE mat_khau_tam SET da_su_dung = 1 WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function cleanupOldPasswords()
    {
        // Xóa mật khẩu tạm đã hết hạn hoặc đã sử dụng sau 24h
        $sql = "DELETE FROM mat_khau_tam 
                WHERE ngay_het_han < NOW() 
                OR (da_su_dung = 1 AND ngay_tao < DATE_SUB(NOW(), INTERVAL 24 HOUR))";
        return $this->conn->query($sql);
    }

    public function deleteTempPasswords($user_id)
    {
        $sql = "DELETE FROM mat_khau_tam WHERE tai_khoan_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        return $stmt->execute();
    }

}