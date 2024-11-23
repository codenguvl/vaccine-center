<?php
require_once __DIR__ . '/../config/mysql_connection.php';
require_once __DIR__ . '/../models/lieu_luong_tiem_model.php';

class LieuLuongTiemController
{
    private $lieu_luong_tiem_model;

    public function __construct($conn)
    {
        $this->lieu_luong_tiem_model = new LieuLuongTiemModel($conn);
    }

    public function getAllLieuLuongTiem()
    {
        return $this->lieu_luong_tiem_model->getAllLieuLuongTiem();
    }

    public function getLieuLuongTiemById($id)
    {
        return $this->lieu_luong_tiem_model->getLieuLuongTiemById($id);
    }

    public function addLieuLuongTiem($mo_ta)
    {
        return $this->lieu_luong_tiem_model->addLieuLuongTiem($mo_ta);
    }

    public function updateLieuLuongTiem($id, $mo_ta)
    {
        return $this->lieu_luong_tiem_model->updateLieuLuongTiem($id, $mo_ta);
    }

    public function deleteLieuLuongTiem($id)
    {
        return $this->lieu_luong_tiem_model->deleteLieuLuongTiem($id);
    }

}
?>