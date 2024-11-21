<?php
require_once __DIR__ . '/../config/mysql_connection.php';
require_once __DIR__ . '/../models/phac_do_tiem_model.php';

class PhacDoTiemController
{
    private $phac_do_tiem_model;

    public function __construct($conn)
    {
        $this->phac_do_tiem_model = new PhacDoTiemModel($conn);
    }

    public function getAllPhacDoTiem()
    {
        return $this->phac_do_tiem_model->getAllPhacDoTiem();
    }

    public function getPhacDoTiemById($id)
    {
        return $this->phac_do_tiem_model->getPhacDoTiemById($id);
    }

    public function getAllLuaTuoi()
    {
        return $this->phac_do_tiem_model->getAllLuaTuoi();
    }

    public function getAllLieuLuong()
    {
        return $this->phac_do_tiem_model->getAllLieuLuong();
    }

    public function addPhacDoTiem($ten_phac_do, $lua_tuoi_id, $lieu_luong_id, $lich_tiem, $lieu_nhac, $ghi_chu)
    {
        return $this->phac_do_tiem_model->addPhacDoTiem($ten_phac_do, $lua_tuoi_id, $lieu_luong_id, $lich_tiem, $lieu_nhac, $ghi_chu);
    }

    public function updatePhacDoTiem($id, $ten_phac_do, $lua_tuoi_id, $lieu_luong_id, $lich_tiem, $lieu_nhac, $ghi_chu)
    {
        return $this->phac_do_tiem_model->updatePhacDoTiem($id, $ten_phac_do, $lua_tuoi_id, $lieu_luong_id, $lich_tiem, $lieu_nhac, $ghi_chu);
    }

    public function deletePhacDoTiem($id)
    {
        return $this->phac_do_tiem_model->deletePhacDoTiem($id);
    }
}