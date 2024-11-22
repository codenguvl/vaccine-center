<?php
require_once 'controllers/tai_khoan_controller.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Khởi tạo controller
$tai_khoan_controller = new TaiKhoanController($conn);

// Lấy thông tin người dùng
$user = $tai_khoan_controller->getTaiKhoanById($_SESSION['user_id']);

if (!$user) {
    // Nếu không tìm thấy thông tin user, có thể session đã hết hạn
    session_destroy();
    header('Location: login.php');
    exit;
}

// Xử lý form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    $message = '';
    $status = '';
    $upload_result = ['success' => false];

    // Trong phần xử lý POST
    if (isset($_FILES['avatar']) && $_FILES['avatar']['size'] > 0) {
        error_log("Processing avatar upload in profile");
        $upload_result = $tai_khoan_controller->handleAvatarUpload($_FILES['avatar']);
        error_log("Upload result: " . print_r($upload_result, true));

        if ($upload_result['success']) {
            // Cập nhật đường dẫn ảnh trong database
            $avatar_update = $tai_khoan_controller->updateAvatar($_SESSION['user_id'], $upload_result['path']);
            if (!$avatar_update) {
                $message = 'Có lỗi xảy ra khi cập nhật ảnh đại diện.';
                $status = 'danger';
            } else {
                // Cập nhật lại đường dẫn ảnh đại diện để hiển thị ngay lập tức
                $user['anh_dai_dien'] = $upload_result['path'];
            }
        } else {
            $message = $upload_result['message'];
            $status = 'danger';
        }
    }


    if ($action === 'update_profile') {
        $current_user = $tai_khoan_controller->getTaiKhoanById($_SESSION['user_id']);
        $update_info = false; // Biến để theo dõi xem có cập nhật thông tin không

        if (
            $_POST['email'] !== $current_user['email'] ||
            $_POST['ho_ten'] !== $current_user['ho_ten'] ||
            $_POST['gioi_tinh'] !== $current_user['gioi_tinh'] ||
            $_POST['dien_thoai'] !== $current_user['dien_thoai']
        ) {
            // Nếu có thay đổi, tiến hành cập nhật thông tin
            $result = $tai_khoan_controller->updateProfile(
                $_SESSION['user_id'],
                $_POST['email'],
                $_POST['ho_ten'],
                $_POST['gioi_tinh'],
                $_POST['dien_thoai']
            );

            if ($result) {
                $update_info = true; // Đánh dấu là đã cập nhật thông tin
                $user = $tai_khoan_controller->getTaiKhoanById($_SESSION['user_id']);
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
    } elseif ($action === 'change_password') {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Kiểm tra mật khẩu hiện tại (có thể là mật khẩu tạm hoặc mật khẩu chính)
        $verify_result = $tai_khoan_controller->verifyPassword($_SESSION['user_id'], $current_password);

        if (!$verify_result) {
            $error_message = "Mật khẩu hiện tại không đúng!";
        } elseif ($new_password !== $confirm_password) {
            $error_message = "Mật khẩu mới không khớp!";
        } elseif (strlen($new_password) < 6) {
            $error_message = "Mật khẩu mới phải có ít nhất 6 ký tự!";
        } else {
            // Sử dụng phương thức mới để cập nhật mật khẩu và xóa mật khẩu tạm
            $result = $tai_khoan_controller->updatePasswordAfterTemp($_SESSION['user_id'], $new_password);

            if ($result) {
                $success_message = "Đổi mật khẩu thành công!";
                // Nếu đang sử dụng mật khẩu tạm, xóa flag
                if (isset($_SESSION['temp_password'])) {
                    unset($_SESSION['temp_password']);
                }
            } else {
                $error_message = "Có lỗi xảy ra khi đổi mật khẩu!";
            }
        }
    }

}
?>

<div class="profile-container">

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

    <?php if (isset($message)): ?>
    <div class="uk-alert-<?php echo $status; ?>" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <p><?php echo $message; ?></p>
    </div>
    <?php endif; ?>


    <ul class="uk-tab profile-tabs" uk-switcher="animation: uk-animation-fade">
        <li><a href="#">Thông tin cơ bản</a></li>
        <li><a href="#">Đổi mật khẩu</a></li>
    </ul>

    <ul class="uk-switcher uk-margin">
        <!-- Tab thông tin cơ bản -->
        <li>
            <form class="uk-form-stacked" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>"
                method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="update_profile">
                <div class="uk-margin">
                    <label class="uk-form-label">Ảnh đại diện hiện tại:</label>
                    <div class="uk-form-controls">
                        <div class="uk-margin">
                            <img src="<?php echo !empty($user['anh_dai_dien']) ? $user['anh_dai_dien'] : 'static/images/default-avatar.png'; ?>"
                                alt="Avatar Preview" style="max-width: 150px; max-height: 150px;" id="current-avatar">
                        </div>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label">Cập nhật ảnh đại diện:</label>
                    <div class="uk-form-controls">
                        <div class="uk-margin" uk-margin>
                            <div uk-form-custom="target: true">
                                <input type="file" name="avatar" accept="image/*">
                                <input class="uk-input uk-form-width-medium" type="text" placeholder="Chọn ảnh mới"
                                    disabled>
                            </div>
                            <button class="uk-button uk-button-default" type="button">Chọn ảnh</button>
                        </div>
                        <div class="uk-margin">
                            <div id="avatar-preview" class="uk-width-medium">
                                <img src="" alt="New Avatar Preview"
                                    style="max-width: 150px; max-height: 150px; display: none;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="ten_dang_nhap">Tên đăng nhập:</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="ten_dang_nhap" type="text"
                            value="<?php echo htmlspecialchars($user['ten_dang_nhap']); ?>" disabled>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="email">Email:</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="email" name="email" type="email"
                            value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="ho_ten">Họ tên:</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="ho_ten" name="ho_ten" type="text"
                            value="<?php echo htmlspecialchars($user['ho_ten']); ?>" required>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="gioi_tinh">Giới tính:</label>
                    <div class="uk-form-controls">
                        <select class="uk-select" id="gioi_tinh" name="gioi_tinh">
                            <option value="nam" <?php echo $user['gioi_tinh'] == 'nam' ? 'selected' : ''; ?>>Nam
                            </option>
                            <option value="nu" <?php echo $user['gioi_tinh'] == 'nu' ? 'selected' : ''; ?>>Nữ</option>
                            <option value="khong_xac_dinh"
                                <?php echo $user['gioi_tinh'] == 'khong_xac_dinh' ? 'selected' : ''; ?>>
                                Không xác định</option>
                        </select>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="dien_thoai">Điện thoại:</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="dien_thoai" name="dien_thoai" type="text"
                            value="<?php echo htmlspecialchars($user['dien_thoai']); ?>">
                    </div>
                </div>
                <button class="uk-button uk-button-primary" type="submit">Cập nhật tài khoản</button>
            </form>

            <script>
            document.querySelector('input[name="avatar"]').addEventListener('change', function(e) {
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
        </li>

        <!-- Tab đổi mật khẩu -->
        <li>
            <form class="uk-form-horizontal" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>"
                method="POST">
                <input type="hidden" name="action" value="change_password">

                <div class="uk-margin">
                    <label class="uk-form-label">Mật khẩu hiện tại:</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" type="password" name="current_password" required>
                    </div>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label">Mật khẩu mới:</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" type="password" name="new_password" required>
                    </div>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label">Xác nhận mật khẩu mới:</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" type="password" name="confirm_password" required>
                    </div>
                </div>

                <div class="uk-margin uk-text-center">
                    <button type="submit" class="uk-button uk-button-primary">Đổi mật khẩu</button>
                </div>
            </form>
        </li>
    </ul>
</div>