<?php
class PhanUngSauTiemModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllPhanUng()
    {
        $sql = "SELECT pust.*, lt.ngay_tiem, v.ten_vaccine, kh.fullname, kh.dienthoai
                FROM phan_ung_sau_tiem pust
                JOIN lich_tiem lt ON pust.lich_tiem_id = lt.lich_tiem_id
                JOIN vaccine v ON lt.vaccin_id = v.vaccin_id
                JOIN khachhang kh ON lt.khachhang_id = kh.khachhang_id
                ORDER BY pust.ngay_xu_ly DESC";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getPhanUngById($id)
    {
        $sql = "SELECT pust.*, lt.ngay_tiem, v.ten_vaccine, kh.fullname, kh.dienthoai
                FROM phan_ung_sau_tiem pust
                JOIN lich_tiem lt ON pust.lich_tiem_id = lt.lich_tiem_id
                JOIN vaccine v ON lt.vaccin_id = v.vaccin_id
                JOIN khachhang kh ON lt.khachhang_id = kh.khachhang_id
                WHERE pust.phan_ung_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getPhanUngByLichTiem($lich_tiem_id)
    {
        $sql = "SELECT pust.*, lt.ngay_tiem, v.ten_vaccine, kh.fullname, kh.dienthoai
                FROM phan_ung_sau_tiem pust
                JOIN lich_tiem lt ON pust.lich_tiem_id = lt.lich_tiem_id
                JOIN vaccine v ON lt.vaccin_id = v.vaccin_id
                JOIN khachhang kh ON lt.khachhang_id = kh.khachhang_id
                WHERE pust.lich_tiem_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $lich_tiem_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addPhanUng($lich_tiem_id, $phan_ung, $muc_do, $ghi_chu = '')
    {
        try {
            // Kiểm tra xem lịch tiêm có tồn tại và đã tiêm chưa
            $sql = "SELECT trang_thai FROM lich_tiem WHERE lich_tiem_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $lich_tiem_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $lich_tiem = $result->fetch_assoc();

            if (!$lich_tiem) {
                throw new Exception("Không tìm thấy lịch tiêm");
            }

            if ($lich_tiem['trang_thai'] !== 'da_tiem') {
                throw new Exception("Lịch tiêm chưa được thực hiện");
            }

            // Thêm phản ứng sau tiêm
            $sql = "INSERT INTO phan_ung_sau_tiem (lich_tiem_id, phan_ung, muc_do, ghi_chu) 
                    VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("isss", $lich_tiem_id, $phan_ung, $muc_do, $ghi_chu);

            if (!$stmt->execute()) {
                throw new Exception("Không thể thêm phản ứng sau tiêm");
            }

            return $this->conn->insert_id;
        } catch (Exception $e) {
            error_log("Lỗi khi thêm phản ứng sau tiêm: " . $e->getMessage());
            throw $e;
        }
    }

    public function updatePhanUng($id, $phan_ung, $muc_do, $ghi_chu = '')
    {
        try {
            $sql = "UPDATE phan_ung_sau_tiem 
                    SET phan_ung = ?, muc_do = ?, ghi_chu = ?, ngay_xu_ly = CURRENT_TIMESTAMP 
                    WHERE phan_ung_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sssi", $phan_ung, $muc_do, $ghi_chu, $id);

            if (!$stmt->execute()) {
                throw new Exception("Không thể cập nhật phản ứng sau tiêm");
            }

            return true;
        } catch (Exception $e) {
            error_log("Lỗi khi cập nhật phản ứng sau tiêm: " . $e->getMessage());
            throw $e;
        }
    }

    public function deletePhanUng($id)
    {
        try {
            $sql = "DELETE FROM phan_ung_sau_tiem WHERE phan_ung_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id);

            if (!$stmt->execute()) {
                throw new Exception("Không thể xóa phản ứng sau tiêm");
            }

            return true;
        } catch (Exception $e) {
            error_log("Lỗi khi xóa phản ứng sau tiêm: " . $e->getMessage());
            throw $e;
        }
    }

    public function getThongKePhanUng($start_date = null, $end_date = null)
    {
        try {
            $where_clause = "";
            $params = [];
            $types = "";

            if ($start_date && $end_date) {
                $where_clause = "WHERE pust.ngay_xu_ly BETWEEN ? AND ?";
                $params = [$start_date, $end_date];
                $types = "ss";
            }

            $sql = "SELECT 
                        v.ten_vaccine,
                        COUNT(*) as total_reactions,
                        SUM(CASE WHEN pust.muc_do = 'nhe' THEN 1 ELSE 0 END) as nhe,
                        SUM(CASE WHEN pust.muc_do = 'trung_binh' THEN 1 ELSE 0 END) as trung_binh,
                        SUM(CASE WHEN pust.muc_do = 'nang' THEN 1 ELSE 0 END) as nang
                    FROM phan_ung_sau_tiem pust
                    JOIN lich_tiem lt ON pust.lich_tiem_id = lt.lich_tiem_id
                    JOIN vaccine v ON lt.vaccin_id = v.vaccin_id
                    $where_clause
                    GROUP BY v.vaccin_id";

            if (!empty($params)) {
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param($types, ...$params);
                $stmt->execute();
                $result = $stmt->get_result();
            } else {
                $result = $this->conn->query($sql);
            }

            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log("Lỗi khi lấy thống kê phản ứng: " . $e->getMessage());
            throw $e;
        }
    }
}