<?php
require_once 'controllers/tai_khoan_controller.php';
$tai_khoan_controller = new TaiKhoanController($conn);

$id = isset($_GET['id']) ? $_GET['id'] : null;
$tai_khoan = $tai_khoan_controller->getTaiKhoanById($id);

if (!$tai_khoan) {
    echo "Tài khoản không tồn tại.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = '';
    $status = '';
    $upload_result = ['success' => false]; // Khởi tạo biến upload_result

    // Xử lý upload ảnh nếu có
    if (isset($_FILES['anh_dai_dien']) && $_FILES['anh_dai_dien']['size'] > 0) {
        error_log("Processing avatar upload in edit");
        $upload_result = $tai_khoan_controller->handleAvatarUpload($_FILES['anh_dai_dien']);
        error_log("Upload result: " . print_r($upload_result, true));

        if ($upload_result['success']) {
            // Cập nhật đường dẫn ảnh trong database
            $avatar_update = $tai_khoan_controller->updateAvatar($id, $upload_result['path']);
            if (!$avatar_update) {
                $message = 'Có lỗi xảy ra khi cập nhật ảnh đại diện.';
                $status = 'danger';
            } else {
                // Cập nhật lại đường dẫn ảnh đại diện để hiển thị ngay lập tức
                $tai_khoan['anh_dai_dien'] = $upload_result['path'];
            }
        } else {
            $message = $upload_result['message'];
            $status = 'danger';
        }
    }

    // Kiểm tra xem có thay đổi nào trong thông tin khác không
    $current_tai_khoan = $tai_khoan_controller->getTaiKhoanById($id);
    $update_info = false; // Biến để theo dõi xem có cập nhật thông tin không

    if (
        $_POST['email'] !== $current_tai_khoan['email'] ||
        $_POST['ho_ten'] !== $current_tai_khoan['ho_ten'] ||
        $_POST['gioi_tinh'] !== $current_tai_khoan['gioi_tinh'] ||
        $_POST['dien_thoai'] !== $current_tai_khoan['dien_thoai'] ||
        $_POST['vai_tro_id'] !== $current_tai_khoan['vai_tro_id'] ||
        $_POST['trang_thai'] !== $current_tai_khoan['trang_thai']
    ) {
        // Nếu có thay đổi, tiến hành cập nhật thông tin
        $result = $tai_khoan_controller->updateTaiKhoan(
            $id,
            $_POST['email'],
            $_POST['ho_ten'],
            $_POST['gioi_tinh'],
            $_POST['dien_thoai'],
            $_POST['vai_tro_id'],
            $_POST['trang_thai']
        );

        if ($result) {
            $update_info = true; // Đánh dấu là đã cập nhật thông tin
            $tai_khoan = $tai_khoan_controller->getTaiKhoanById($id);
        } else {
            $message = 'Có lỗi xảy ra khi cập nhật tài khoản.';
            $status = 'danger';
        }
    }

    // Nếu có cập nhật thông tin hoặc ảnh đại diện thành công
    if ($upload_result['success'] || $update_info) {
        $message = 'Cập nhật tài khoản thành công.';
        $status = 'success';
    }
}

$all_vai_tro = $tai_khoan_controller->getAllVaiTro();
?>
<?php if (isset($message)): ?>
<div class="uk-alert-<?php echo $status; ?>" uk-alert>
    <a class="uk-alert-close" uk-close></a>
    <p><?php echo $message; ?></p>
</div>
<?php endif; ?>

<form class="uk-form-stacked" action="index.php?page=tai-khoan-edit&id=<?php echo $id; ?>" method="POST"
    enctype="multipart/form-data">
    <div class="uk-margin">
        <label class="uk-form-label">Ảnh đại diện hiện tại:</label>
        <div class="uk-form-controls">
            <div class="uk-margin">
                <img src="<?php echo !empty($tai_khoan['anh_dai_dien']) ? $tai_khoan['anh_dai_dien'] : 'static/images/default-avatar.png'; ?>"
                    alt="Avatar Preview" style="max-width: 150px; max-height: 150px;" id="current-avatar">
            </div>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label">Cập nhật ảnh đại diện:</label>
        <div class="uk-form-controls">
            <div class="uk-margin" uk-margin>
                <div uk-form-custom="target: true">
                    <input type="file" name="anh_dai_dien" accept="image/*">
                    <input class="uk-input uk-form-width-medium" type="text" placeholder="Chọn ảnh mới" disabled>
                </div>
                <button class="uk-button uk-button-default" type="button">Chọn ảnh</button>
            </div>
            <div class="uk-margin">
                <div id="avatar-preview" class="uk-width-medium">
                    <img src="" alt="New Avatar Preview" style="max-width: 150px; max-height: 150px; display: none;">
                </div>
            </div>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="ten_dang_nhap">Tên đăng nhập:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="ten_dang_nhap" type="text"
                value="<?php echo htmlspecialchars($tai_khoan['ten_dang_nhap']); ?>" disabled>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="email">Email:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="email" name="email" type="email"
                value="<?php echo htmlspecialchars($tai_khoan['email']); ?>" required>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="ho_ten">Họ tên:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="ho_ten" name="ho_ten" type="text"
                value="<?php echo htmlspecialchars($tai_khoan['ho_ten']); ?>" required>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="gioi_tinh">Giới tính:</label>
        <div class="uk-form-controls">
            <select class="uk-select" id="gioi_tinh" name="gioi_tinh">
                <option value="nam" <?php echo $tai_khoan['gioi_tinh'] == 'nam' ? 'selected' : ''; ?>>Nam</option>
                <option value="nu" <?php echo $tai_khoan['gioi_tinh'] == 'nu' ? 'selected' : ''; ?>>Nữ</option>
                <option value="khong_xac_dinh"
                    <?php echo $tai_khoan['gioi_tinh'] == 'khong_xac_dinh' ? 'selected' : ''; ?>>Không xác định</option>
            </select>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="dien_thoai">Điện thoại:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="dien_thoai" name="dien_thoai" type="text"
                value="<?php echo htmlspecialchars($tai_khoan['dien_thoai']); ?>">
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="vai_tro_id">Vai trò:</label>
        <div class="uk-form-controls">
            <select class="uk-select" id="vai_tro_id" name="vai_tro_id">
                <?php foreach ($all_vai_tro as $vai_tro): ?>
                <option value="<?php echo $vai_tro['id']; ?>"
                    <?php echo $tai_khoan['vai_tro_id'] == $vai_tro['id'] ? 'selected' : ''; ?>>
                    <?php echo $vai_tro['ten_vai_tro']; ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="trang_thai">Trạng thái:</label>
        <div class="uk-form-controls">
            <select class="uk-select" id="trang_thai" name="trang_thai">
                <option value="dang_hoat_dong"
                    <?php echo $tai_khoan['trang_thai'] == 'dang_hoat_dong' ? 'selected' : ''; ?>>Đang hoạt động
                </option>
                <option value="khoa" <?php echo $tai_khoan['trang_thai'] == 'khoa' ? 'selected' : ''; ?>>Khóa</option>
                <option value="dong" <?php echo $tai_khoan['trang_thai'] == 'dong' ? 'selected' : ''; ?>>Đóng</option>
            </select>
        </div>
    </div>
    <button class="uk-button uk-button-primary" type="submit">Cập nhật tài khoản</button>
</form>

<script>
document.querySelector('input[name="anh_dai_dien"]').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.querySelector('#avatar-preview img');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        preview.src = '';
        preview.style.display = 'none';
    }
});
</script>