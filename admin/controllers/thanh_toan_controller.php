<?php
require_once __DIR__ . '/../config/mysql_connection.php';
require_once __DIR__ . '/../models/thanh_toan_model.php';

class ThanhToanController
{
    private $thanh_toan_model;

    public function __construct($conn)
    {
        $this->thanh_toan_model = new ThanhToanModel($conn);
    }

    public function getAllThanhToan()
    {
        return $this->thanh_toan_model->getAllThanhToan();
    }

    public function getThanhToanById($id)
    {
        return $this->thanh_toan_model->getThanhToanById($id);
    }

    public function getThanhToanByLichHen($lich_hen_id)
    {
        return $this->thanh_toan_model->getThanhToanByLichHen($lich_hen_id);
    }

    public function addThanhToan($lich_hen_id, $dat_coc_id)
    {
        return $this->thanh_toan_model->addThanhToan($lich_hen_id, $dat_coc_id);
    }

    public function updateThanhToan($id, $trang_thai, $ngay_thanh_toan = null, $ghi_chu = '')
    {
        $result = $this->thanh_toan_model->updateThanhToan($id, $trang_thai, $ngay_thanh_toan, $ghi_chu);

        // Nếu cập nhật thành công và trạng thái là đã thanh toán, tạo lịch tiêm
        if ($result && $trang_thai === 'da_thanh_toan') {
            $this->thanh_toan_model->taoLichTiemSauThanhToan($id);
        }

        return $result;
    }

    public function deleteThanhToan($id)
    {
        return $this->thanh_toan_model->deleteThanhToan($id);
    }

    public function xuLyThanhToan($thanh_toan_id)
    {
        // Cập nhật trạng thái thanh toán và tạo lịch tiêm
        return $this->updateThanhToan(
            $thanh_toan_id,
            'da_thanh_toan',
            date('Y-m-d'),
            'Thanh toán hoàn tất'
        );
    }

    public function addThanhToanAndLichTiem($khachhang_id, $vaccine_id, $so_tien, $ngay_hen = null, $gio_bat_dau = null, $gio_ket_thuc = null, $ghi_chu = '', $tiem_ngay = true)
    {
        try {
            // Validate dữ liệu đầu vào
            if (empty($khachhang_id) || empty($vaccine_id) || empty($so_tien)) {
                throw new Exception("Thiếu thông tin bắt buộc");
            }

            if (!$tiem_ngay && (empty($ngay_hen) || empty($gio_bat_dau) || empty($gio_ket_thuc))) {
                throw new Exception("Cần nhập ngày giờ hẹn khi không tiêm ngay");
            }

            $result = $this->thanh_toan_model->addThanhToanAndLichTiem(
                $khachhang_id,
                $vaccine_id,
                $so_tien,
                $ngay_hen,
                $gio_bat_dau,
                $gio_ket_thuc,
                $ghi_chu,
                $tiem_ngay
            );

            if (!$result) {
                throw new Exception("Không thể tạo thanh toán");
            }

            return $result;
        } catch (Exception $e) {
            error_log("Lỗi trong ThanhToanController::addThanhToanAndLichTiem: " . $e->getMessage());
            throw $e;
        }
    }


}