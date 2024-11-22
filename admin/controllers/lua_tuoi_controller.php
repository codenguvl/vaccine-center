<?php
require_once __DIR__ . '/../config/mysql_connection.php';
require_once __DIR__ . '/../models/lua_tuoi_model.php';

class LuaTuoiController
{
    private $lua_tuoi_model;

    public function __construct($conn)
    {
        $this->lua_tuoi_model = new LuaTuoiModel($conn);
    }

    public function getAllLuaTuoi()
    {
        return $this->lua_tuoi_model->getAllLuaTuoi();
    }

    public function getLuaTuoiById($id)
    {
        return $this->lua_tuoi_model->getLuaTuoiById($id);
    }

    public function addLuaTuoi($ten_lua_tuoi, $mo_ta)
    {
        return $this->lua_tuoi_model->addLuaTuoi($ten_lua_tuoi, $mo_ta);
    }
    public function updateLuaTuoi($id, $ten_lua_tuoi, $mo_ta)
    {
        return $this->lua_tuoi_model->updateLuaTuoi($id, $ten_lua_tuoi, $mo_ta);
    }

    public function deleteLuaTuoi($id)
    {
        return $this->lua_tuoi_model->deleteLuaTuoi($id);
    }
}
?>