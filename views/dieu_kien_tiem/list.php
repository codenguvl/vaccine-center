<?php
require_once 'controllers/dieu_kien_tiem_controller.php';
$dieu_kien_tiem_controller = new DieuKienTiemController($conn);
$dieu_kien_list = $dieu_kien_tiem_controller->getAllDieuKienTiem();

if (isset($_POST['action']) && $_POST['action'] == 'delete' && isset($_POST['id'])) {
    $result = $dieu_kien_tiem_controller->deleteDieuKienTiem($_POST['id']);
    if ($result) {
        $success_message = "Xóa điều kiện tiêm thành công.";
        $dieu_kien_list = $dieu_kien_tiem_controller->getAllDieuKienTiem();
    } else {
        $error_message = "Có lỗi xảy ra khi xóa điều kiện tiêm.";
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

<a href="index.php?page=dieu-kien-tiem-add" class="uk-button uk-button-primary uk-margin-bottom">Thêm Điều kiện tiêm
    mới</a>

<table id="dieu-kien-tiem-table" class="uk-table uk-table-hover uk-table-striped">
    <thead>
        <tr>
            <th>Tên điều kiện</th>
            <th>Mô tả</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($dieu_kien_list as $dieu_kien): ?>
            <tr>
                <td><?php echo htmlspecialchars($dieu_kien['ten_dieu_kien']); ?></td>
                <td><?php echo htmlspecialchars($dieu_kien['mo_ta_dieu_kien']); ?></td>
                <td>
                    <a href="index.php?page=dieu-kien-tiem-edit&id=<?php echo htmlspecialchars($dieu_kien['dieu_kien_id']); ?>"
                        class="uk-button uk-button-primary uk-button-small">Sửa</a>
                    <button class="uk-button uk-button-danger uk-button-small"
                        onclick="openDeleteModal('<?php echo htmlspecialchars($dieu_kien['dieu_kien_id']); ?>')">Xóa</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<!-- Modal xác nhận xóa -->
<div id="delete-modal" class="uk-modal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title">Xác nhận xóa</h2>
        <p>Bạn có chắc chắn muốn xóa điều kiện tiêm này?</p>
        <form id="delete-form" method="POST" action="index.php?page=dieu-kien-tiem-list">
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
    $(document).ready(function () {
        // Khởi tạo DataTable cho bảng Điều kiện tiêm
        $('#dieu-kien-tiem-table').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/vi.json' // Ngôn ngữ tiếng Việt
            },
            pageLength: 10, // Số dòng hiển thị mỗi trang
            responsive: true // Tự động điều chỉnh giao diện
        });
    });

    // Mở modal xác nhận xóa
    function openDeleteModal(id) {
        document.getElementById('delete-id').value = id;
        UIkit.modal('#delete-modal').show();
    }
</script>