<?php
require_once 'controllers/dang_ky_tiem_tai_nha_controller.php';
$controller = new DangKyTiemTaiNhaController($conn);

$dang_ky_id = $_GET['id'];
$dang_ky_info = $controller->getDangKyById($dang_ky_id);

// Lấy thông tin tỉnh, huyện, xã
$provinceId = $dang_ky_info['tinh_thanh'];
$districtId = $dang_ky_info['quan_huyen'];
$wardId = $dang_ky_info['phuong_xa'];

// Hàm lấy danh sách toàn bộ từ API
function getDataFromApi($url)
{
    $response = file_get_contents($url);
    return json_decode($response, true)['data'] ?? [];
}

// Lấy toàn bộ danh sách tỉnh
$provinces = getDataFromApi("https://open.oapi.vn/location/provinces?page=0&size=100");
$provinceName = '';
foreach ($provinces as $province) {
    if ($province['id'] == $provinceId) {
        $provinceName = $province['name'];
        break;
    }
}

// Lấy toàn bộ danh sách huyện trong tỉnh
$districts = getDataFromApi("https://open.oapi.vn/location/districts/{$provinceId}?page=0&size=100");
$districtName = '';
foreach ($districts as $district) {
    if ($district['id'] == $districtId) {
        $districtName = $district['name'];
        break;
    }
}

// Lấy toàn bộ danh sách xã trong huyện
$wards = getDataFromApi("https://open.oapi.vn/location/wards/{$districtId}?page=0&size=100");
$wardName = '';
foreach ($wards as $ward) {
    if ($ward['id'] == $wardId) {
        $wardName = $ward['name'];
        break;
    }
}

$statusMap = [
    'cho_xu_ly' => 'Chờ xử lý',
    'da_xu_ly' => 'Đã xử lý',
    'huy' => 'Hủy'
];

// Lấy giá trị trạng thái từ cơ sở dữ liệu
$status = $dang_ky_info['trang_thai'];

// Kiểm tra nếu trạng thái tồn tại trong mảng ánh xạ, nếu không giữ nguyên giá trị gốc
$translatedStatus = isset($statusMap[$status]) ? $statusMap[$status] : $status;
?>
<div class="uk-container">
    <div class="uk-card uk-card-default uk-card-body uk-width-1-1@m uk-margin-auto">
        <div class="uk-child-width-1-3@m uk-grid-match uk-grid-divider" uk-grid>
            <div>
                <div class="info-item">
                    <span class="info-title">Họ tên</span>
                    <p class="info-content"><?php echo htmlspecialchars($dang_ky_info['ho_ten']); ?></p>
                </div>
            </div>
            <div>
                <div class="info-item">
                    <span class="info-title">Ngày sinh</span>
                    <p class="info-content"><?php echo htmlspecialchars($dang_ky_info['ngay_sinh']); ?></p>
                </div>
            </div>
            <div>
                <div class="info-item">
                    <span class="info-title">Giới tính</span>
                    <p class="info-content"><?php echo htmlspecialchars($dang_ky_info['gioi_tinh']); ?></p>
                </div>
            </div>
            <div>
                <div class="info-item">
                    <span class="info-title">Địa chỉ</span>
                    <p class="info-content">
                        <?php echo htmlspecialchars($dang_ky_info['dia_chi'] . ', ' . $wardName . ', ' . $districtName . ', ' . $provinceName); ?>
                    </p>
                </div>
            </div>
            <div>
                <div class="info-item">
                    <span class="info-title">Họ tên liên hệ</span>
                    <p class="info-content"><?php echo htmlspecialchars($dang_ky_info['ho_ten_lien_he']); ?></p>
                </div>
            </div>
            <div>
                <div class="info-item">
                    <span class="info-title">Quan hệ</span>
                    <p class="info-content"><?php echo htmlspecialchars($dang_ky_info['quan_he']); ?></p>
                </div>
            </div>
            <div>
                <div class="info-item">
                    <span class="info-title">Số điện thoại liên hệ</span>
                    <p class="info-content"><?php echo htmlspecialchars($dang_ky_info['dien_thoai_lien_he']); ?></p>
                </div>
            </div>
            <div>
                <div class="info-item">
                    <span class="info-title">Ngày mong muốn</span>
                    <p class="info-content"><?php echo htmlspecialchars($dang_ky_info['ngay_mong_muon']); ?></p>
                </div>
            </div>
            <div>
                <div class="info-item">
                    <span class="info-title">Trạng thái</span>
                    <p class="info-content"><?php echo htmlspecialchars($translatedStatus); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.info-item {
    margin-bottom: 15px;
}

.info-title {
    display: block;
    font-weight: bold;
    font-size: 1.1rem;
    color: #333;
    margin-bottom: 5px;
}

.info-content {
    font-size: 1rem;
    color: #555;
}
</style>