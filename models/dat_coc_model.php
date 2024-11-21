<?php
class DatCocModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function addDatCoc($vaccine_id, $phan_tram_dat_coc, $so_tien_dat_coc, $ngay_dat_coc, $trang_thai, $ghi_chu)
    {
        $sql = "INSERT INTO dat_coc (vaccine_id, phan_tram_dat_coc, so_tien_dat_coc, ngay_dat_coc, trang_thai, ghi_chu) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iidsss", $vaccine_id, $phan_tram_dat_coc, $so_tien_dat_coc, $ngay_dat_coc, $trang_thai, $ghi_chu);
        if ($stmt->execute()) {
            return $this->conn->insert_id;
        }
        return false;
    }

    public function getDatCocById($id)
    {
        $sql = "SELECT dc.*, v.ten_vaccine, v.gia_tien 
                FROM dat_coc dc 
                JOIN vaccine v ON dc.vaccine_id = v.vaccin_id 
                WHERE dc.dat_coc_id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return false;
        }
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            error_log("Execute failed: " . $stmt->error);
            return false;
        }
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updateDatCoc($id, $trang_thai, $ghi_chu)
    {
        $sql = "UPDATE dat_coc SET trang_thai = ?, ghi_chu = ? WHERE dat_coc_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssi", $trang_thai, $ghi_chu, $id);
        return $stmt->execute();
    }
}