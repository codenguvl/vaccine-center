<?php
require_once 'controllers/khachhang_controller.php';
$khachhang_controller = new KhachHangController($conn);

$id = isset($_GET['id']) ? $_GET['id'] : null;
$khachhang = $khachhang_controller->getKhachHangById($id);

if (!$khachhang) {
    echo "Khách hàng không tồn tại.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!preg_match('/^\d{8,13}$/', $_POST['cccd'])) {
        $status = 'danger';
        $message = 'Số CCCD phải có từ 8 đến 13 chữ số.';
        header("Location: index.php?page=khach-hang-edit&id=" . $id . "&message=" . urlencode($message) . "&status=" . $status);
        exit;
    }
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $message = 'Email không hợp lệ.';
        $status = 'danger';
        header(header: "Location: index.php?page=khach-hang-edit&id=" . $id . "&message=" . urlencode($message) . "&status=" . $status);
        exit;
    }
    if (!preg_match('/^\d{10,15}$/', $_POST['dienthoai'])) {
        $message = 'Số điện thoại không hợp lệ.';
        $status = 'danger';
        header("Location: index.php?page=khach-hang-edit&id=" . $id . "&message=" . urlencode($message) . "&status=" . $status);
        exit;
    }
    $result = $khachhang_controller->updateKhachHangWithRelative(
        $id,
        $_POST['fullname'],
        $_POST['cccd'],
        $_POST['ngaysinh'],
        $_POST['gioitinh'],
        $_POST['dienthoai'],
        $_POST['diachi'],
        $_POST['tinh_thanh'],
        $_POST['huyen'],
        $_POST['xa_phuong'],
        $_POST['relative_fullname'],
        $_POST['relative_quanhe'],
        $_POST['relative_dienthoai'],
        $_POST['relative_diachi'],
        $_POST['relative_tinh_thanh'],
        $_POST['relative_huyen'],
        $_POST['relative_xa_phuong'],
        $_POST['email']
    );
    if ($result) {
        header("Location: index.php?page=khach-hang-list&message=edit_success");
        exit();
    } else {
        $message = 'Có lỗi xảy ra khi cập nhật khách hàng!';
        $status = 'danger';
    }
}
?>
<?php if (isset($message)): ?>
<div class="uk-alert-<?php echo $status; ?>" uk-alert>
    <a class="uk-alert-close" uk-close></a>
    <p><?php echo $message; ?></p>
</div>
<?php endif; ?>

<?php if (!empty($_GET['message'])): ?>
<div class="uk-alert-<?php echo htmlspecialchars($_GET['status']); ?>" uk-alert>
    <a class="uk-alert-close" uk-close></a>
    <p><?php echo htmlspecialchars($_GET['message']); ?></p>
</div>
<?php endif; ?>

<form class="uk-form-stacked" action="index.php?page=khach-hang-edit&id=<?php echo $id; ?>" method="POST">
    <div class="uk-margin">
        <label class="uk-form-label" for="fullname">Họ và tên:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="fullname" name="fullname" type="text"
                value="<?php echo htmlspecialchars($khachhang['fullname']); ?>" required>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="cccd">Số CCCD:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="cccd" name="cccd" type="text"
                value="<?php echo htmlspecialchars($khachhang['cccd']); ?>" required>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="ngaysinh">Ngày sinh:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="ngaysinh" name="ngaysinh" type="date"
                value="<?php echo htmlspecialchars($khachhang['ngaysinh']); ?>" required>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="gioitinh">Giới tính:</label>
        <div class="uk-form-controls">
            <select class="uk-select" id="gioitinh" name="gioitinh" required>
                <option value="nam" <?php echo $khachhang['gioitinh'] == 'nam' ? 'selected' : ''; ?>>Nam</option>
                <option value="nu" <?php echo $khachhang['gioitinh'] == 'nu' ? 'selected' : ''; ?>>Nữ</option>
                <option value="khac" <?php echo $khachhang['gioitinh'] == 'khac' ? 'selected' : ''; ?>>Khác</option>
            </select>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="dienthoai">Điện thoại:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="dienthoai" name="dienthoai" type="tel"
                value="<?php echo htmlspecialchars($khachhang['dienthoai']); ?>">
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="email">Email:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="email" name="email" type="email"
                value="<?php echo htmlspecialchars($khachhang['email']); ?>" required>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="diachi">Địa chỉ:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="diachi" name="diachi" type="text"
                value="<?php echo htmlspecialchars($khachhang['diachi']); ?>">
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="tinh_thanh">Tỉnh/Thành phố:</label>
        <div class="uk-form-controls">
            <select class="uk-select" id="tinh_thanh" name="tinh_thanh" required>
                <option value="">Chọn Tỉnh/Thành phố</option>
            </select>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="huyen">Quận/Huyện:</label>
        <div class="uk-form-controls">
            <select class="uk-select" id="huyen" name="huyen" required disabled>
                <option value="">Chọn Quận/Huyện</option>
            </select>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="xa_phuong">Xã/Phường:</label>
        <div class="uk-form-controls">
            <select class="uk-select" id="xa_phuong" name="xa_phuong" required disabled>
                <option value="">Chọn Xã/Phường</option>
            </select>
        </div>
    </div>
    <!-- After the existing form fields, add this section -->
    <h3 class="uk-heading-divider">Thông tin người thân</h3>
    <?php
    $nguoithan = $khachhang_controller->getNguoiThanByKhachHangId($id);
    $nguoithan = !empty($nguoithan) ? $nguoithan[0] : null; // Assume the first relative or null if not exists
    ?>
    <div class="uk-margin">
        <label class="uk-form-label" for="relative_fullname">Họ và tên người thân:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="relative_fullname" name="relative_fullname" type="text"
                value="<?php echo htmlspecialchars($nguoithan['fullname'] ?? ''); ?>">
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="relative_quanhe">Quan hệ:</label>
        <div class="uk-form-controls">
            <select class="uk-select" id="relative_quanhe" name="relative_quanhe" required>
                <option value="">Chọn quan hệ</option>
                <option value="vo"
                    <?php echo (isset($nguoithan['quanhe']) && $nguoithan['quanhe'] == 'vo') ? 'selected' : ''; ?>>Vợ
                </option>
                <option value="chong"
                    <?php echo (isset($nguoithan['quanhe']) && $nguoithan['quanhe'] == 'chong') ? 'selected' : ''; ?>>
                    Chồng</option>
                <option value="con"
                    <?php echo (isset($nguoithan['quanhe']) && $nguoithan['quanhe'] == 'con') ? 'selected' : ''; ?>>Con
                </option>
                <option value="bo"
                    <?php echo (isset($nguoithan['quanhe']) && $nguoithan['quanhe'] == 'bo') ? 'selected' : ''; ?>>Bố
                </option>
                <option value="me"
                    <?php echo (isset($nguoithan['quanhe']) && $nguoithan['quanhe'] == 'me') ? 'selected' : ''; ?>>Mẹ
                </option>
                <option value="ong"
                    <?php echo (isset($nguoithan['quanhe']) && $nguoithan['quanhe'] == 'ong') ? 'selected' : ''; ?>>Ông
                </option>
                <option value="ba"
                    <?php echo (isset($nguoithan['quanhe']) && $nguoithan['quanhe'] == 'ba') ? 'selected' : ''; ?>>Bà
                </option>
                <option value="khac"
                    <?php echo (isset($nguoithan['quanhe']) && $nguoithan['quanhe'] == 'khac') ? 'selected' : ''; ?>>
                    Khác</option>
            </select>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="relative_dienthoai">Điện thoại người thân:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="relative_dienthoai" name="relative_dienthoai" type="tel"
                value="<?php echo htmlspecialchars($nguoithan['dienthoai'] ?? ''); ?>">
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="relative_diachi">Địa chỉ người thân:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="relative_diachi" name="relative_diachi" type="text"
                value="<?php echo htmlspecialchars($nguoithan['diachi'] ?? ''); ?>">
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="relative_tinh_thanh">Tỉnh/Thành phố người thân:</label>
        <div class="uk-form-controls">
            <select class="uk-select" id="relative_tinh_thanh" name="relative_tinh_thanh">
                <option value="">Chọn Tỉnh/Thành phố</option>
            </select>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="relative_huyen">Quận/Huyện người thân:</label>
        <div class="uk-form-controls">
            <select class="uk-select" id="relative_huyen" name="relative_huyen" disabled>
                <option value="">Chọn Quận/Huyện</option>
            </select>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="relative_xa_phuong">Xã/Phường người thân:</label>
        <div class="uk-form-controls">
            <select class="uk-select" id="relative_xa_phuong" name="relative_xa_phuong" disabled>
                <option value="">Chọn Xã/Phường</option>
            </select>
        </div>
    </div>


    <button class="uk-button uk-button-primary" type="submit">Cập nhật khách hàng</button>
</form>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    function fetchData(url) {
        return $.getJSON(url);
    }

    function populateSelect(selectElement, data, selectedValue) {
        selectElement.empty().append('<option value="">Chọn</option>');
        $.each(data, function(index, item) {
            var option = $('<option></option>').attr('value', item.id).text(item.name);
            if (item.id == selectedValue) {
                option.attr('selected', 'selected');
            }
            selectElement.append(option);
        });
    }

    function setupAddressFields(provinceSelect, districtSelect, wardSelect, defaultProvince, defaultDistrict,
        defaultWard) {
        // Fetch provinces - lấy tất cả tỉnh/thành
        fetchData('https://open.oapi.vn/location/provinces')
            .done(function(response) {
                if (response.code === 'success') {
                    populateSelect(provinceSelect, response.data, defaultProvince);
                    if (defaultProvince) {
                        provinceSelect.trigger('change');
                    }
                }
            });

        // Handle province change
        provinceSelect.change(function() {
            var provinceId = $(this).val();
            if (provinceId) {
                districtSelect.prop('disabled', false);
                // Fetch all districts for selected province
                fetchData(`https://open.oapi.vn/location/districts/${provinceId}`)
                    .done(function(response) {
                        if (response.code === 'success') {
                            populateSelect(districtSelect, response.data, defaultDistrict);
                            if (defaultDistrict && provinceId == defaultProvince) {
                                districtSelect.trigger('change');
                            }
                        }
                    });
            } else {
                districtSelect.prop('disabled', true)
                    .empty()
                    .append('<option value="">Chọn Quận/Huyện</option>');
                wardSelect.prop('disabled', true)
                    .empty()
                    .append('<option value="">Chọn Xã/Phường</option>');
            }
        });

        // Handle district change
        districtSelect.change(function() {
            var districtId = $(this).val();
            if (districtId) {
                wardSelect.prop('disabled', false);
                // Fetch all wards for selected district
                fetchData(`https://open.oapi.vn/location/wards/${districtId}`)
                    .done(function(response) {
                        if (response.code === 'success') {
                            populateSelect(wardSelect, response.data, defaultWard);
                        }
                    });
            } else {
                wardSelect.prop('disabled', true)
                    .empty()
                    .append('<option value="">Chọn Xã/Phường</option>');
            }
        });
    }

    // Setup for customer address
    var defaultProvince = "<?php echo htmlspecialchars($khachhang['tinh_thanh']); ?>";
    var defaultDistrict = "<?php echo htmlspecialchars($khachhang['huyen']); ?>";
    var defaultWard = "<?php echo htmlspecialchars($khachhang['xa_phuong']); ?>";

    setupAddressFields(
        $('#tinh_thanh'),
        $('#huyen'),
        $('#xa_phuong'),
        defaultProvince,
        defaultDistrict,
        defaultWard
    );

    // Setup for relative address
    var defaultRelativeProvince = "<?php echo htmlspecialchars($nguoithan['tinh_thanh'] ?? ''); ?>";
    var defaultRelativeDistrict = "<?php echo htmlspecialchars($nguoithan['huyen'] ?? ''); ?>";
    var defaultRelativeWard = "<?php echo htmlspecialchars($nguoithan['xa_phuong'] ?? ''); ?>";

    setupAddressFields(
        $('#relative_tinh_thanh'),
        $('#relative_huyen'),
        $('#relative_xa_phuong'),
        defaultRelativeProvince,
        defaultRelativeDistrict,
        defaultRelativeWard
    );
});
</script>