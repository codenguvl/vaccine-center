<?php
require_once __DIR__ . '/../config/mysql_connection.php';
require_once __DIR__ . '/../models/dieu_kien_tiem_model.php';

class DieuKienTiemController
{
    private $dieu_kien_tiem_model;

    public function __construct($conn)
    {
        $this->dieu_kien_tiem_model = new DieuKienTiemModel($conn);
    }

    public function getAllDieuKienTiem()
    {
        return $this->dieu_kien_tiem_model->getAllDieuKienTiem();
    }

    public function getDieuKienTiemById($id)
    {
        return $this->dieu_kien_tiem_model->getDieuKienTiemById($id);
    }

    public function addDieuKienTiem($ten_dieu_kien, $mo_ta_dieu_kien)
    {
        return $this->dieu_kien_tiem_model->addDieuKienTiem($ten_dieu_kien, $mo_ta_dieu_kien);
    }

    public function updateDieuKienTiem($id, $ten_dieu_kien, $mo_ta_dieu_kien)
    {
        return $this->dieu_kien_tiem_model->updateDieuKienTiem($id, $ten_dieu_kien, $mo_ta_dieu_kien);
    }

    public function deleteDieuKienTiem($id)
    {
        return $this->dieu_kien_tiem_model->deleteDieuKienTiem($id);
    }
}