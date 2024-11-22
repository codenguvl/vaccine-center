<?php
require_once __DIR__ . '/../config/mysql_connection.php';
require_once __DIR__ . '/../models/lich_tiem_model.php';

class LichTiemController
{
    private $lich_tiem_model;

    public function __construct($conn)
    {
        $this->lich_tiem_model = new LichTiemModel($conn);
    }

    public function getAllLichTiem()
    {
        return $this->lich_tiem_model->getAllLichTiem();
    }

    public function getLichTiemById($id)
    {
        return $this->lich_tiem_model->getLichTiemById($id);
    }

    public function getLichTiemByLichHen($lich_hen_id)
    {
        return $this->lich_tiem_model->getLichTiemByLichHen($lich_hen_id);
    }

    public function addLichTiem($khachhang_id, $vaccin_id, $ngay_tiem, $lan_tiem, $trang_thai, $ghi_chu)
    {
        return $this->lich_tiem_model->addLichTiem(
            $khachhang_id,
            $vaccin_id,
            $ngay_tiem,
            $lan_tiem,
            $trang_thai,
            $ghi_chu
        );
    }

    public function updateLichTiem($id, $khachhang_id, $vaccin_id, $ngay_tiem, $lan_tiem, $trang_thai, $ghi_chu)
    {
        return $this->lich_tiem_model->updateLichTiem(
            $id,
            $khachhang_id,
            $vaccin_id,
            $ngay_tiem,
            $lan_tiem,
            $trang_thai,
            $ghi_chu
        );
    }

    public function deleteLichTiem($id)
    {
        return $this->lich_tiem_model->deleteLichTiem($id);
    }

    public function capNhatTrangThaiTiem($id, $trang_thai, $ghi_chu = '')
    {
        $lich_tiem = $this->getLichTiemById($id);
        if (!$lich_tiem) {
            return false;
        }

        return $this->lich_tiem_model->updateLichTiem(
            $id,
            $lich_tiem['khachhang_id'],
            $lich_tiem['vaccin_id'],
            $lich_tiem['ngay_tiem'],
            $lich_tiem['lan_tiem'],
            $trang_thai,
            $ghi_chu
        );
    }

    public function taoLichTiemTiepTheo($lich_tiem_id, $ngay_tiem_tiep)
    {
        $lich_tiem_hien_tai = $this->getLichTiemById($lich_tiem_id);
        if (!$lich_tiem_hien_tai || $lich_tiem_hien_tai['trang_thai'] !== 'da_tiem') {
            return false;
        }

        return $this->addLichTiem(
            $lich_tiem_hien_tai['khachhang_id'],
            $lich_tiem_hien_tai['vaccin_id'],
            $ngay_tiem_tiep,
            $lich_tiem_hien_tai['lan_tiem'] + 1,
            'cho_tiem',
            'Lịch tiêm tiếp theo'
        );
    }
}