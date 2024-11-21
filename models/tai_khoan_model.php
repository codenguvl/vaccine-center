<?php
require_once 'config/mysql_connection.php';

class TaiKhoanModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllTaiKhoan()
    {
        $sql = "SELECT t.*, v.ten_vai_tro FROM tai_khoan t LEFT JOIN vai_tro v ON t.vai_tro_id = v.id";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTaiKhoanById($id)
    {
        $sql = "SELECT * FROM tai_khoan WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function createTaiKhoan($ten_dang_nhap, $mat_khau, $email, $ho_ten, $gioi_tinh, $dien_thoai, $vai_tro_id, $anh_dai_dien = null)
    {
        $hashed_password = password_hash($mat_khau, PASSWORD_DEFAULT);
        $sql = "INSERT INTO tai_khoan (ten_dang_nhap, mat_khau, email, ho_ten, gioi_tinh, dien_thoai, vai_tro_id, anh_dai_dien) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssssss", $ten_dang_nhap, $hashed_password, $email, $ho_ten, $gioi_tinh, $dien_thoai, $vai_tro_id, $anh_dai_dien);
        $stmt->execute();
        return $stmt->insert_id;
    }


    public function updateTaiKhoan($id, $email, $ho_ten, $gioi_tinh, $dien_thoai, $vai_tro_id, $trang_thai)
    {
        $sql = "UPDATE tai_khoan SET email = ?, ho_ten = ?, gioi_tinh = ?, dien_thoai = ?, vai_tro_id = ?, trang_thai = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssssi", $email, $ho_ten, $gioi_tinh, $dien_thoai, $vai_tro_id, $trang_thai, $id);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    public function deleteTaiKhoan($id)
    {
        $sql = "DELETE FROM tai_khoan WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    public function updateTrangThai($id, $trang_thai)
    {
        $sql = "UPDATE tai_khoan SET trang_thai = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $trang_thai, $id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    /* public function authenticateUser($ten_dang_nhap, $mat_khau)
    {
        $sql = "SELECT * FROM tai_khoan WHERE ten_dang_nhap = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $ten_dang_nhap);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($mat_khau, $user['mat_khau'])) {
            return $user;
        }

        return null;
    } */
    public function authenticateUser($ten_dang_nhap, $mat_khau)
    {
        $sql = "SELECT * FROM tai_khoan WHERE ten_dang_nhap = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $ten_dang_nhap);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            // Kiểm tra trạng thái tài khoản trước
            if ($user['trang_thai'] === 'khoa') {
                return ['status' => 'locked'];
            }

            // Tạo instance của MatKhauTamModel
            require_once __DIR__ . '/mat_khau_tam_model.php';
            $mat_khau_tam_model = new MatKhauTamModel($this->conn);

            // Kiểm tra mật khẩu tạm
            if ($mat_khau_tam_model->verifyTempPassword($user['id'], $mat_khau)) {
                $_SESSION['temp_password'] = true;
                return ['status' => 'success', 'user' => $user];
            }

            // Kiểm tra mật khẩu chính
            if (password_verify($mat_khau, $user['mat_khau'])) {
                $_SESSION['temp_password'] = false;
                return ['status' => 'success', 'user' => $user];
            }
        }

        return ['status' => 'invalid'];
    }



    public function checkPermission($user_id, $slug)
    {
        $sql = "SELECT COUNT(*) as count 
            FROM tai_khoan t
            JOIN vai_tro v ON t.vai_tro_id = v.id
            JOIN phan_quyen p ON v.id = p.vai_tro_id 
            JOIN chuc_nang c ON p.chuc_nang_id = c.id
            WHERE t.id = ? AND c.duong_dan = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("is", $user_id, $slug);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row['count'] > 0;
    }

    public function getUserByEmail($email)
    {
        $sql = "SELECT * FROM tai_khoan WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updatePassword($user_id, $new_password)
    {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "UPDATE tai_khoan SET mat_khau = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $hashed_password, $user_id);
        return $stmt->execute();
    }

    public function updateProfile($id, $email, $ho_ten, $gioi_tinh, $dien_thoai)
    {
        $sql = "UPDATE tai_khoan SET email = ?, ho_ten = ?, gioi_tinh = ?, dien_thoai = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssi", $email, $ho_ten, $gioi_tinh, $dien_thoai, $id);
        return $stmt->execute();
    }

    public function verifyPassword($user_id, $password)
    {
        try {
            // Kiểm tra mật khẩu tạm
            require_once __DIR__ . '/mat_khau_tam_model.php';
            $mat_khau_tam_model = new MatKhauTamModel($this->conn);

            // Debug
            error_log("Checking temp password for user_id: " . $user_id . " with password: " . $password);

            // Kiểm tra trong bảng mat_khau_tam
            $sql = "SELECT * FROM mat_khau_tam 
                WHERE tai_khoan_id = ? 
                AND ngay_het_han > NOW() 
                /* AND da_su_dung = 0  */
                ORDER BY ngay_tao DESC 
                LIMIT 1";

            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $temp_pass = $result->fetch_assoc();

            if ($temp_pass && password_verify($password, $temp_pass['mat_khau_tam'])) {
                error_log("Temp password verified successfully");
                return true;
            }

            // Nếu không có mật khẩu tạm, kiểm tra mật khẩu chính
            $sql = "SELECT mat_khau FROM tai_khoan WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if ($user && password_verify($password, $user['mat_khau'])) {
                error_log("Main password verified successfully");
                return true;
            }

            error_log("Password verification failed");
            return false;
        } catch (Exception $e) {
            error_log("Error in verifyPassword: " . $e->getMessage());
            return false;
        }
    }

    public function updatePasswordAfterTemp($user_id, $new_password)
    {
        $this->conn->begin_transaction();
        try {
            // Cập nhật mật khẩu mới
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $sql = "UPDATE tai_khoan SET mat_khau = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("si", $hashed_password, $user_id);
            $stmt->execute();

            // Xóa mật khẩu tạm thời
            require_once __DIR__ . '/mat_khau_tam_model.php';
            $mat_khau_tam_model = new MatKhauTamModel($this->conn);
            $mat_khau_tam_model->deleteTempPasswords($user_id);

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            error_log("Error updating password after temp: " . $e->getMessage());
            return false;
        }
    }

    public function updateAvatar($user_id, $avatar_path)
    {
        $sql = "UPDATE tai_khoan SET anh_dai_dien = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $avatar_path, $user_id);
        return $stmt->execute();
    }

    public function getAvatar($user_id)
    {
        $sql = "SELECT anh_dai_dien FROM tai_khoan WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row ? $row['anh_dai_dien'] : null;
    }

    public function deleteAvatar($user_id)
    {
        // Lấy đường dẫn ảnh cũ
        $old_avatar = $this->getAvatar($user_id);

        // Xóa file ảnh cũ nếu tồn tại
        if ($old_avatar && file_exists($_SERVER['DOCUMENT_ROOT'] . $old_avatar)) {
            unlink($_SERVER['DOCUMENT_ROOT'] . $old_avatar);
        }

        // Cập nhật database thành null
        $sql = "UPDATE tai_khoan SET anh_dai_dien = NULL WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        return $stmt->execute();
    }


}