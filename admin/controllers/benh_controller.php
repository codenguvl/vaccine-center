<?php
require_once __DIR__ . '/../config/mysql_connection.php';
require_once __DIR__ . '/../models/benh_model.php';

class BenhController
{
    private $benh_model;

    public function __construct($conn)
    {
        $this->benh_model = new BenhModel($conn);
    }

    public function getAllBenh()
    {
        return $this->benh_model->getAllBenh();
    }

    public function getBenhById($id)
    {
        return $this->benh_model->getBenhById($id);
    }

    public function addBenh($ten_benh, $danh_muc_id)
    {
        return $this->benh_model->addBenh($ten_benh, $danh_muc_id);
    }

    public function updateBenh($id, $ten_benh, $danh_muc_id)
    {
        return $this->benh_model->updateBenh($id, $ten_benh, $danh_muc_id);
    }

    public function deleteBenh($id)
    {
        return $this->benh_model->deleteBenh($id);
    }
}