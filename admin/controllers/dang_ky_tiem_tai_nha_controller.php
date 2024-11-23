<?php
require_once __DIR__ . '/../config/mysql_connection.php';
require_once __DIR__ . '/../models/dang_ky_tiem_tai_nha_model.php';

class DangKyTiemTaiNhaController
{
    private $dang_ky_model;

    public function __construct($conn)
    {
        $this->dang_ky_model = new DangKyTiemTaiNhaModel($conn);
    }

    public function getAllDangKy()
    {
        return $this->dang_ky_model->getAllDangKy();
    }

    public function getDangKyById($id)
    {
        return $this->dang_ky_model->getDangKyById($id);
    }

    public function addDangKy($ho_ten, $ngay_sinh, $gioi_tinh, $tinh_thanh, $quan_huyen, $phuong_xa, $dia_chi, $ho_ten_lien_he, $quan_he, $dien_thoai_lien_he, $ngay_mong_muon)
    {
        return $this->dang_ky_model->addDangKy($ho_ten, $ngay_sinh, $gioi_tinh, $tinh_thanh, $quan_huyen, $phuong_xa, $dia_chi, $ho_ten_lien_he, $quan_he, $dien_thoai_lien_he, $ngay_mong_muon);
    }

    public function updateDangKy($dang_ky_id, $ho_ten, $ngay_sinh, $gioi_tinh, $tinh_thanh, $quan_huyen, $phuong_xa, $dia_chi, $ho_ten_lien_he, $quan_he, $dien_thoai_lien_he, $ngay_mong_muon)
    {
        return $this->dang_ky_model->updateDangKy($dang_ky_id, $ho_ten, $ngay_sinh, $gioi_tinh, $tinh_thanh, $quan_huyen, $phuong_xa, $dia_chi, $ho_ten_lien_he, $quan_he, $dien_thoai_lien_he, $ngay_mong_muon);
    }

    public function deleteDangKy($dang_ky_id)
    {
        return $this->dang_ky_model->deleteDangKy($dang_ky_id);
    }

    public function updateStatus($dang_ky_id, $new_status) // Thêm phương thức cập nhật trạng thái
    {
        return $this->dang_ky_model->updateStatus($dang_ky_id, $new_status);
    }
}