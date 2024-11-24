<?php
class LieuLuongTiemModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllLieuLuongTiem()
    {
        $sql = "SELECT * FROM lieu_luong_tiem";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getLieuLuongTiemById($id)
    {
        $sql = "SELECT * FROM lieu_luong_tiem WHERE lieu_luong_id = ?";
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

    public function addLieuLuongTiem($mo_ta, $gia_tri)
    {
        $sql = "INSERT INTO lieu_luong_tiem (mo_ta, gia_tri) VALUES (?, ?)"; // Cập nhật câu lệnh SQL
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return false;
        }
        $stmt->bind_param("sd", $mo_ta, $gia_tri);
        $result = $stmt->execute();
        if (!$result) {
            error_log("Execute failed: " . $stmt->error);
        }
        return $result;
    }

    public function updateLieuLuongTiem($id, $mo_ta, $gia_tri)
    {
        $sql = "UPDATE lieu_luong_tiem SET mo_ta = ?, gia_tri = ? WHERE lieu_luong_id = ?"; // Cập nhật câu lệnh SQL
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return false;
        }
        $stmt->bind_param("sdi", $mo_ta, $gia_tri, $id);
        $result = $stmt->execute();
        if (!$result) {
            error_log("Execute failed: " . $stmt->error);
        }
        return $result;
    }

    public function deleteLieuLuongTiem($id)
    {
        $sql = "DELETE FROM lieu_luong_tiem WHERE lieu_luong_id = ?";
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
?>