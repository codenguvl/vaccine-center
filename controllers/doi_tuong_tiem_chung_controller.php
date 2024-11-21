<?php
require_once __DIR__ . '/../config/mysql_connection.php';
require_once __DIR__ . '/../models/doi_tuong_tiem_chung_model.php';

class DoiTuongTiemChungController
{
    private $doi_tuong_model;

    public function __construct($conn)
    {
        $this->doi_tuong_model = new DoiTuongTiemChungModel($conn);
    }

    public function getAllDoiTuong()
    {
        return $this->doi_tuong_model->getAllDoiTuong();
    }

    public function getDoiTuongById($id)
    {
        return $this->doi_tuong_model->getDoiTuongById($id);
    }

    public function addDoiTuong($ten_doi_tuong)
    {
        return $this->doi_tuong_model->addDoiTuong($ten_doi_tuong);
    }

    public function updateDoiTuong($id, $ten_doi_tuong)
    {
        return $this->doi_tuong_model->updateDoiTuong($id, $ten_doi_tuong);
    }

    public function deleteDoiTuong($id)
    {
        return $this->doi_tuong_model->deleteDoiTuong($id);
    }
}