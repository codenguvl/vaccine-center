<?php
require_once __DIR__ . '/../config/mysql_connection.php';
require_once __DIR__ . '/../models/danh_muc_benh_model.php';

class DanhMucBenhController
{
    private $danh_muc_benh_model;

    public function __construct($conn)
    {
        $this->danh_muc_benh_model = new DanhMucBenhModel($conn);
    }

    public function getAllDanhMucBenh()
    {
        return $this->danh_muc_benh_model->getAllDanhMucBenh();
    }

    public function getDanhMucBenhById($id)
    {
        return $this->danh_muc_benh_model->getDanhMucBenhById($id);
    }

    public function addDanhMucBenh($ten_danh_muc)
    {
        return $this->danh_muc_benh_model->addDanhMucBenh($ten_danh_muc);
    }

    public function updateDanhMucBenh($id, $ten_danh_muc)
    {
        return $this->danh_muc_benh_model->updateDanhMucBenh($id, $ten_danh_muc);
    }

    public function deleteDanhMucBenh($id)
    {
        return $this->danh_muc_benh_model->deleteDanhMucBenh($id);
    }
}