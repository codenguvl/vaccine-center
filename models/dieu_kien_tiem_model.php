<?php
class DieuKienTiemModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllDieuKienTiem()
    {
        $sql = "SELECT * FROM dieu_kien_tiem";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getDieuKienTiemById($id)
    {
        $sql = "SELECT * FROM dieu_kien_tiem WHERE dieu_kien_id = ?";
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

    public function addDieuKienTiem($ten_dieu_kien, $mo_ta_dieu_kien)
    {
        $sql = "INSERT INTO dieu_kien_tiem (ten_dieu_kien, mo_ta_dieu_kien) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return false;
        }
        $stmt->bind_param("ss", $ten_dieu_kien, $mo_ta_dieu_kien);
        $result = $stmt->execute();
        if (!$result) {
            error_log("Execute failed: " . $stmt->error);
        }
        return $result;
    }

    public function updateDieuKienTiem($id, $ten_dieu_kien, $mo_ta_dieu_kien)
    {
        $sql = "UPDATE dieu_kien_tiem SET ten_dieu_kien = ?, mo_ta_dieu_kien = ? WHERE dieu_kien_id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return false;
        }
        $stmt->bind_param("ssi", $ten_dieu_kien, $mo_ta_dieu_kien, $id);
        $result = $stmt->execute();
        if (!$result) {
            error_log("Execute failed: " . $stmt->error);
        }
        return $result;
    }

    public function deleteDieuKienTiem($id)
    {
        $sql = "DELETE FROM dieu_kien_tiem WHERE dieu_kien_id = ?";
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