<?php
require_once 'controllers/dang_ky_tiem_tai_nha_controller.php';
$dang_ky_controller = new DangKyTiemTaiNhaController($conn);
$dang_ky_list = $dang_ky_controller->getAllDangKy();

// Handle delete action
if (isset($_POST['action']) && $_POST['action'] == 'update-status' && isset($_POST['id']) && isset($_POST['new_status'])) {
    $result = $dang_ky_controller->updateStatus($_POST['id'], $_POST['new_status']);
    if ($result) {
        $success_message = "Cập nhật trạng thái thành công.";
        $dang_ky_list = $dang_ky_controller->getAllDangKy();
    } else {
        $error_message = "Có lỗi xảy ra khi cập nhật trạng thái.";
    }
}

function mapStatusToVietnamese($status)
{
    switch ($status) {
        case 'cho_xu_ly':
            return 'Chờ xử lý';
        case 'da_xu_ly':
            return 'Đã xử lý';
        case 'huy':
            return 'Hủy';
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

<table id="dang-ky-table" class="uk-table uk-table-hover uk-table-striped">
    <thead>
        <tr>
            <th>Họ tên</th>
            <th>Ngày sinh</th>
            <th>Giới tính</th>
            <th>Địa chỉ</th>
            <th>Trạng thái</th>
            <th>Số điện thoại</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($dang_ky_list as $dang_ky): ?>
        <tr>
            <td><?php echo htmlspecialchars($dang_ky['ho_ten']); ?></td>
            <td><?php echo date('d-m-Y', strtotime($dang_ky['ngay_sinh'])); ?></td>
            <td><?php echo htmlspecialchars($dang_ky['gioi_tinh']); ?></td>
            <td><?php echo htmlspecialchars($dang_ky['dia_chi']); ?></td>
            <td><?php echo htmlspecialchars(mapStatusToVietnamese($dang_ky['trang_thai'])); ?></td>
            <td><?php echo htmlspecialchars($dang_ky['dien_thoai_lien_he']); ?></td>
            <td>
                <a href="index.php?page=dang-ky-tiem-tai-nha-detail&id=<?php echo htmlspecialchars($dang_ky['dang_ky_id']); ?>"
                    class="uk-button uk-button-info uk-button-default uk-button-small">Xem chi tiết</a>
                <button class="uk-button uk-button-secondary uk-button-small"
                    onclick="openUpdateStatusModal('<?php echo htmlspecialchars($dang_ky['dang_ky_id']); ?>', '<?php echo htmlspecialchars($dang_ky['trang_thai']); ?>')">Cập
                    nhật
                    trạng thái</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Modal cập nhật trạng thái -->
<div id="update-status-modal" class="uk-modal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title">Cập nhật trạng thái</h2>
        <form id="update-status-form" method="POST" action="index.php?page=dang-ky-tiem-tai-nha-list">
            <input type="hidden" name="action" value="update-status">
            <input type="hidden" name="id" id="update-status-id" value="">
            <div class="uk-margin">
                <label for="new-status">Trạng thái mới:</label>
                <select id="new-status" name="new_status" class="uk-select">
                    <option value="cho_xu_ly">Chờ xử lý</option>
                    <option value="da_xu_ly">Đã xử lý</option>
                    <option value="huy">Hủy</option>
                </select>
            </div>
            <p class="uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close" type="button">Hủy</button>
                <button class="uk-button uk-button-primary" type="submit">Cập nhật</button>
            </p>
        </form>
    </div>
</div>

<script>
function openUpdateStatusModal(id, currentStatus) {
    document.getElementById('update-status-id').value = id;
    document.getElementById('new-status').value = currentStatus;
    UIkit.modal('#update-status-modal').show();
}
</script>

<script>
$(document).ready(function() {
    // Biến bảng thành DataTable
    $('#dang-ky-table').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/vi.json' // Thay đổi ngôn ngữ sang tiếng Việt nếu cần
        },
        pageLength: 10, // Số lượng hàng hiển thị mặc định
        responsive: true // Đáp ứng giao diện di động
    });
});
</script>