<?php
class PhacDoTiemModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllPhacDoTiem()
    {
        $sql = "SELECT pdt.*, lt.mo_ta as lua_tuoi_mo_ta, llt.mo_ta as lieu_luong_mo_ta 
                FROM phat_do_tiem pdt
                LEFT JOIN lua_tuoi lt ON pdt.lua_tuoi_id = lt.lua_tuoi_id
                LEFT JOIN lieu_luong_tiem llt ON pdt.lieu_luong_id = llt.lieu_luong_id";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getPhacDoTiemById($id)
    {
        $sql = "SELECT pdt.*, lt.mo_ta as lua_tuoi_mo_ta, llt.mo_ta as lieu_luong_mo_ta 
                FROM phat_do_tiem pdt
                LEFT JOIN lua_tuoi lt ON pdt.lua_tuoi_id = lt.lua_tuoi_id
                LEFT JOIN lieu_luong_tiem llt ON pdt.lieu_luong_id = llt.lieu_luong_id
                WHERE pdt.phac_do_id = ?";
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

    public function getAllLuaTuoi()
    {
        $sql = "SELECT * FROM lua_tuoi";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllLieuLuong()
    {
        $sql = "SELECT * FROM lieu_luong_tiem";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addPhacDoTiem($ten_phac_do, $lua_tuoi_id, $lieu_luong_id, $lich_tiem, $lieu_nhac, $ghi_chu)
    {
        $sql = "INSERT INTO phat_do_tiem (ten_phac_do, lua_tuoi_id, lieu_luong_id, lich_tiem, lieu_nhac, ghi_chu) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return false;
        }
        $stmt->bind_param("siisss", $ten_phac_do, $lua_tuoi_id, $lieu_luong_id, $lich_tiem, $lieu_nhac, $ghi_chu);
        $result = $stmt->execute();
        if (!$result) {
            error_log("Execute failed: " . $stmt->error);
        }
        return $result;
    }

    public function updatePhacDoTiem($id, $ten_phac_do, $lua_tuoi_id, $lieu_luong_id, $lich_tiem, $lieu_nhac, $ghi_chu)
    {
        $sql = "UPDATE phat_do_tiem 
                SET ten_phac_do = ?, lua_tuoi_id = ?, lieu_luong_id = ?, 
                    lich_tiem = ?, lieu_nhac = ?, ghi_chu = ? 
                WHERE phac_do_id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return false;
        }
        $stmt->bind_param("siisssi", $ten_phac_do, $lua_tuoi_id, $lieu_luong_id, $lich_tiem, $lieu_nhac, $ghi_chu, $id);
        $result = $stmt->execute();
        if (!$result) {
            error_log("Execute failed: " . $stmt->error);
        }
        return $result;
    }

    public function deletePhacDoTiem($id)
    {
        $sql = "DELETE FROM phat_do_tiem WHERE phac_do_id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return false;
        }
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        if (!$result) {
            error_log("Execute failed: " . $stmt->error);
        }
        return $result;
    }
}