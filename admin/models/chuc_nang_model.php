<?php
class ChucNangModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    public function getAllChucNang()
    {
        $sql = "SELECT * FROM chuc_nang ORDER BY id DESC";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function getChucNangById($id)
    {
        $sql = "SELECT * FROM chuc_nang WHERE id = ?";
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

    public function addChucNang($ten_chuc_nang, $mo_ta, $duong_dan)
    {
        $sql = "INSERT INTO chuc_nang (ten_chuc_nang, mo_ta, duong_dan) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return false;
        }
        $stmt->bind_param("sss", $ten_chuc_nang, $mo_ta, $duong_dan);
        $result = $stmt->execute();
        if (!$result) {
            error_log("Execute failed: " . $stmt->error);
        }
        return $result;
    }

    public function updateChucNang($id, $ten_chuc_nang, $mo_ta, $duong_dan)
    {
        $sql = "UPDATE chuc_nang SET ten_chuc_nang = ?, mo_ta = ?, duong_dan = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return false;
        }
        $stmt->bind_param("sssi", $ten_chuc_nang, $mo_ta, $duong_dan, $id);
        $result = $stmt->execute();
        if (!$result) {
            error_log("Execute failed: " . $stmt->error);
        }
        return $result;
    }

    public function deleteChucNang($id)
    {
        $sql = "DELETE FROM chuc_nang WHERE id = ?";
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