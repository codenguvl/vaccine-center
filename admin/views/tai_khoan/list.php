<?php
require_once 'controllers/tai_khoan_controller.php';
$tai_khoan_controller = new TaiKhoanController($conn);
$tai_khoan_list = $tai_khoan_controller->getAllTaiKhoan();

// Handle delete action
if (isset($_POST['action']) && $_POST['action'] == 'delete' && isset($_POST['id'])) {
    $result = $tai_khoan_controller->deleteTaiKhoan($_POST['id']);
    if ($result) {
        $success_message = "Xóa tài khoản thành công.";
        $tai_khoan_list = $tai_khoan_controller->getAllTaiKhoan();
    } else {
        $error_message = "Có lỗi xảy ra khi xóa tài khoản.";
    }
}

// Handle status update
if (isset($_POST['action']) && $_POST['action'] == 'update_status' && isset($_POST['id']) && isset($_POST['status'])) {
    $result = $tai_khoan_controller->updateTrangThai($_POST['id'], $_POST['status']);
    header('Content-Type: application/json');
    echo json_encode($result);
    exit;
}

function getTrangThaiLabel($trang_thai)
{
    switch ($trang_thai) {
        case 'dang_hoat_dong':
            return '<span class="uk-label uk-label-success">Đang hoạt động</span>';
        case 'khoa':
            return '<span class="uk-label uk-label-warning">Khóa</span>';
        case 'dong':
            return '<span class="uk-label uk-label-danger">Đóng</span>';
        default:
            return '<span class="uk-label">Không xác định</span>';
    }
}

function getGioiTinhLabel($gioi_tinh)
{
    switch ($gioi_tinh) {
        case 'nam':
            return 'Nam';
        case 'nu':
            return 'Nữ';
        case 'khong_xac_dinh':
            return 'Không xác định';
        default:
            return 'Không xác định';
    }
}
?>

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

<a href="index.php?page=tai-khoan-add" class="uk-button uk-button-primary uk-margin-bottom">Thêm Tài khoản mới</a>

<table id="tai-khoan-table" class="uk-table uk-table-hover uk-table-striped">
    <thead>
        <tr>
            <th>Tên đăng nhập</th>
            <th>Email</th>
            <th>Họ tên</th>
            <th>Giới tính</th>
            <th>Điện thoại</th>
            <th>Vai trò</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tai_khoan_list as $tai_khoan): ?>
        <tr data-id="<?php echo htmlspecialchars($tai_khoan['id']); ?>">
            <td><?php echo htmlspecialchars($tai_khoan['ten_dang_nhap']); ?></td>
            <td><?php echo htmlspecialchars($tai_khoan['email']); ?></td>
            <td><?php echo htmlspecialchars($tai_khoan['ho_ten']); ?></td>
            <td><?php echo getGioiTinhLabel($tai_khoan['gioi_tinh']); ?></td>
            <td><?php echo htmlspecialchars($tai_khoan['dien_thoai']); ?></td>
            <td><?php echo htmlspecialchars($tai_khoan['ten_vai_tro']); ?></td>
            <td class="d-flex">
                <?php echo getTrangThaiLabel($tai_khoan['trang_thai']); ?>
                <label class="uk-switch uk-margin-small-left">
                    <input type="checkbox" <?php echo $tai_khoan['trang_thai'] == 'dang_hoat_dong' ? 'checked' : ''; ?>
                        onchange="updateTrangThai(<?php echo $tai_khoan['id']; ?>, this.checked ? 'dang_hoat_dong' : 'khoa')">
                    <div class="uk-switch-slider"></div>
                </label>
            </td>
            <td>
                <a href="index.php?page=tai-khoan-edit&id=<?php echo htmlspecialchars($tai_khoan['id']); ?>"
                    class="uk-button uk-button-primary uk-button-small">Sửa</a>
                <button class="uk-button uk-button-danger uk-button-small"
                    onclick="openDeleteModal('<?php echo htmlspecialchars($tai_khoan['id']); ?>')">Xóa</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<!-- Modal xác nhận xóa -->
<div id="delete-modal" class="uk-modal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title">Xác nhận xóa</h2>
        <p>Bạn có chắc chắn muốn xóa tài khoản này?</p>
        <form id="delete-form" method="POST" action="index.php?page=tai-khoan-list">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="id" id="delete-id" value="">
            <p class="uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close" type="button">Hủy</button>
                <button class="uk-button uk-button-danger" type="submit">Xóa</button>
            </p>
        </form>
    </div>
</div>

<script>
function openDeleteModal(id) {
    document.getElementById('delete-id').value = id;
    UIkit.modal('#delete-modal').show();
}
</script>

<script>
function updateTrangThai(id, status) {
    fetch('index.php?page=tai-khoan-list', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=update_status&id=${id}&status=${status}`
        })
        .then(response => {
            if (response.ok) {
                // Nếu cập nhật thành công, load lại trang
                window.location.reload();
            } else {
                throw new Error('Network response was not ok.');
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            UIkit.notification({
                message: 'Đã xảy ra lỗi khi cập nhật trạng thái',
                status: 'danger'
            });
        });
}
</script>
<script>
$(document).ready(function() {
    // Initialize DataTable on the table with id 'tai-khoan-table'
    $('#tai-khoan-table').DataTable({
        "language": {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/vi.json' // Đổi ngôn ngữ sang tiếng Việt
        },
        "paging": true, // Enable pagination
        "searching": true, // Enable searching
        "ordering": true, // Enable sorting
        "info": true, // Show table information
    });
});
</script>

<style>
.uk-switch {
    position: relative;
    display: inline-block;
    height: 24px;
    width: 40px;
}

.uk-switch input {
    display: none;
}

.uk-switch-slider {
    background-color: rgba(0, 0, 0, 0.22);
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    border-radius: 500px;
    bottom: 0;
    cursor: pointer;
    transition-property: background-color;
    transition-duration: .2s;
    box-shadow: inset 0 0 2px rgba(0, 0, 0, 0.07);
}

.uk-switch-slider:before {
    content: '';
    background-color: #fff;
    position: absolute;
    width: 20px;
    height: 20px;
    left: 2px;
    bottom: 2px;
    border-radius: 50%;
    transition-property: transform, box-shadow;
    transition-duration: .2s;
}

input:checked+.uk-switch-slider {
    background-color: #39f !important;
}

input:checked+.uk-switch-slider:before {
    transform: translateX(16px);
}
</style>