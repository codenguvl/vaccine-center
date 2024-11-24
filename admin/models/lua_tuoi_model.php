<?php
class LuaTuoiModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllLuaTuoi()
    {
        $sql = "SELECT * FROM lua_tuoi";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getLuaTuoiById($id)
    {
        $sql = "SELECT * FROM lua_tuoi WHERE lua_tuoi_id = ?";
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

    public function addLuaTuoi($ten_lua_tuoi, $mo_ta)
    {
        $sql = "INSERT INTO lua_tuoi (ten_lua_tuoi, mo_ta) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return false;
        }
        $stmt->bind_param("ss", $ten_lua_tuoi, $mo_ta);
        $result = $stmt->execute();
        if (!$result) {
            error_log("Execute failed: " . $stmt->error);
        }
        return $result;
    }

    public function updateLuaTuoi($id, $ten_lua_tuoi, $mo_ta)
    {
        $sql = "UPDATE lua_tuoi SET ten_lua_tuoi = ?, mo_ta = ? WHERE lua_tuoi_id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return false;
        }
        $stmt->bind_param("ssi", $ten_lua_tuoi, $mo_ta, $id);
        $result = $stmt->execute();
        if (!$result) {
            error_log("Execute failed: " . $stmt->error);
        }
        return $result;
    }

    public function deleteLuaTuoi($id)
    {
        $sql = "DELETE FROM lua_tuoi WHERE lua_tuoi_id = ?";
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