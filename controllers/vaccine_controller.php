<?php
require_once __DIR__ . '/../config/mysql_connection.php';
require_once __DIR__ . '/../models/vaccine_model.php';

class VaccineController
{
    private $vaccine_model;

    public function __construct($conn)
    {
        $this->vaccine_model = new VaccineModel($conn);
    }

    public function getAllVaccine()
    {
        return $this->vaccine_model->getAllVaccine();
    }

    public function getVaccineById($id)
    {
        return $this->vaccine_model->getVaccineById($id);
    }

    public function addVaccine($data)
    {
        return $this->vaccine_model->addVaccine($data);
    }

    public function updateVaccine($id, $data)
    {
        return $this->vaccine_model->updateVaccine($id, $data);
    }

    public function deleteVaccine($id)
    {
        return $this->vaccine_model->deleteVaccine($id);
    }

    public function validateData($data)
    {
        $errors = [];

        // Validate required fields
        $required_fields = [
            'ten_vaccine',
            'nha_san_xuat',
            'loai_vaccine',
            'so_lo_san_xuat',
            'ngay_san_xuat',
            'han_su_dung',
            'ngay_nhap',
            'gia_tien',
            'so_luong'
        ];
        foreach ($required_fields as $field) {
            if (empty($data[$field])) {
                $errors[] = "Trường " . str_replace('_', ' ', $field) . " là bắt buộc";
            }
        }

        // Validate dates
        if (!empty($data['ngay_san_xuat']) && !empty($data['han_su_dung'])) {
            if (strtotime($data['han_su_dung']) <= strtotime($data['ngay_san_xuat'])) {
                $errors[] = "Hạn sử dụng phải sau ngày sản xuất";
            }
        }

        // Validate numeric values
        if (!empty($data['gia_tien']) && !is_numeric($data['gia_tien'])) {
            $errors[] = "Giá tiền phải là số";
        }
        if (!empty($data['so_luong']) && !is_numeric($data['so_luong'])) {
            $errors[] = "Số lượng phải là số";
        }

        return $errors;
    }
}