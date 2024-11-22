<?php
require_once __DIR__ . '/../config/mysql_connection.php';
require_once __DIR__ . '/../models/chuc_nang_model.php';

class ChucNangController
{
    private $chuc_nang_model;

    public function __construct($conn)
    {
        $this->chuc_nang_model = new ChucNangModel($conn);
    }

    public function getAllChucNang()
    {
        return $this->chuc_nang_model->getAllChucNang();
    }

    public function getChucNangById($id)
    {
        return $this->chuc_nang_model->getChucNangById($id);
    }

    public function addChucNang($ten_chuc_nang, $mo_ta, $duong_dan)
    {
        return $this->chuc_nang_model->addChucNang($ten_chuc_nang, $mo_ta, $duong_dan);
    }

    public function updateChucNang($id, $ten_chuc_nang, $mo_ta, $duong_dan)
    {
        return $this->chuc_nang_model->updateChucNang($id, $ten_chuc_nang, $mo_ta, $duong_dan);
    }

    public function deleteChucNang($id)
    {
        return $this->chuc_nang_model->deleteChucNang($id);
    }
}