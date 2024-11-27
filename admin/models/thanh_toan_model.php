<?php
class ThanhToanModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllThanhToan()
    {
        $sql = "SELECT tt.*, lh.ngay_hen, dc.so_tien_dat_coc, v.ten_vaccine, v.gia_tien, kh.fullname 
                FROM thanh_toan tt
                JOIN lich_hen lh ON tt.lich_hen_id = lh.lich_hen_id
                JOIN dat_coc dc ON tt.dat_coc_id = dc.dat_coc_id
                JOIN vaccine v ON dc.vaccine_id = v.vaccin_id
                JOIN khachhang kh ON lh.khachhang_id = kh.khachhang_id";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getThanhToanById($id)
    {
        $sql = "SELECT tt.*, lh.ngay_hen, dc.so_tien_dat_coc, v.ten_vaccine, v.gia_tien, kh.fullname 
                FROM thanh_toan tt
                JOIN lich_hen lh ON tt.lich_hen_id = lh.lich_hen_id
                JOIN dat_coc dc ON tt.dat_coc_id = dc.dat_coc_id
                JOIN vaccine v ON dc.vaccine_id = v.vaccin_id
                JOIN khachhang kh ON lh.khachhang_id = kh.khachhang_id
                WHERE tt.thanh_toan_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getThanhToanByLichHen($lich_hen_id)
    {
        $sql = "SELECT tt.*, dc.so_tien_dat_coc, v.gia_tien 
                FROM thanh_toan tt
                JOIN dat_coc dc ON tt.dat_coc_id = dc.dat_coc_id
                JOIN vaccine v ON dc.vaccine_id = v.vaccin_id
                WHERE tt.lich_hen_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $lich_hen_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function addThanhToan($lich_hen_id, $dat_coc_id)
    {
        $this->conn->begin_transaction();
        try {
            // Lấy thông tin vaccine và số tiền đặt cọc
            $sql = "SELECT v.gia_tien, dc.so_tien_dat_coc 
                    FROM dat_coc dc
                    JOIN vaccine v ON dc.vaccine_id = v.vaccin_id
                    WHERE dc.dat_coc_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $dat_coc_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $data = $result->fetch_assoc();

            // Tính số tiền còn lại
            $so_tien_con_lai = $data['gia_tien'] - $data['so_tien_dat_coc'];

            // Thêm thanh toán
            $sql = "INSERT INTO thanh_toan (lich_hen_id, dat_coc_id, so_tien_con_lai) 
                    VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iid", $lich_hen_id, $dat_coc_id, $so_tien_con_lai);
            $stmt->execute();

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            error_log($e->getMessage());
            return false;
        }
    }

    public function updateThanhToan($id, $trang_thai, $ngay_thanh_toan = null, $ghi_chu = '')
    {
        $sql = "UPDATE thanh_toan 
                SET trang_thai = ?, ngay_thanh_toan = ?, ghi_chu = ? 
                WHERE thanh_toan_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssi", $trang_thai, $ngay_thanh_toan, $ghi_chu, $id);
        return $stmt->execute();
    }

    public function deleteThanhToan($id)
    {
        $sql = "DELETE FROM thanh_toan WHERE thanh_toan_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function taoLichTiemSauThanhToan($thanh_toan_id)
    {
        $this->conn->begin_transaction();
        try {
            // Lấy thông tin thanh toán
            $sql = "SELECT tt.*, lh.khachhang_id, dc.vaccine_id 
                    FROM thanh_toan tt
                    JOIN lich_hen lh ON tt.lich_hen_id = lh.lich_hen_id
                    JOIN dat_coc dc ON tt.dat_coc_id = dc.dat_coc_id
                    WHERE tt.thanh_toan_id = ? AND tt.trang_thai = 'da_thanh_toan'";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $thanh_toan_id);
            $stmt->execute();
            $thanh_toan = $stmt->get_result()->fetch_assoc();

            if ($thanh_toan) {
                // Tạo lịch tiêm
                $sql = "INSERT INTO lich_tiem (khachhang_id, vaccin_id, ngay_tiem, lan_tiem, trang_thai) 
                        VALUES (?, ?, CURDATE(), 1, 'cho_tiem')";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("ii", $thanh_toan['khachhang_id'], $thanh_toan['vaccine_id']);
                $stmt->execute();
            }

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            error_log($e->getMessage());
            return false;
        }
    }

    public function addThanhToanTrucTiep($lich_hen_id, $dat_coc_id, $so_tien_con_lai, $ngay_thanh_toan = null)
    {
        try {
            // Thêm thanh toán trực tiếp
            $sql = "INSERT INTO thanh_toan (lich_hen_id, dat_coc_id, so_tien_con_lai, ngay_thanh_toan, trang_thai) 
                VALUES (?, ?, ?, COALESCE(?, CURRENT_DATE), 'chua_thanh_toan')";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iids", $lich_hen_id, $dat_coc_id, $so_tien_con_lai, $ngay_thanh_toan);

            if ($stmt->execute()) {
                return $this->conn->insert_id;
            }
            return false;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function addThanhToanAndLichTiem($khachhang_id, $vaccine_id, $so_tien_con_lai, $ngay_hen = null, $gio_bat_dau = null, $gio_ket_thuc = null, $ghi_chu = 'Được tạo tự động từ lịch tiêm', $tiem_ngay = true)
    {
        $this->conn->begin_transaction();
        try {
            // 1. Tạo bản ghi đặt cọc với phan_tram_dat_coc là 0% và so_tien_dat_coc là 0
            $sql = "INSERT INTO dat_coc (vaccine_id, phan_tram_dat_coc, so_tien_dat_coc, ngay_dat_coc, trang_thai) 
                VALUES (?, 0, 0, CURRENT_DATE, 'dat_coc')";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $vaccine_id);
            if (!$stmt->execute()) {
                throw new Exception("Không thể tạo đặt cọc: " . $stmt->error);
            }
            $dat_coc_id = $this->conn->insert_id;

            // 2. Tạo lịch hẹn
            $trang_thai = $tiem_ngay ? 'hoan_thanh' : 'cho_xac_nhan';
            $ngay = $tiem_ngay ? date('Y-m-d') : $ngay_hen;
            $gioBatDau = $tiem_ngay ? date('H:i:s') : $gio_bat_dau;
            $gioKetThuc = $tiem_ngay ? date('H:i:s', strtotime('+1 hour')) : $gio_ket_thuc; // Assuming 1 hour duration

            // Ghi chú được tạo tự động từ thanh toán
            $ghi_chu = $tiem_ngay ? 'Được tạo tự động từ thanh toán' : $ghi_chu;

            $sql = "INSERT INTO lich_hen (khachhang_id, ngay_hen, gio_bat_dau, gio_ket_thuc, trang_thai, ghi_chu, dat_coc_id) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("isssssi", $khachhang_id, $ngay, $gioBatDau, $gioKetThuc, $trang_thai, $ghi_chu, $dat_coc_id);
            if (!$stmt->execute()) {
                throw new Exception("Không thể tạo lịch hẹn: " . $stmt->error);
            }
            $lich_hen_id = $this->conn->insert_id;

            // 3. Tạo thanh toán trực tiếp
            $sql = "INSERT INTO thanh_toan (lich_hen_id, dat_coc_id, so_tien_con_lai, ngay_thanh_toan, trang_thai) 
                VALUES (?, ?, ?, CURRENT_DATE, 'chua_thanh_toan')";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iid", $lich_hen_id, $dat_coc_id, $so_tien_con_lai);
            if (!$stmt->execute()) {
                throw new Exception("Không thể tạo thanh toán: " . $stmt->error);
            }

            // 4. Tạo lịch tiêm
            if ($tiem_ngay) {
                $sql = "INSERT INTO lich_tiem (khachhang_id, vaccin_id, ngay_tiem, lan_tiem, trang_thai) 
                    VALUES (?, ?, CURRENT_DATE, 1, 'cho_tiem')";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("ii", $khachhang_id, $vaccine_id);
            } else {
                $sql = "INSERT INTO lich_tiem (khachhang_id, vaccin_id, ngay_tiem, lan_tiem, trang_thai) 
                    VALUES (?, ?, ?, 1, 'cho_tiem')";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("iis", $khachhang_id, $vaccine_id, $ngay);
            }
            if (!$stmt->execute()) {
                throw new Exception("Không thể tạo lịch tiêm: " . $stmt->error);
            }

            $this->conn->commit();
            return $lich_hen_id;
        } catch (Exception $e) {
            $this->conn->rollback();
            error_log("Lỗi trong addThanhToanAndLichTiem: " . $e->getMessage());
            throw new Exception("Không thể hoàn thành giao dịch: " . $e->getMessage());
        }
    }


}