<?php
require_once 'controllers/tai_khoan_controller.php';
$tai_khoan_controller = new TaiKhoanController($conn);

$message = '';
$status = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Xử lý upload ảnh nếu có
    $avatar_path = null;
    if (isset($_FILES['anh_dai_dien']) && $_FILES['anh_dai_dien']['size'] > 0) {
        $upload_result = $tai_khoan_controller->handleAvatarUpload($_FILES['anh_dai_dien']);
        if ($upload_result['success']) {
            $avatar_path = $upload_result['path'];
        } else {
            $message = $upload_result['message'];
            $status = 'danger';
        }
    }

    // Nếu không có lỗi upload ảnh, tiến hành thêm tài khoản
    if (empty($message)) {
        $result = $tai_khoan_controller->addTaiKhoan(
            $_POST['ten_dang_nhap'],
            $_POST['mat_khau'],
            $_POST['email'],
            $_POST['ho_ten'],
            $_POST['gioi_tinh'],
            $_POST['dien_thoai'],
            $_POST['vai_tro_id'],
            $avatar_path // Thêm đường dẫn ảnh
        );

        if ($result) {
            header("Location: index.php?page=tai-khoan-list&message=add_success");
            exit();
        } else {
            $message = 'Có lỗi xảy ra khi thêm tài khoản!';
            $status = 'danger';
        }
    }
}

$all_vai_tro = $tai_khoan_controller->getAllVaiTro();
?>


<?php if ($message): ?>
    <div class="uk-alert-<?php echo $status; ?>" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <p><?php echo $message; ?></p>
    </div>
<?php endif; ?>

<form class="uk-form-stacked" action="index.php?page=tai-khoan-add" method="POST" enctype="multipart/form-data">
    <div class="uk-margin">
        <label class="uk-form-label">Ảnh đại diện:</label>
        <div class="uk-form-controls">
            <div class="uk-margin" uk-margin>
                <div uk-form-custom="target: true">
                    <input type="file" name="anh_dai_dien" accept="image/*">
                    <input class="uk-input uk-form-width-medium" type="text" placeholder="Chọn ảnh đại diện" disabled>
                </div>
                <button class="uk-button uk-button-default" type="button">Upload</button>
            </div>
            <div class="uk-margin">
                <div id="avatar-preview" class="uk-width-medium">
                    <img src="static/images/default-avatar.png" alt="Avatar Preview"
                        style="max-width: 150px; max-height: 150px; display: none;">
                </div>
            </div>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="ten_dang_nhap">Tên đăng nhập:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="ten_dang_nhap" name="ten_dang_nhap" type="text" required>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="mat_khau">Mật khẩu:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="mat_khau" name="mat_khau" type="password" required>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="email">Email:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="email" name="email" type="email" required>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="ho_ten">Họ tên:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="ho_ten" name="ho_ten" type="text" required>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="gioi_tinh">Giới tính:</label>
        <div class="uk-form-controls">
            <select class="uk-select" id="gioi_tinh" name="gioi_tinh">
                <option value="nam">Nam</option>
                <option value="nu">Nữ</option>
                <option value="khong_xac_dinh">Không xác định</option>
            </select>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="dien_thoai">Điện thoại:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="dien_thoai" name="dien_thoai" type="text">
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="vai_tro_id">Vai trò:</label>
        <div class="uk-form-controls">
            <select class="uk-select" id="vai_tro_id" name="vai_tro_id">
                <?php foreach ($all_vai_tro as $vai_tro): ?>
                    <option value="<?php echo $vai_tro['id']; ?>"><?php echo $vai_tro['ten_vai_tro']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <button class="uk-button uk-button-primary" type="submit">Thêm tài khoản</button>
</form>
<script>
    document.querySelector('input[name="anh_dai_dien"]').addEventListener('change', function (e) {
        const file = e.target.files[0];
        const preview = document.querySelector('#avatar-preview img');

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            preview.src = 'static/images/default-avatar.png';
            preview.style.display = 'none';
        }
    });
</script>