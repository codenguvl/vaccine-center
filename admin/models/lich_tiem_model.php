<?php
class LichTiemModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllLichTiem()
    {
        $sql = "SELECT lt.*, kh.fullname, kh.dienthoai, v.ten_vaccine, v.gia_tien 
                FROM lich_tiem lt 
                JOIN khachhang kh ON lt.khachhang_id = kh.khachhang_id
                JOIN vaccine v ON lt.vaccin_id = v.vaccin_id";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getLichTiemById($id)
    {
        $sql = "SELECT lt.*, kh.fullname, kh.dienthoai, v.ten_vaccine, v.gia_tien 
                FROM lich_tiem lt 
                JOIN khachhang kh ON lt.khachhang_id = kh.khachhang_id
                JOIN vaccine v ON lt.vaccin_id = v.vaccin_id 
                WHERE lt.lich_tiem_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getLichTiemByLichHen($lich_hen_id)
    {
        $sql = "SELECT lt.*, v.ten_vaccine 
            FROM lich_tiem lt 
            JOIN vaccine v ON lt.vaccin_id = v.vaccin_id 
            JOIN thanh_toan tt ON tt.lich_hen_id = ?
            WHERE lt.khachhang_id = (
                SELECT lh.khachhang_id 
                FROM lich_hen lh 
                WHERE lh.lich_hen_id = ?
            )
            AND lt.vaccin_id = (
                SELECT dc.vaccine_id 
                FROM dat_coc dc 
                JOIN lich_hen lh ON lh.dat_coc_id = dc.dat_coc_id 
                WHERE lh.lich_hen_id = ?
            )
            ORDER BY lt.ngay_tao DESC 
            LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iii", $lich_hen_id, $lich_hen_id, $lich_hen_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function addLichTiem($khachhang_id, $vaccin_id, $ngay_tiem, $lan_tiem, $trang_thai, $ghi_chu)
    {
        $sql = "INSERT INTO lich_tiem (khachhang_id, vaccin_id, ngay_tiem, lan_tiem, trang_thai, ghi_chu) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iisiss", $khachhang_id, $vaccin_id, $ngay_tiem, $lan_tiem, $trang_thai, $ghi_chu);
        return $stmt->execute();
    }

    public function updateLichTiem($id, $khachhang_id, $vaccin_id, $ngay_tiem, $lan_tiem, $trang_thai, $ghi_chu)
    {
        $sql = "UPDATE lich_tiem 
                SET khachhang_id = ?, vaccin_id = ?, ngay_tiem = ?, lan_tiem = ?, trang_thai = ?, ghi_chu = ? 
                WHERE lich_tiem_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iisissi", $khachhang_id, $vaccin_id, $ngay_tiem, $lan_tiem, $trang_thai, $ghi_chu, $id);
        return $stmt->execute();
    }

    public function deleteLichTiem($id)
    {
        $sql = "DELETE FROM lich_tiem WHERE lich_tiem_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}