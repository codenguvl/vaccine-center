<?php
require_once 'controllers/vaccine_controller.php';
require_once 'models/phac_do_tiem_model.php'; // Thêm mô hình phác đồ tiêm
require_once 'models/lua_tuoi_model.php'; // Thêm mô hình lứa tuổi
require_once 'models/dieu_kien_tiem_model.php'; // Thêm mô hình điều kiện tiêm
require_once 'models/benh_model.php'; // Thêm mô hình bệnh
require_once 'models/danh_muc_benh_model.php'; // Thêm mô hình danh mục bệnh
require_once 'models/doi_tuong_tiem_chung_model.php'; // Thêm mô hình danh mục bệnh

$vaccine_controller = new VaccineController($conn);
$phac_do_model = new PhacDoTiemModel($conn);
$lua_tuoi_model = new LuaTuoiModel($conn);
$benh_model = new BenhModel($conn);
$danh_muc_benh_model = new DanhMucBenhModel($conn);
$doi_tuong_model = new DoiTuongTiemChungModel($conn);

if (isset($_GET['id'])) {
    $vaccine_id = $_GET['id'];
    $vaccine = $vaccine_controller->getVaccineById($vaccine_id);

    // Truy vấn thêm dữ liệu
    $phac_do_tiem = $phac_do_model->getAllPhacDoTiem();
    $lua_tuoi = $lua_tuoi_model->getAllLuaTuoi();
    $benh = $benh_model->getAllBenh();
    $danh_muc_benh = $danh_muc_benh_model->getAllDanhMucBenh();

    $benh = $benh_model->getBenhById($vaccine['benh_id']);
    $doi_tuong = $doi_tuong_model->getDoiTuongById($vaccine['doi_tuong_id']);
    $phac_do = $phac_do_model->getPhacDoTiemById($vaccine['phac_do_id']);
    $lua_tuoi = $lua_tuoi_model->getLuaTuoiById($phac_do['lua_tuoi_id']);
} else {
    header('Location: index.php?page=vaccine-list');
    exit;
}
?>

<h2>Thông tin chi tiết vaccine</h2>
<table class="uk-table">
    <tr>
        <th>Tên vaccine</th>
        <td><?php echo htmlspecialchars($vaccine['ten_vaccine']); ?></td>
    </tr>
    <tr>
        <th>Nhà SX</th>
        <td><?php echo htmlspecialchars($vaccine['nha_san_xuat']); ?></td>
    </tr>
    <tr>
        <th>Loại</th>
        <td><?php echo ($vaccine['loai_vaccine'] == 'tiem_mot_lan') ? 'Tiêm một lần' : 'Tiêm nhắc lại'; ?></td>
    </tr>
    <tr>
        <th>Số lô</th>
        <td><?php echo htmlspecialchars($vaccine['so_lo_san_xuat']); ?></td>
    </tr>
    <tr>
        <th>NSX</th>
        <td><?php echo htmlspecialchars($vaccine['ngay_san_xuat']); ?></td>
    </tr>
    <tr>
        <th>HSD</th>
        <td><?php echo htmlspecialchars($vaccine['han_su_dung']); ?></td>
    </tr>
    <tr>
        <th>Giá tiền</th>
        <td><?php echo number_format($vaccine['gia_tien'], 0, ',', '.'); ?> đ</td>
    </tr>
    <tr>
        <th>Số lượng</th>
        <td><?php echo htmlspecialchars($vaccine['so_luong']); ?></td>
    </tr>
    <tr>
        <th>Bệnh</th>
        <td><?php echo htmlspecialchars($benh['ten_benh']); ?></td> <!-- Cập nhật để lấy tên bệnh -->
    </tr>
    <tr>
        <th>Đối tượng</th>
        <td><?php echo htmlspecialchars($doi_tuong['ten_doi_tuong']); ?></td> <!-- Cập nhật để lấy tên đối tượng -->
    </tr>
    <tr>
        <th>Phác đồ tiêm</th>
        <td>
            <ul>
                <li><?php echo $phac_do['ghi_chu']; ?></li> <!-- Cập nhật để lấy tên phác đồ và hiển thị HTML -->
            </ul>
        </td>
    </tr>
    <tr>
        <th>Lứa tuổi</th>
        <td>
            <ul>
                <li><?php echo $lua_tuoi['mo_ta']; ?></li> <!-- Cập nhật để lấy mô tả lứa tuổi và hiển thị HTML -->
            </ul>
        </td>
    </tr>

</table>