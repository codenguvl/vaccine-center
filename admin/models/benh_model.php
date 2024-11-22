<?php
class BenhModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllBenh()
    {
        $sql = "SELECT b.*, dmb.ten_danh_muc 
                FROM benh b 
                LEFT JOIN danh_muc_benh dmb ON b.danh_muc_id = dmb.danh_muc_id";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getBenhById($id)
    {
        $sql = "SELECT * FROM benh WHERE benh_id = ?";
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

    public function addBenh($ten_benh, $danh_muc_id)
    {
        $sql = "INSERT INTO benh (ten_benh, danh_muc_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return false;
        }
        $stmt->bind_param("si", $ten_benh, $danh_muc_id);
        $result = $stmt->execute();
        if (!$result) {
            error_log("Execute failed: " . $stmt->error);
        }
        return $result;
    }

    public function updateBenh($id, $ten_benh, $danh_muc_id)
    {
        $sql = "UPDATE benh SET ten_benh = ?, danh_muc_id = ? WHERE benh_id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return false;
        }
        $stmt->bind_param("sii", $ten_benh, $danh_muc_id, $id);
        $result = $stmt->execute();
        if (!$result) {
            error_log("Execute failed: " . $stmt->error);
        }
        return $result;
    }

    public function deleteBenh($id)
    {
        $sql = "DELETE FROM benh WHERE benh_id = ?";
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