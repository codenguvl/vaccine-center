<?php
require_once __DIR__ . '/../config/mysql_connection.php';
require_once __DIR__ . '/../models/vai_tro_model.php';
require_once __DIR__ . '/../models/chuc_nang_model.php';

class VaiTroController
{
    private $vai_tro_model;
    private $chucNangModel;

    public function __construct($conn)
    {
        $this->vai_tro_model = new VaiTroModel($conn);
        $this->chuc_nang_model = new ChucNangModel($conn);
    }

    public function getAllVaiTro()
    {
        return $this->vai_tro_model->getAllVaiTro();
    }

    public function getVaiTroById($id)
    {
        $vai_tro = $this->vai_tro_model->getVaiTroById($id);
        if (!$vai_tro) {
            error_log("VaiTroController: Vai tro not found for id: " . $id);
        }
        return $vai_tro;
    }



    public function addVaiTro($ten_vai_tro, $mo_ta, $chuc_nang_ids)
    {
        return $this->vai_tro_model->createVaiTro($ten_vai_tro, $mo_ta, $chuc_nang_ids);
    }

    public function updateVaiTro($id, $ten_vai_tro, $mo_ta, $chuc_nang_ids)
    {
        $result = $this->vai_tro_model->updateVaiTro($id, $ten_vai_tro, $mo_ta, $chuc_nang_ids);
        if (!$result) {
            error_log("Failed to update vai_tro with id: " . $id);
        }
        return $result;
    }


    public function getAllChucNang()
    {
        return $this->chuc_nang_model->getAllChucNang();
    }

    public function getChucNangForVaiTro($vai_tro_id)
    {
        return $this->vai_tro_model->getChucNangForVaiTro($vai_tro_id);
    }

    public function deleteVaiTro($id)
    {
        $result = $this->vai_tro_model->deleteVaiTro($id);
        return $result;
    }
}