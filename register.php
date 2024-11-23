<?php
ob_start();
require_once __DIR__ . '/admin/config/mysql_connection.php';
require_once __DIR__ . '/admin/controllers/dang_ky_tiem_tai_nha_controller.php';

$dangKyController = new DangKyTiemTaiNhaController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ho_ten = $_POST['name'];
    $ngay_sinh = $_POST['dob'];
    $gioi_tinh = $_POST['gender'];
    $tinh_thanh = $_POST['province'];
    $quan_huyen = $_POST['district'];
    $phuong_xa = $_POST['ward'];
    $dia_chi = $_POST['address'];
    $ho_ten_lien_he = $_POST['contact_name'];
    $quan_he = $_POST['relation'];
    $dien_thoai_lien_he = $_POST['contact_phone'];
    $ngay_mong_muon = $_POST['preferred_date'];

    $result = $dangKyController->addDangKy($ho_ten, $ngay_sinh, $gioi_tinh, $tinh_thanh, $quan_huyen, $phuong_xa, $dia_chi, $ho_ten_lien_he, $quan_he, $dien_thoai_lien_he, $ngay_mong_muon);

    if ($result) {
        $success_message = "Đăng ký thành công!";
    } else {
        $error_message = "Đăng ký không thành công. Vui lòng thử lại.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Đăng Ký Lịch Tiêm</title>

    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/css/uikit.min.css" />

    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/js/uikit-icons.min.js"></script>

    <!-- Font icon -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <!-- Notification -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- Google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Mona+Sans:ital,wght@0,200..900;1,200..900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <!-- Import css -->
    <link rel="stylesheet" href="./static/css/reset.css">
    <link rel="stylesheet" href="./static/css/main.css">

    <!-- Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>

    <?php include('includes/partials/header.php') ?>

    <div class="uk-container">
        <form action="" method="POST"
            class="uk-margin-bottom uk-card uk-card-body uk-card-default uk-width-2xlarge uk-margin-auto-left uk-margin-auto-right uk-margin-top">
            <!-- Thông tin người tiêm -->
            <?php if (isset($success_message)): ?>
            <div class="uk-alert-success" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p><?php echo $success_message; ?></p>
            </div>
            <?php endif; ?>

            <?php if (isset($error_message)): ?>
            <div class="uk-alert-danger" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p><?php echo $error_message; ?></p>
            </div>
            <?php endif; ?>
            <fieldset class="uk-fieldset">
                <legend class="uk-heading-small uk-text-center">ĐĂNG KÝ & ĐẶT LỊCH TIÊM CHỦNG NGAY</legend>
                <p class="uk-text-center uk-text-primary">Mời Quý khách đăng ký thông tin tiêm chủng để tiết kiệm thời
                    gian khi đến
                    trung tâm làm thủ tục và
                    hưởng thêm nhiều chính sách ưu đãi khác.</p>
                <div class="uk-margin">
                    <label for="name" class="uk-form-label">Họ và Tên</label>
                    <input class="uk-input" type="text" id="name" name="name" placeholder="Họ và Tên" required>
                </div>
                <div class="uk-margin">
                    <label for="dob" class="uk-form-label">Ngày Sinh</label>
                    <input class="uk-input" type="date" id="dob" name="dob" required>
                </div>
                <div class="uk-margin">
                    <label for="gender" class="uk-form-label">Giới Tính</label>
                    <select class="uk-select" id="gender" name="gender" required>
                        <option value="">Chọn Giới Tính</option>
                        <option value="nam">Nam</option>
                        <option value="nu">Nữ</option>
                        <option value="khac">Khác</option>
                    </select>
                </div>

                <div class="uk-margin">
                    <label for="province" class="uk-form-label">Tỉnh Thành</label>
                    <select class="uk-select" id="province" name="province" required>
                        <option value="">Chọn Tỉnh Thành</option>
                        <!-- Các lựa chọn tỉnh thành sẽ được thêm vào ở đây -->
                    </select>
                </div>
                <div class="uk-margin">
                    <label for="district" class="uk-form-label">Quận Huyện</label>
                    <select class="uk-select" id="district" name="district" required disabled>
                        <option value="">Chọn Quận Huyện</option>
                    </select>
                </div>
                <div class="uk-margin">
                    <label for="ward" class="uk-form-label">Phường Xã</label>
                    <select class="uk-select" id="ward" name="ward" required disabled>
                        <option value="">Chọn Phường Xã</option>
                    </select>
                </div>
                <div class="uk-margin">
                    <label for="address" class="uk-form-label">Số Nhà, Tên Đường</label>
                    <input class="uk-input" type="text" id="address" name="address" placeholder="Số nhà, tên đường"
                        required>
                </div>
            </fieldset>

            <!-- Thông tin người liên hệ -->
            <fieldset class="uk-fieldset">
                <legend class="uk-legend">Thông Tin Người Liên Hệ</legend>
                <div class="uk-margin">
                    <label for="contact_name" class="uk-form-label">Họ và Tên Người Liên Hệ</label>
                    <input class="uk-input" type="text" id="contact_name" name="contact_name"
                        placeholder="Họ và Tên Người Liên Hệ" required>
                </div>
                <div class="uk-margin">
                    <label for="relation" class="uk-form-label">Mối Quan Hệ Với Người Tiêm</label>
                    <select class="uk-select" id="relation" name="relation" required>
                        <option value="">Chọn Mối Quan Hệ</option>
                        <option value="vo">Vợ</option>
                        <option value="chong">Chồng</option>
                        <option value="con">Con</option>
                        <option value="bo">Bố</option>
                        <option value="me">Mẹ</option>
                        <option value="ong">Ông</option>
                        <option value="ba">Bà</option>
                        <option value="khac">Khác</option>
                    </select>
                </div>
                <div class="uk-margin">
                    <label for="contact_phone" class="uk-form-label">Số Điện Thoại Người Liên Hệ</label>
                    <input class="uk-input" type="text" id="contact_phone" name="contact_phone"
                        placeholder="Số Điện Thoại" required>
                </div>
            </fieldset>

            <!-- Thông tin dịch vụ -->
            <fieldset class="uk-fieldset">
                <legend class="uk-legend">Thông Tin Dịch Vụ</legend>
                <div class="uk-margin">
                    <label for="preferred_date" class="uk-form-label">Ngày Mong Muốn Tiêm</label>
                    <input class="uk-input" type="date" id="preferred_date" name="preferred_date" required>
                </div>
            </fieldset>

            <!-- Submit button -->
            <button class="uk-button uk-button-primary uk-align-center uk-width-1-1" type="submit">Đăng Ký Lịch
                Tiêm</button>
        </form>
    </div>
    <!-- Footer -->
    <?php include('includes/partials/footer.php') ?>

</body>
<script>
const provinceSelect = document.getElementById('province');
const districtSelect = document.getElementById('district');
const wardSelect = document.getElementById('ward');

// API URLs
const API_BASE = 'https://open.oapi.vn/location';
const PROVINCE_API = `${API_BASE}/provinces?page=0&size=30`;
const DISTRICT_API = `${API_BASE}/districts`;
const WARD_API = `${API_BASE}/wards`;

// Fetch provinces
async function fetchProvinces() {
    const response = await fetch(PROVINCE_API);
    const data = await response.json();
    if (data && data.code === 'success') {
        populateSelect(provinceSelect, data.data, "Chọn Tỉnh Thành");
    }
}

// Fetch districts based on provinceId
async function fetchDistricts(provinceId) {
    const response = await fetch(`${DISTRICT_API}/${provinceId}?page=0&size=30`);
    const data = await response.json();
    if (data && data.code === 'success') {
        populateSelect(districtSelect, data.data, "Chọn Quận Huyện");
    }
}

// Fetch wards based on districtId
async function fetchWards(districtId) {
    const response = await fetch(`${WARD_API}/${districtId}?page=0&size=30`);
    const data = await response.json();
    if (data && data.code === 'success') {
        populateSelect(wardSelect, data.data, "Chọn Phường Xã");
    }
}

// Populate a select element with options
function populateSelect(selectElement, data, placeholder) {
    selectElement.innerHTML = `<option value="">${placeholder}</option>`;
    data.forEach(item => {
        const option = document.createElement('option');
        option.value = item.id;
        option.textContent = item.name;
        selectElement.appendChild(option);
    });
    selectElement.disabled = false;
}

// Event listeners
provinceSelect.addEventListener('change', () => {
    const provinceId = provinceSelect.value;
    districtSelect.disabled = true;
    wardSelect.disabled = true;
    if (provinceId) {
        fetchDistricts(provinceId);
    }
});

districtSelect.addEventListener('change', () => {
    const districtId = districtSelect.value;
    wardSelect.disabled = true;
    if (districtId) {
        fetchWards(districtId);
    }
});

// Initialize provinces on page load
fetchProvinces();
</script>

</html>