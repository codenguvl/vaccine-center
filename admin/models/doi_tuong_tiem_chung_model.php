<?php
class DoiTuongTiemChungModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllDoiTuong()
    {
        $sql = "SELECT * FROM doi_tuong_tiem_chung ORDER BY doi_tuong_id DESC";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getDoiTuongById($id)
    {
        $sql = "SELECT * FROM doi_tuong_tiem_chung WHERE doi_tuong_id = ?";
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

    public function addDoiTuong($ten_doi_tuong)
    {
        $sql = "INSERT INTO doi_tuong_tiem_chung (ten_doi_tuong) VALUES (?)";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return false;
        }
        $stmt->bind_param("s", $ten_doi_tuong);
        $result = $stmt->execute();
        if (!$result) {
            error_log("Execute failed: " . $stmt->error);
        }
        return $result;
    }

    public function updateDoiTuong($id, $ten_doi_tuong)
    {
        $sql = "UPDATE doi_tuong_tiem_chung SET ten_doi_tuong = ? WHERE doi_tuong_id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return false;
        }
        $stmt->bind_param("si", $ten_doi_tuong, $id);
        $result = $stmt->execute();
        if (!$result) {
            error_log("Execute failed: " . $stmt->error);
        }
        return $result;
    }

    public function deleteDoiTuong($id)
    {
        $sql = "DELETE FROM doi_tuong_tiem_chung WHERE doi_tuong_id = ?";
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