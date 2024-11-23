<?php
class DangKyTiemTaiNhaModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllDangKy()
    {
        $sql = "SELECT * FROM dang_ky_tiem_tai_nha";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getDangKyById($id)
    {
        $sql = "SELECT * FROM dang_ky_tiem_tai_nha WHERE dang_ky_id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return false;
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            return false;
        }
        return $result->fetch_assoc();
    }

    public function addDangKy($ho_ten, $ngay_sinh, $gioi_tinh, $tinh_thanh, $quan_huyen, $phuong_xa, $dia_chi, $ho_ten_lien_he, $quan_he, $dien_thoai_lien_he, $ngay_mong_muon)
    {
        $sql = "INSERT INTO dang_ky_tiem_tai_nha (ho_ten, ngay_sinh, gioi_tinh, tinh_thanh, quan_huyen, phuong_xa, dia_chi, ho_ten_lien_he, quan_he, dien_thoai_lien_he, ngay_mong_muon) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return false;
        }
        $stmt->bind_param("sssssssssss", $ho_ten, $ngay_sinh, $gioi_tinh, $tinh_thanh, $quan_huyen, $phuong_xa, $dia_chi, $ho_ten_lien_he, $quan_he, $dien_thoai_lien_he, $ngay_mong_muon);
        $result = $stmt->execute();
        if (!$result) {
            error_log("Execute failed: " . $stmt->error);
        }
        return $result;
    }

    public function updateDangKy($dang_ky_id, $ho_ten, $ngay_sinh, $gioi_tinh, $tinh_thanh, $quan_huyen, $phuong_xa, $dia_chi, $ho_ten_lien_he, $quan_he, $dien_thoai_lien_he, $ngay_mong_muon)
    {
        $sql = "UPDATE dang_ky_tiem_tai_nha SET ho_ten = ?, ngay_sinh = ?, gioi_tinh = ?, tinh_thanh = ?, quan_huyen = ?, phuong_xa = ?, dia_chi = ?, ho_ten_lien_he = ?, quan_he = ?, dien_thoai_lien_he = ?, ngay_mong_muon = ? WHERE dang_ky_id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return false;
        }
        $stmt->bind_param("sssssssssssi", $ho_ten, $ngay_sinh, $gioi_tinh, $tinh_thanh, $quan_huyen, $phuong_xa, $dia_chi, $ho_ten_lien_he, $quan_he, $dien_thoai_lien_he, $ngay_mong_muon, $dang_ky_id);
        $result = $stmt->execute();
        if (!$result) {
            error_log("Execute failed: " . $stmt->error);
        }
        return $result;
    }

    public function deleteDangKy($dang_ky_id)
    {
        $sql = "DELETE FROM dang_ky_tiem_tai_nha WHERE dang_ky_id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return false;
        }
        $stmt->bind_param("i", $dang_ky_id);
        $result = $stmt->execute();
        if (!$result) {
            error_log("Execute failed: " . $stmt->error);
        }
        return $result;
    }

    public function updateStatus($dang_ky_id, $new_status) // Thêm phương thức cập nhật trạng thái
    {
        $sql = "UPDATE dang_ky_tiem_tai_nha SET trang_thai = ? WHERE dang_ky_id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return false;
        }
        $stmt->bind_param("si", $new_status, $dang_ky_id);
        $result = $stmt->execute();
        if (!$result) {
            error_log("Execute failed: " . $stmt->error);
        }
        return $result;
    }
}