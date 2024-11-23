<?php
require_once __DIR__ . '/../libs/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../libs/PHPMailer/SMTP.php';
require_once __DIR__ . '/../libs/PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class KhachHangModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllKhachHang()
    {
        $sql = "SELECT * FROM khachhang";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getKhachHangById($id)
    {
        $sql = "SELECT * FROM khachhang WHERE khachhang_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function checkExistingCustomer($cccd, $dienthoai)
    {
        $sql = "SELECT * FROM khachhang WHERE cccd = ? OR dienthoai = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $cccd, $dienthoai);
        $stmt->execute();
        $result = $stmt->get_result();

        $existing = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row['cccd'] == $cccd) {
                    $existing['cccd'] = true;
                }
                if ($row['dienthoai'] == $dienthoai) {
                    $existing['dienthoai'] = true;
                }
            }
        }
        return $existing;
    }

    public function addKhachHang($fullname, $cccd, $ngaysinh, $gioitinh, $dienthoai, $diachi, $tinh_thanh, $huyen, $xa_phuong, $email)
    {
        $sql = "INSERT INTO khachhang (fullname, cccd, ngaysinh, gioitinh, dienthoai, diachi, tinh_thanh, huyen, xa_phuong, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssssssss", $fullname, $cccd, $ngaysinh, $gioitinh, $dienthoai, $diachi, $tinh_thanh, $huyen, $xa_phuong, $email);
        if ($stmt->execute()) {
            return $this->conn->insert_id;
        }
        return false;
    }


    public function updateKhachHang($id, $fullname, $cccd, $ngaysinh, $gioitinh, $dienthoai, $diachi, $tinh_thanh, $huyen, $xa_phuong, $email)
    {
        $sql = "UPDATE khachhang SET fullname = ?, cccd = ?, ngaysinh = ?, gioitinh = ?, dienthoai = ?, diachi = ?, tinh_thanh = ?, huyen = ?, xa_phuong = ?, email = ? WHERE khachhang_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssssssssi", $fullname, $cccd, $ngaysinh, $gioitinh, $dienthoai, $diachi, $tinh_thanh, $huyen, $xa_phuong, $email, $id);
        return $stmt->execute();
    }

    public function deleteKhachHang($id)
    {
        $sql = "DELETE FROM khachhang WHERE khachhang_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getNguoiThanByKhachHangId($khachhang_id)
    {
        $sql = "SELECT * FROM nguoithan WHERE khachhang_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $khachhang_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addNguoiThan($khachhang_id, $fullname, $quanhe, $dienthoai, $diachi, $tinh_thanh, $huyen, $xa_phuong)
    {
        $sql = "INSERT INTO nguoithan (khachhang_id, fullname, quanhe, dienthoai, diachi, tinh_thanh, huyen, xa_phuong) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isssssss", $khachhang_id, $fullname, $quanhe, $dienthoai, $diachi, $tinh_thanh, $huyen, $xa_phuong);
        return $stmt->execute();
    }

    public function updateNguoiThan($nguoithan_id, $fullname, $quanhe, $dienthoai, $diachi, $tinh_thanh, $huyen, $xa_phuong)
    {
        $sql = "UPDATE nguoithan SET fullname = ?, quanhe = ?, dienthoai = ?, diachi = ?, tinh_thanh = ?, huyen = ?, xa_phuong = ? WHERE nguoithan_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssssssi", $fullname, $quanhe, $dienthoai, $diachi, $tinh_thanh, $huyen, $xa_phuong, $nguoithan_id);
        return $stmt->execute();
    }

    public function deleteNguoiThan($nguoithan_id)
    {
        $sql = "DELETE FROM nguoithan WHERE nguoithan_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $nguoithan_id);
        return $stmt->execute();
    }

    // Add these methods to the KhachHangModel class

    public function addKhachHangWithRelative($fullname, $cccd, $ngaysinh, $gioitinh, $dienthoai, $diachi, $tinh_thanh, $huyen, $xa_phuong, $relative_fullname, $relative_quanhe, $relative_dienthoai, $relative_diachi, $relative_tinh_thanh, $relative_huyen, $relative_xa_phuong, $email)
    {
        // Kiểm tra tồn tại
        $existing = $this->checkExistingCustomer($cccd, $dienthoai);
        if (!empty($existing)) {
            return $existing;
        }

        $this->conn->begin_transaction();
        try {
            $khachhang_id = $this->addKhachHang($fullname, $cccd, $ngaysinh, $gioitinh, $dienthoai, $diachi, $tinh_thanh, $huyen, $xa_phuong, $email); // Cập nhật thêm email

            if ($khachhang_id) {
                $this->addNguoiThan($khachhang_id, $relative_fullname, $relative_quanhe, $relative_dienthoai, $relative_diachi, $relative_tinh_thanh, $relative_huyen, $relative_xa_phuong);
            }

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            return false;
        }
    }

    public function updateKhachHangWithRelative($id, $fullname, $cccd, $ngaysinh, $gioitinh, $dienthoai, $diachi, $tinh_thanh, $huyen, $xa_phuong, $relative_fullname, $relative_quanhe, $relative_dienthoai, $relative_diachi, $relative_tinh_thanh, $relative_huyen, $relative_xa_phuong, $email)
    {
        $this->conn->begin_transaction();

        try {
            $this->updateKhachHang($id, $fullname, $cccd, $ngaysinh, $gioitinh, $dienthoai, $diachi, $tinh_thanh, $huyen, $xa_phuong, $email); // Cập nhật thêm email

            $nguoithan = $this->getNguoiThanByKhachHangId($id);
            if (!empty($nguoithan)) {
                $nguoithan_id = $nguoithan[0]['nguoithan_id'];
                $this->updateNguoiThan($nguoithan_id, $relative_fullname, $relative_quanhe, $relative_dienthoai, $relative_diachi, $relative_tinh_thanh, $relative_huyen, $relative_xa_phuong);
            } else {
                $this->addNguoiThan($id, $relative_fullname, $relative_quanhe, $relative_dienthoai, $relative_diachi, $relative_tinh_thanh, $relative_huyen, $relative_xa_phuong);
            }

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            return false;
        }
    }

    public function searchKhachHang($search_term)
    {
        $search_term = "%$search_term%";
        $sql = "SELECT * FROM khachhang WHERE dienthoai LIKE ? OR cccd LIKE ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return false;
        }
        $stmt->bind_param("ss", $search_term, $search_term);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function sendReminderEmail($email, $message)
    {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'trungtamtiemvaccineoopvc@gmail.com'; // Thay thế bằng email của bạn
            $mail->Password = 'fujb dggc kruw infa'; // Thay thế bằng mật khẩu email của bạn
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('trungtamtiemvaccineoopvc@gmail.com', 'Trung Tâm Tiêm Vaccine');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Lịch nhắc tiêm chủng';
            $mail->Body = $message;

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Email sending error: " . $mail->ErrorInfo);
            return false;
        }
    }

    public function checkKhachHangExists($phoneOrCCCD)
    {
        $sql = "SELECT COUNT(*) as count FROM khachhang WHERE dienthoai = ? OR cccd = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $phoneOrCCCD, $phoneOrCCCD);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'] > 0;
    }

    public function getKhachHangByPhoneOrCCCD($phoneOrCCCD)
    {
        $sql = "SELECT * FROM khachhang WHERE dienthoai = ? OR cccd = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $phoneOrCCCD, $phoneOrCCCD);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // Trả về thông tin khách hàng nếu tìm thấy
    }

}