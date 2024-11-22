<?php
require_once __DIR__ . '/../config/mysql_connection.php';
require_once __DIR__ . '/../models/phan_ung_sau_tiem_model.php';

class PhanUngSauTiemController
{
    private $phan_ung_model;

    public function __construct($conn)
    {
        $this->phan_ung_model = new PhanUngSauTiemModel($conn);
    }

    public function getAllPhanUng()
    {
        try {
            return $this->phan_ung_model->getAllPhanUng();
        } catch (Exception $e) {
            error_log("Lỗi khi lấy danh sách phản ứng: " . $e->getMessage());
            return [];
        }
    }

    public function getPhanUngById($id)
    {
        try {
            $phan_ung = $this->phan_ung_model->getPhanUngById($id);
            if (!$phan_ung) {
                throw new Exception("Không tìm thấy phản ứng sau tiêm");
            }
            return $phan_ung;
        } catch (Exception $e) {
            error_log("Lỗi khi lấy thông tin phản ứng: " . $e->getMessage());
            return false;
        }
    }

    public function getPhanUngByLichTiem($lich_tiem_id)
    {
        try {
            return $this->phan_ung_model->getPhanUngByLichTiem($lich_tiem_id);
        } catch (Exception $e) {
            error_log("Lỗi khi lấy phản ứng theo lịch tiêm: " . $e->getMessage());
            return [];
        }
    }

    public function addPhanUng($lich_tiem_id, $phan_ung, $muc_do, $ghi_chu = '')
    {
        try {
            // Validate đầu vào
            if (empty($lich_tiem_id) || empty($phan_ung) || empty($muc_do)) {
                throw new Exception("Vui lòng điền đầy đủ thông tin bắt buộc");
            }

            // Validate mức độ
            if (!in_array($muc_do, ['nhe', 'trung_binh', 'nang'])) {
                throw new Exception("Mức độ phản ứng không hợp lệ");
            }

            return $this->phan_ung_model->addPhanUng($lich_tiem_id, $phan_ung, $muc_do, $ghi_chu);
        } catch (Exception $e) {
            error_log("Lỗi khi thêm phản ứng: " . $e->getMessage());
            throw $e;
        }
    }

    public function updatePhanUng($id, $phan_ung, $muc_do, $ghi_chu = '')
    {
        try {
            // Validate đầu vào
            if (empty($id) || empty($phan_ung) || empty($muc_do)) {
                throw new Exception("Vui lòng điền đầy đủ thông tin bắt buộc");
            }

            // Validate mức độ
            if (!in_array($muc_do, ['nhe', 'trung_binh', 'nang'])) {
                throw new Exception("Mức độ phản ứng không hợp lệ");
            }

            return $this->phan_ung_model->updatePhanUng($id, $phan_ung, $muc_do, $ghi_chu);
        } catch (Exception $e) {
            error_log("Lỗi khi cập nhật phản ứng: " . $e->getMessage());
            throw $e;
        }
    }

    public function deletePhanUng($id)
    {
        try {
            if (empty($id)) {
                throw new Exception("ID phản ứng không hợp lệ");
            }

            return $this->phan_ung_model->deletePhanUng($id);
        } catch (Exception $e) {
            error_log("Lỗi khi xóa phản ứng: " . $e->getMessage());
            throw $e;
        }
    }

    public function getThongKePhanUng($start_date = null, $end_date = null)
    {
        try {
            // Validate ngày tháng nếu có
            if ($start_date && $end_date) {
                if (strtotime($start_date) > strtotime($end_date)) {
                    throw new Exception("Ngày bắt đầu phải nhỏ hơn ngày kết thúc");
                }
            }

            return $this->phan_ung_model->getThongKePhanUng($start_date, $end_date);
        } catch (Exception $e) {
            error_log("Lỗi khi lấy thống kê phản ứng: " . $e->getMessage());
            throw $e;
        }
    }
}