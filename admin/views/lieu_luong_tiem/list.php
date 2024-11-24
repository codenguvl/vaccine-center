<?php
require_once 'controllers/lieu_luong_tiem_controller.php';
$lieu_luong_tiem_controller = new LieuLuongTiemController($conn);
$lieu_luong_tiem_list = $lieu_luong_tiem_controller->getAllLieuLuongTiem();

if (isset($_POST['action']) && $_POST['action'] == 'delete' && isset($_POST['id'])) {
    $result = $lieu_luong_tiem_controller->deleteLieuLuongTiem($_POST['id']);
    if ($result) {
        $success_message = "Xóa liều lượng tiêm thành công.";
        $lieu_luong_tiem_list = $lieu_luong_tiem_controller->getAllLieuLuongTiem();
    } else {
        $error_message = "Có lỗi xảy ra khi xóa liều lượng tiêm.";
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

<a href="index.php?page=lieu-luong-tiem-add" class="uk-button uk-button-primary uk-margin-bottom">Thêm liều lượng tiêm
    mới</a>

<table id="lieu-luong-tiem-table" class="uk-table uk-table-hover uk-table-striped">
    <thead>
        <tr>
            <th>Giá trị</th>
            <th>Mô tả</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($lieu_luong_tiem_list as $lieu_luong_tiem): ?>
        <tr>
            <td><?php echo htmlspecialchars($lieu_luong_tiem['gia_tri']); ?></td>
            <td><?php echo htmlspecialchars($lieu_luong_tiem['mo_ta']); ?></td>
            <td>
                <a href="index.php?page=lieu-luong-tiem-edit&id=<?php echo htmlspecialchars($lieu_luong_tiem['lieu_luong_id']); ?>"
                    class="uk-button uk-button-primary uk-button-small">Sửa</a>
                <button class="uk-button uk-button-danger uk-button-small"
                    onclick="openDeleteModal('<?php echo htmlspecialchars($lieu_luong_tiem['lieu_luong_id']); ?>')">Xóa</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div id="delete-modal" class="uk-modal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title">Xác nhận xóa</h2>
        <p>Bạn có chắc chắn muốn xóa liều lượng tiêm này?</p>
        <form id="delete-form" method="POST" action="index.php?page=lieu-luong-tiem-list">
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
$(document).ready(function() {
    $('#lieu-luong-tiem-table').DataTable({
        "paging": true, // Cho phép phân trang
        "searching": true, // Cho phép tìm kiếm
        "ordering": true, // Cho phép sắp xếp
        "info": true, // Hiển thị thông tin tổng số
        "language": {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/vi.json' // Đổi ngôn ngữ sang tiếng Việt
        },
    });
});
</script>