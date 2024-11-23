<?php
require_once __DIR__ . '/../config/mysql_connection.php';
require_once __DIR__ . '/../models/lich_hen_model.php';

class LichHenController
{
    private $lich_hen_model;

    public function __construct($conn)
    {
        $this->lich_hen_model = new LichHenModel($conn);
    }

    public function getAllLichHen()
    {
        return $this->lich_hen_model->getAllLichHen();
    }

    public function getLichHenById($id)
    {
        return $this->lich_hen_model->getLichHenById($id);
    }

    public function addLichHen($khachhang_id, $ngay_hen, $gio_bat_dau, $gio_ket_thuc, $trang_thai, $ghi_chu, $dat_coc_id = null)
    {
        return $this->lich_hen_model->addLichHen(
            $khachhang_id,
            $ngay_hen,
            $gio_bat_dau,
            $gio_ket_thuc,
            $trang_thai,
            $ghi_chu,
            $dat_coc_id
        );
    }
    public function updateLichHen($id, $khachhang_id, $ngay_hen, $gio_bat_dau, $gio_ket_thuc, $trang_thai, $ghi_chu, $dat_coc_id = null)
    {
        return $this->lich_hen_model->updateLichHen(
            $id,
            $khachhang_id,
            $ngay_hen,
            $gio_bat_dau,
            $gio_ket_thuc,
            $trang_thai,
            $ghi_chu,
            $dat_coc_id
        );
    }

    public function deleteLichHen($id)
    {
        return $this->lich_hen_model->deleteLichHen($id);
    }
    public function addLichHenDirectPayment($khachhang_id, $ngay_hen, $gio_hen, $ghi_chu, $vaccine_id, $so_tien, $tiem_ngay = true)
    {
        $trang_thai = $tiem_ngay ? 'hoan_thanh' : 'cho_xac_nhan';

        if ($tiem_ngay) {
            $ngay_hen = date('Y-m-d');
            $gio_hen = date('H:i:s');
        }

        try {
            $result = $this->lich_hen_model->addLichHenDirectPayment(
                $khachhang_id,
                $ngay_hen,
                $gio_hen,
                $trang_thai,
                $ghi_chu,
                $vaccine_id,
                $so_tien,
                $tiem_ngay
            );

            if ($result) {
                // Log thành công
                error_log("Thêm lịch hẹn trực tiếp thành công. ID: " . $result);
            } else {
                // Log thất bại
                error_log("Thêm lịch hẹn trực tiếp thất bại");
            }

            return $result;
        } catch (Exception $e) {
            // Log lỗi
            error_log("Lỗi khi thêm lịch hẹn trực tiếp: " . $e->getMessage());
            return false;
        }
    }

    public function getLichHenByPhoneOrCCCD($phoneOrCCCD)
    {
        return $this->lich_hen_model->getLichHenByPhoneOrCCCD($phoneOrCCCD);
    }
}