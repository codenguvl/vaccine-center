<?php
class LichHenModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllLichHen()
    {
        $sql = "SELECT lh.*, kh.fullname, kh.dienthoai, kh.email, dc.so_tien_dat_coc, v.ten_vaccine 
                FROM lich_hen lh 
                JOIN khachhang kh ON lh.khachhang_id = kh.khachhang_id
                LEFT JOIN dat_coc dc ON lh.dat_coc_id = dc.dat_coc_id
                LEFT JOIN vaccine v ON dc.vaccine_id = v.vaccin_id
                ORDER BY lh.ngay_hen, lh.gio_bat_dau";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getLichHenById($id)
    {
        $sql = "SELECT lh.*, kh.fullname, kh.dienthoai, dc.*, v.ten_vaccine, v.gia_tien 
                FROM lich_hen lh 
                JOIN khachhang kh ON lh.khachhang_id = kh.khachhang_id
                LEFT JOIN dat_coc dc ON lh.dat_coc_id = dc.dat_coc_id
                LEFT JOIN vaccine v ON dc.vaccine_id = v.vaccin_id 
                WHERE lh.lich_hen_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }


    public function addLichHen($khachhang_id, $ngay_hen, $gio_bat_dau, $gio_ket_thuc, $trang_thai, $ghi_chu, $dat_coc_id = null)
    {
        $sql = "INSERT INTO lich_hen (khachhang_id, ngay_hen, gio_bat_dau, gio_ket_thuc, trang_thai, ghi_chu, dat_coc_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isssssi", $khachhang_id, $ngay_hen, $gio_bat_dau, $gio_ket_thuc, $trang_thai, $ghi_chu, $dat_coc_id);
        return $stmt->execute();
    }


    public function updateLichHen($id, $khachhang_id, $ngay_hen, $gio_bat_dau, $gio_ket_thuc, $trang_thai, $ghi_chu, $dat_coc_id = null)
    {
        $this->conn->begin_transaction();
        try {
            // Lấy thông tin cũ của lịch hẹn
            $sql = "SELECT trang_thai, dat_coc_id FROM lich_hen WHERE lich_hen_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $old_data = $result->fetch_assoc();

            // Nếu không có đặt cọc mới, giữ nguyên đặt cọc cũ
            if ($dat_coc_id === null) {
                $dat_coc_id = $old_data['dat_coc_id'];
            }

            // Cập nhật lịch hẹn
            $sql = "UPDATE lich_hen 
                SET khachhang_id = ?, 
                    ngay_hen = ?, 
                    gio_bat_dau = ?, 
                    gio_ket_thuc = ?, 
                    trang_thai = ?, 
                    ghi_chu = ?, 
                    dat_coc_id = ? 
                WHERE lich_hen_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param(
                "isssssii",
                $khachhang_id,
                $ngay_hen,
                $gio_bat_dau,
                $gio_ket_thuc,
                $trang_thai,
                $ghi_chu,
                $dat_coc_id,
                $id
            );
            $stmt->execute();

            // Xử lý tạo lịch tiêm khi xác nhận
            if ($trang_thai == 'da_xac_nhan' && $old_data['trang_thai'] != 'da_xac_nhan') {
                if ($dat_coc_id) {
                    $sql = "SELECT vaccine_id FROM dat_coc WHERE dat_coc_id = ?";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bind_param("i", $dat_coc_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $dat_coc = $result->fetch_assoc();

                    if ($dat_coc) {
                        $sql = "INSERT INTO lich_tiem (khachhang_id, vaccin_id, ngay_tiem, lan_tiem, trang_thai, ghi_chu) 
                            VALUES (?, ?, ?, 1, 'cho_tiem', 'Tạo tự động từ lịch hẹn')";
                        $stmt = $this->conn->prepare($sql);
                        $stmt->bind_param("iis", $khachhang_id, $dat_coc['vaccine_id'], $ngay_hen);
                        $stmt->execute();
                    }
                }
            }

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            error_log($e->getMessage());
            return false;
        }
    }


    public function deleteLichHen($id)
    {
        $this->conn->begin_transaction();
        try {
            // Lấy dat_coc_id trước khi xóa lịch hẹn
            $sql = "SELECT dat_coc_id FROM lich_hen WHERE lich_hen_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $lich_hen = $result->fetch_assoc();

            // Xóa lịch hẹn
            $sql = "DELETE FROM lich_hen WHERE lich_hen_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();

            // Nếu có đặt cọc, cập nhật trạng thái đặt cọc thành 'hoan_tien'
            if ($lich_hen['dat_coc_id']) {
                $sql = "UPDATE dat_coc SET trang_thai = 'hoan_tien' WHERE dat_coc_id = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("i", $lich_hen['dat_coc_id']);
                $stmt->execute();
            }

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            return false;
        }
    }

    public function addLichHenDirectPayment($khachhang_id, $ngay_hen, $gio_hen, $trang_thai, $ghi_chu, $vaccine_id, $so_tien, $tiem_ngay = true)
    {
        $this->conn->begin_transaction();
        try {

            $sql = "INSERT INTO lich_hen (khachhang_id, ngay_hen, gio_hen, trang_thai, ghi_chu) 
                VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $trang_thai = $tiem_ngay ? 'hoan_thanh' : 'cho_xac_nhan';
            $stmt->bind_param("issss", $khachhang_id, $ngay_hen, $gio_hen, $trang_thai, $ghi_chu);
            $stmt->execute();
            $lich_hen_id = $this->conn->insert_id;

            // Thêm thanh toán
            $sql = "INSERT INTO thanh_toan (lich_hen_id, so_tien_thanh_toan, ngay_thanh_toan, trang_thai, ghi_chu) 
                VALUES (?, ?, CURRENT_DATE, 'da_thanh_toan', 'Thanh toán trực tiếp')";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("id", $lich_hen_id, $so_tien);
            $stmt->execute();

            // Nếu tiêm ngay, tạo lịch tiêm với trạng thái đã tiêm
            if ($tiem_ngay) {
                $sql = "INSERT INTO lich_tiem (khachhang_id, vaccin_id, ngay_tiem, lan_tiem, trang_thai) 
                    VALUES (?, ?, CURRENT_DATE, 1, 'da_tiem')";
            } else {
                $sql = "INSERT INTO lich_tiem (khachhang_id, vaccin_id, ngay_tiem, lan_tiem, trang_thai) 
                    VALUES (?, ?, ?, 1, 'cho_tiem')";
            }
            $stmt = $this->conn->prepare($sql);
            if ($tiem_ngay) {
                $stmt->bind_param("ii", $khachhang_id, $vaccine_id);
            } else {
                $stmt->bind_param("iis", $khachhang_id, $vaccine_id, $ngay_hen);
            }
            $stmt->execute();

            $this->conn->commit();
            return $lich_hen_id;
        } catch (Exception $e) {
            $this->conn->rollback();
            error_log($e->getMessage());
            return false;
        }
    }

}