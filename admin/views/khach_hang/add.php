<?php
require_once 'controllers/khachhang_controller.php';
$khachhang_controller = new KhachHangController($conn);

$message = '';
$status = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $khachhang_controller->addKhachHangWithRelative(
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
        $_POST['email'],
    );
    if ($result['status'] === 'success') {
        header("Location: index.php?page=khach-hang-list&message=add_success");
        exit();
    } else {
        $status = 'danger';
        if (!empty($result['existing'])) {
            $errors = [];
            if (isset($result['existing']['cccd'])) {
                $errors[] = 'CCCD đã tồn tại trong hệ thống';
            }
            if (isset($result['existing']['dienthoai'])) {
                $errors[] = 'Số điện thoại đã tồn tại trong hệ thống';
            }
            $message = implode('<br>', $errors);
        } else {
            $message = 'Có lỗi xảy ra khi thêm khách hàng!';
        }
    }
}
?>

<?php if ($message): ?>
    <div class="uk-alert-<?php echo $status; ?>" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <p><?php echo $message; ?></p>
    </div>
<?php endif; ?>

<form class="uk-form-stacked" action="index.php?page=khach-hang-add" method="POST">
    <div class="uk-margin">
        <label class="uk-form-label" for="fullname">Họ và tên:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="fullname" name="fullname" type="text" required>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="cccd">Số CCCD:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="cccd" name="cccd" type="text" required>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="ngaysinh">Ngày sinh:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="ngaysinh" name="ngaysinh" type="date" required>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="gioitinh">Giới tính:</label>
        <div class="uk-form-controls">
            <select class="uk-select" id="gioitinh" name="gioitinh" required>
                <option value="nam">Nam</option>
                <option value="nu">Nữ</option>
                <option value="khac">Khác</option>
            </select>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="dienthoai">Điện thoại:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="dienthoai" name="dienthoai" type="tel">
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="email">Email:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="email" name="email" type="email" required>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="diachi">Địa chỉ:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="diachi" name="diachi" type="text">
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
    <div class="uk-margin">
        <label class="uk-form-label" for="relative_fullname">Họ và tên người thân:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="relative_fullname" name="relative_fullname" type="text">
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="relative_quanhe">Quan hệ:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="relative_quanhe" name="relative_quanhe" type="text">
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="relative_dienthoai">Điện thoại người thân:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="relative_dienthoai" name="relative_dienthoai" type="tel">
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="relative_diachi">Địa chỉ người thân:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="relative_diachi" name="relative_diachi" type="text">
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

    <button class="uk-button uk-button-primary" type="submit">Thêm khách hàng</button>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        function fetchData(url) {
            return $.getJSON(url);
        }

        function populateSelect(selectElement, data) {
            selectElement.empty().append('<option value="">Chọn</option>');
            $.each(data, function (index, item) {
                selectElement.append($('<option></option>').attr('value', item.id).text(item.name));
            });
        }

        function setupAddressFields(provinceSelect, districtSelect, wardSelect) {
            // Fetch provinces
            fetchData('https://open.oapi.vn/location/provinces')
                .done(function (response) {
                    if (response.code === 'success') {
                        populateSelect(provinceSelect, response.data);
                    }
                });

            // Handle province change
            provinceSelect.change(function () {
                var provinceId = $(this).val();
                if (provinceId) {
                    districtSelect.prop('disabled', false);
                    // Fetch districts for selected province
                    fetchData(`https://open.oapi.vn/location/districts/${provinceId}`)
                        .done(function (response) {
                            if (response.code === 'success') {
                                populateSelect(districtSelect, response.data);
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
            districtSelect.change(function () {
                var districtId = $(this).val();
                if (districtId) {
                    wardSelect.prop('disabled', false);
                    // Fetch wards for selected district
                    fetchData(`https://open.oapi.vn/location/wards/${districtId}`)
                        .done(function (response) {
                            if (response.code === 'success') {
                                populateSelect(wardSelect, response.data);
                            }
                        });
                } else {
                    wardSelect.prop('disabled', true)
                        .empty()
                        .append('<option value="">Chọn Xã/Phường</option>');
                }
            });
        }

        // Setup địa chỉ khách hàng
        setupAddressFields(
            $('#tinh_thanh'),
            $('#huyen'),
            $('#xa_phuong')
        );

        // Setup địa chỉ người thân
        setupAddressFields(
            $('#relative_tinh_thanh'),
            $('#relative_huyen'),
            $('#relative_xa_phuong')
        );
    });
</script>