<?php
require_once 'config/mysql_connection.php';

class VaiTroModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllVaiTro()
    {
        $sql = "SELECT * FROM vai_tro";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getVaiTroById($id)
    {
        $sql = "SELECT * FROM vai_tro WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return null;
        }
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            error_log("Execute failed: " . $stmt->error);
            return null;
        }
        $result = $stmt->get_result();
        $vai_tro = $result->fetch_assoc();
        if (!$vai_tro) {
            error_log("No vai_tro found with id: " . $id);
        }
        return $vai_tro;
    }



    public function createVaiTro($ten_vai_tro, $mo_ta, $chuc_nang_ids)
    {
        $sql = "INSERT INTO vai_tro (ten_vai_tro, mo_ta) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $ten_vai_tro, $mo_ta);
        $stmt->execute();
        $vai_tro_id = $stmt->insert_id;

        $this->updatePhanQuyen($vai_tro_id, $chuc_nang_ids);

        return $vai_tro_id;
    }

    public function updateVaiTro($id, $ten_vai_tro, $mo_ta, $chuc_nang_ids)
    {
        $this->conn->begin_transaction();

        try {
            $sql = "UPDATE vai_tro SET ten_vai_tro = ?, mo_ta = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssi", $ten_vai_tro, $mo_ta, $id);
            $stmt->execute();

            $this->updatePhanQuyen($id, $chuc_nang_ids);

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            error_log("Error updating vai_tro: " . $e->getMessage());
            return false;
        }
    }


    public function isVaiTroInUse($id)
    {
        $sql = "SELECT COUNT(*) as count FROM tai_khoan WHERE vai_tro_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'] > 0;
    }

    public function deleteVaiTro($id)
    {
        // Kiểm tra xem vai trò có đang được sử dụng không
        if ($this->isVaiTroInUse($id)) {
            return ['success' => false, 'message' => 'Không thể xóa vai trò này vì đang được sử dụng bởi một số tài khoản.'];
        }

        $sql = "DELETE FROM vai_tro WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            return ['success' => true, 'message' => 'Xóa vai trò thành công.'];
        } else {
            return ['success' => false, 'message' => 'Có lỗi xảy ra khi xóa vai trò.'];
        }
    }

    private function updatePhanQuyen($vai_tro_id, $chuc_nang_ids)
    {
        // Delete existing permissions
        $sql = "DELETE FROM phan_quyen WHERE vai_tro_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $vai_tro_id);
        $stmt->execute();

        // Insert new permissions
        $sql = "INSERT INTO phan_quyen (vai_tro_id, chuc_nang_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        foreach ($chuc_nang_ids as $chuc_nang_id) {
            $stmt->bind_param("ii", $vai_tro_id, $chuc_nang_id);
            $stmt->execute();
        }
    }

    public function getChucNangForVaiTro($vai_tro_id)
    {
        $sql = "SELECT c.id, c.ten_chuc_nang
                FROM chuc_nang c
                JOIN phan_quyen p ON c.id = p.chuc_nang_id
                WHERE p.vai_tro_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $vai_tro_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}