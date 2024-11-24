<?php
class VaccineModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllVaccine()
    {
        $sql = "SELECT v.*, b.ten_benh, dt.ten_doi_tuong, pd.ten_phac_do, dk.ten_dieu_kien 
                FROM vaccine v 
                LEFT JOIN benh b ON v.benh_id = b.benh_id 
                LEFT JOIN doi_tuong_tiem_chung dt ON v.doi_tuong_id = dt.doi_tuong_id 
                LEFT JOIN phat_do_tiem pd ON v.phac_do_id = pd.phac_do_id 
                LEFT JOIN dieu_kien_tiem dk ON v.dieu_kien_id = dk.dieu_kien_id";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getVaccineById($id)
    {
        $sql = "SELECT * FROM vaccine WHERE vaccin_id = ?";
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

    public function addVaccine($data)
    {
        $sql = "INSERT INTO vaccine (ten_vaccine, nha_san_xuat, loai_vaccine, so_lo_san_xuat, 
                ngay_san_xuat, han_su_dung, ngay_nhap, mo_ta, gia_tien, so_luong, ghi_chu, 
                benh_id, doi_tuong_id, phac_do_id, dieu_kien_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return false;
        }

        $stmt->bind_param(
            "ssssssssdissiii",
            $data['ten_vaccine'],
            $data['nha_san_xuat'],
            $data['loai_vaccine'],
            $data['so_lo_san_xuat'],
            $data['ngay_san_xuat'],
            $data['han_su_dung'],
            $data['ngay_nhap'],
            $data['mo_ta'],
            $data['gia_tien'],
            $data['so_luong'],
            $data['ghi_chu'],
            $data['benh_id'],
            $data['doi_tuong_id'],
            $data['phac_do_id'],
            $data['dieu_kien_id']
        );

        $result = $stmt->execute();
        if (!$result) {
            error_log("Execute failed: " . $stmt->error);
        }
        return $result;
    }

    public function updateVaccine($id, $data)
    {
        $sql = "UPDATE vaccine SET 
                ten_vaccine = ?, nha_san_xuat = ?, loai_vaccine = ?, so_lo_san_xuat = ?,
                ngay_san_xuat = ?, han_su_dung = ?, ngay_nhap = ?, mo_ta = ?, gia_tien = ?,
                so_luong = ?, ghi_chu = ?, benh_id = ?, doi_tuong_id = ?, phac_do_id = ?,
                dieu_kien_id = ? 
                WHERE vaccin_id = ?";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return false;
        }

        $stmt->bind_param(
            "ssssssssdissiiii",
            $data['ten_vaccine'],
            $data['nha_san_xuat'],
            $data['loai_vaccine'],
            $data['so_lo_san_xuat'],
            $data['ngay_san_xuat'],
            $data['han_su_dung'],
            $data['ngay_nhap'],
            $data['mo_ta'],
            $data['gia_tien'],
            $data['so_luong'],
            $data['ghi_chu'],
            $data['benh_id'],
            $data['doi_tuong_id'],
            $data['phac_do_id'],
            $data['dieu_kien_id'],
            $id
        );

        $result = $stmt->execute();
        if (!$result) {
            error_log("Execute failed: " . $stmt->error);
        }
        return $result;
    }

    public function deleteVaccine($id)
    {
        $sql = "DELETE FROM vaccine WHERE vaccin_id = ?";
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

    public function reduceVaccineQuantity($id)
    {
        $sql = "UPDATE vaccine SET so_luong = so_luong - 1 WHERE vaccin_id = ? AND so_luong > 0";
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