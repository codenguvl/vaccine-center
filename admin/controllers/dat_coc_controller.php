<?php
require_once __DIR__ . '/../models/dat_coc_model.php';

class DatCocController
{
    private $dat_coc_model;

    public function __construct($conn)
    {
        $this->dat_coc_model = new DatCocModel($conn);
    }

    public function addDatCoc($vaccine_id, $phan_tram_dat_coc, $so_tien_dat_coc, $ngay_dat_coc, $trang_thai, $ghi_chu)
    {
        return $this->dat_coc_model->addDatCoc($vaccine_id, $phan_tram_dat_coc, $so_tien_dat_coc, $ngay_dat_coc, $trang_thai, $ghi_chu);
    }

    public function getDatCocById($id)
    {
        return $this->dat_coc_model->getDatCocById($id);
    }

    public function updateDatCoc($id, $trang_thai, $ghi_chu)
    {
        return $this->dat_coc_model->updateDatCoc($id, $trang_thai, $ghi_chu);
    }
}