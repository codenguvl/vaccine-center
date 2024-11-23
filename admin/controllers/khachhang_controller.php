<?php
require_once __DIR__ . '/../config/mysql_connection.php';
require_once __DIR__ . '/../models/khachhang_model.php';

class KhachHangController
{
    private $khachhang_model;

    public function __construct($conn)
    {
        $this->khachhang_model = new KhachHangModel($conn);
    }

    public function getAllKhachHang()
    {
        return $this->khachhang_model->getAllKhachHang();
    }

    public function getKhachHangById($id)
    {
        return $this->khachhang_model->getKhachHangById($id);
    }

    public function addKhachHang($fullname, $cccd, $ngaysinh, $gioitinh, $dienthoai, $diachi, $tinh_thanh, $huyen, $xa_phuong, $email)
    {
        return $this->khachhang_model->addKhachHang($fullname, $cccd, $ngaysinh, $gioitinh, $dienthoai, $diachi, $tinh_thanh, $huyen, $xa_phuong, $email);
    }

    public function updateKhachHang($id, $fullname, $cccd, $ngaysinh, $gioitinh, $dienthoai, $diachi, $tinh_thanh, $huyen, $xa_phuong, $email)
    {
        return $this->khachhang_model->updateKhachHang($id, $fullname, $cccd, $ngaysinh, $gioitinh, $dienthoai, $diachi, $tinh_thanh, $huyen, $xa_phuong, $email);
    }

    public function deleteKhachHang($id)
    {
        return $this->khachhang_model->deleteKhachHang($id);
    }

    public function getNguoiThanByKhachHangId($khachhang_id)
    {
        return $this->khachhang_model->getNguoiThanByKhachHangId($khachhang_id);
    }

    public function addNguoiThan($khachhang_id, $fullname, $quanhe, $dienthoai, $diachi, $tinh_thanh, $huyen, $xa_phuong)
    {
        return $this->khachhang_model->addNguoiThan($khachhang_id, $fullname, $quanhe, $dienthoai, $diachi, $tinh_thanh, $huyen, $xa_phuong);
    }

    public function updateNguoiThan($nguoithan_id, $fullname, $quanhe, $dienthoai, $diachi, $tinh_thanh, $huyen, $xa_phuong)
    {
        return $this->khachhang_model->updateNguoiThan($nguoithan_id, $fullname, $quanhe, $dienthoai, $diachi, $tinh_thanh, $huyen, $xa_phuong);
    }

    public function deleteNguoiThan($nguoithan_id)
    {
        return $this->khachhang_model->deleteNguoiThan($nguoithan_id);
    }


    public function addKhachHangWithRelative($fullname, $cccd, $ngaysinh, $gioitinh, $dienthoai, $diachi, $tinh_thanh, $huyen, $xa_phuong, $relative_fullname, $relative_quanhe, $relative_dienthoai, $relative_diachi, $relative_tinh_thanh, $relative_huyen, $relative_xa_phuong, $email)
    {
        $result = $this->khachhang_model->addKhachHangWithRelative($fullname, $cccd, $ngaysinh, $gioitinh, $dienthoai, $diachi, $tinh_thanh, $huyen, $xa_phuong, $relative_fullname, $relative_quanhe, $relative_dienthoai, $relative_diachi, $relative_tinh_thanh, $relative_huyen, $relative_xa_phuong, $email); // Cập nhật thêm email

        if (is_array($result)) {
            return [
                'status' => 'error',
                'existing' => $result
            ];
        }

        return [
            'status' => $result ? 'success' : 'error',
            'existing' => []
        ];
    }


    public function updateKhachHangWithRelative($id, $fullname, $cccd, $ngaysinh, $gioitinh, $dienthoai, $diachi, $tinh_thanh, $huyen, $xa_phuong, $relative_fullname, $relative_quanhe, $relative_dienthoai, $relative_diachi, $relative_tinh_thanh, $relative_huyen, $relative_xa_phuong, $email)
    {
        return $this->khachhang_model->updateKhachHangWithRelative($id, $fullname, $cccd, $ngaysinh, $gioitinh, $dienthoai, $diachi, $tinh_thanh, $huyen, $xa_phuong, $relative_fullname, $relative_quanhe, $relative_dienthoai, $relative_diachi, $relative_tinh_thanh, $relative_huyen, $relative_xa_phuong, $email); // Cập nhật thêm email
    }
    public function searchKhachHang($search_term)
    {
        return $this->khachhang_model->searchKhachHang($search_term);
    }
    public function sendReminderEmail($email, $message)
    {
        return $this->khachhang_model->sendReminderEmail($email, $message);
    }
    public function checkKhachHangExists($phoneOrCCCD)
    {
        return $this->khachhang_model->checkKhachHangExists($phoneOrCCCD);
    }

    public function getKhachHangByPhoneOrCCCD($phoneOrCCCD)
    {
        return $this->khachhang_model->getKhachHangByPhoneOrCCCD($phoneOrCCCD);
    }

}