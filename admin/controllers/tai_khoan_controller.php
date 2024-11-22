<?php
require_once __DIR__ . '/../config/mysql_connection.php';
require_once __DIR__ . '/../models/tai_khoan_model.php';
require_once __DIR__ . '/../models/vai_tro_model.php';

class TaiKhoanController
{
    private $tai_khoan_model;
    private $vai_tro_model;

    public function __construct($conn)
    {
        $this->tai_khoan_model = new TaiKhoanModel($conn);
        $this->vai_tro_model = new VaiTroModel($conn);
    }

    public function getAllTaiKhoan()
    {
        return $this->tai_khoan_model->getAllTaiKhoan();
    }

    public function getTaiKhoanById($id)
    {
        return $this->tai_khoan_model->getTaiKhoanById($id);
    }

    public function addTaiKhoan($ten_dang_nhap, $mat_khau, $email, $ho_ten, $gioi_tinh, $dien_thoai, $vai_tro_id, $anh_dai_dien = null)
    {
        return $this->tai_khoan_model->createTaiKhoan($ten_dang_nhap, $mat_khau, $email, $ho_ten, $gioi_tinh, $dien_thoai, $vai_tro_id, $anh_dai_dien);
    }


    public function updateTaiKhoan($id, $email, $ho_ten, $gioi_tinh, $dien_thoai, $vai_tro_id, $trang_thai)
    {
        return $this->tai_khoan_model->updateTaiKhoan($id, $email, $ho_ten, $gioi_tinh, $dien_thoai, $vai_tro_id, $trang_thai);
    }

    public function deleteTaiKhoan($id)
    {
        return $this->tai_khoan_model->deleteTaiKhoan($id);
    }

    public function getAllVaiTro()
    {
        return $this->vai_tro_model->getAllVaiTro();
    }

    public function updateTrangThai($id, $trang_thai)
    {
        $result = $this->tai_khoan_model->updateTrangThai($id, $trang_thai);
        if ($result) {
            return ['success' => true, 'message' => 'Cập nhật trạng thái tài khoản thành công.'];
        } else {
            return ['success' => false, 'message' => 'Có lỗi xảy ra khi cập nhật trạng thái tài khoản.'];
        }
    }

    /* public function login($ten_dang_nhap, $mat_khau)
    {
        $user = $this->tai_khoan_model->authenticateUser($ten_dang_nhap, $mat_khau);
        if ($user) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['ho_ten'];
            $_SESSION['user_role'] = $user['vai_tro_id'];
            return true;
        }
        return false;
    } */
    public function login($ten_dang_nhap, $mat_khau)
    {
        $result = $this->tai_khoan_model->authenticateUser($ten_dang_nhap, $mat_khau);

        if ($result['status'] === 'success') {
            session_start();
            $_SESSION['user_id'] = $result['user']['id'];
            $_SESSION['user_name'] = $result['user']['ho_ten'];
            $_SESSION['user_role'] = $result['user']['vai_tro_id'];
            return ['success' => true];
        } elseif ($result['status'] === 'locked') {
            return ['success' => false, 'message' => 'locked'];
        } else {
            return ['success' => false, 'message' => 'invalid'];
        }
    }


    public function isLoggedIn()
    {
        session_start();
        return isset($_SESSION['user_id']);
    }

    public function logout()
    {
        session_start();
        session_destroy();
    }

    // Thêm vào class TaiKhoanController
    public function getTaiKhoanModel()
    {
        return $this->tai_khoan_model;
    }

    public function checkUserPermission($slug)
    {
        if (!$this->isLoggedIn()) {
            return false;
        }

        $user_id = $_SESSION['user_id'];
        return $this->tai_khoan_model->checkPermission($user_id, $slug);
    }

    public function handlePermissionCheck($slug)
    {
        $hasPermission = $this->checkUserPermission($slug);

        if ($hasPermission) {
            return [
                'success' => true,
                'message' => 'Bạn có quyền truy cập trang này!'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Bạn không có quyền truy cập trang này!'
            ];
        }
    }


    public function getUserByEmail($email)
    {
        return $this->tai_khoan_model->getUserByEmail($email);
    }

    public function updatePassword($user_id, $new_password)
    {
        return $this->tai_khoan_model->updatePassword($user_id, $new_password);
    }
    public function updateProfile($id, $email, $ho_ten, $gioi_tinh, $dien_thoai)
    {
        return $this->tai_khoan_model->updateProfile($id, $email, $ho_ten, $gioi_tinh, $dien_thoai);
    }

    public function verifyPassword($user_id, $password)
    {
        return $this->tai_khoan_model->verifyPassword($user_id, $password);
    }
    public function updatePasswordAfterTemp($user_id, $new_password)
    {
        return $this->tai_khoan_model->updatePasswordAfterTemp($user_id, $new_password);
    }

    public function uploadAvatar($user_id, $file)
    {
        try {
            // Kiểm tra file upload
            if ($file['error'] !== UPLOAD_ERR_OK) {
                throw new Exception('Error uploading file.');
            }

            // Kiểm tra loại file
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $file_info = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_file($file_info, $file['tmp_name']);
            finfo_close($file_info);

            if (!in_array($mime_type, $allowed_types)) {
                throw new Exception('Invalid file type. Only JPG, PNG and GIF are allowed.');
            }

            // Kiểm tra kích thước file (giới hạn 5MB)
            if ($file['size'] > 5 * 1024 * 1024) {
                throw new Exception('File is too large. Maximum size is 5MB.');
            }

            // Tạo tên file mới
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $new_filename = 'avatar_' . $user_id . '_' . time() . '.' . $extension;

            // Tạo thư mục uploads nếu chưa tồn tại
            $upload_dir = $_SERVER['DOCUMENT_ROOT'] . 'uploads/avatars/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // Đường dẫn đầy đủ của file
            $upload_path = $upload_dir . $new_filename;

            // Di chuyển file upload vào thư mục đích
            if (!move_uploaded_file($file['tmp_name'], $upload_path)) {
                throw new Exception('Failed to move uploaded file.');
            }

            // Xóa ảnh cũ nếu có
            $this->tai_khoan_model->deleteAvatar($user_id);

            // Cập nhật đường dẫn trong database
            $relative_path = 'uploads/avatars/' . $new_filename;
            $result = $this->tai_khoan_model->updateAvatar($user_id, $relative_path);

            if ($result) {
                return [
                    'success' => true,
                    'path' => $relative_path,
                    'message' => 'Avatar updated successfully.'
                ];
            } else {
                throw new Exception('Failed to update avatar in database.');
            }

        } catch (Exception $e) {
            error_log("Error uploading avatar: " . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function deleteAvatar($user_id)
    {
        try {
            $result = $this->tai_khoan_model->deleteAvatar($user_id);
            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Avatar deleted successfully.'
                ];
            } else {
                throw new Exception('Failed to delete avatar.');
            }
        } catch (Exception $e) {
            error_log("Error deleting avatar: " . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function getAvatar($user_id)
    {
        $avatar_path = $this->tai_khoan_model->getAvatar($user_id);
        if (!$avatar_path) {
            return 'static/images/default-avatar.png'; // Đường dẫn đến ảnh mặc định
        }
        return $avatar_path;
    }

    public function handleAvatarUpload($file)
    {
        try {
            // Kiểm tra file upload
            if ($file['error'] !== UPLOAD_ERR_OK) {
                throw new Exception('Error uploading file.');
            }

            // Kiểm tra loại file
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $file_info = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_file($file_info, $file['tmp_name']);
            finfo_close($file_info);

            if (!in_array($mime_type, $allowed_types)) {
                throw new Exception('Invalid file type. Only JPG, PNG and GIF are allowed.');
            }

            // Kiểm tra kích thước file (giới hạn 5MB)
            if ($file['size'] > 5 * 1024 * 1024) {
                throw new Exception('File is too large. Maximum size is 5MB.');
            }

            // Tạo tên file mới
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $new_filename = 'avatar_' . time() . '_' . uniqid() . '.' . $extension;

            // Thay đổi đường dẫn thư mục upload
            // Đảm bảo thư mục uploads đã tồn tại trong thư mục gốc của dự án
            $upload_dir = __DIR__ . '/../uploads/avatars/';  // Dùng __DIR__ để lấy đường dẫn hiện tại của file PHP và quay lại thư mục gốc
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // Đường dẫn đầy đủ của file
            $upload_path = $upload_dir . $new_filename;

            // Di chuyển file upload vào thư mục đích
            if (!move_uploaded_file($file['tmp_name'], $upload_path)) {
                throw new Exception('Failed to move uploaded file.');
            }

            // Trả về đường dẫn tương đối
            return [
                'success' => true,
                'path' => 'uploads/avatars/' . $new_filename,
                'message' => 'Avatar uploaded successfully.'
            ];

        } catch (Exception $e) {
            error_log("Error uploading avatar: " . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function updateAvatar($user_id, $avatar_path)
    {
        return $this->tai_khoan_model->updateAvatar($user_id, $avatar_path);
    }


}