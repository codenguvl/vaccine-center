<?php
require_once 'controllers/doi_tuong_tiem_chung_controller.php';
$doi_tuong_controller = new DoiTuongTiemChungController($conn);
$doi_tuong_list = $doi_tuong_controller->getAllDoiTuong();

if (isset($_POST['action']) && $_POST['action'] == 'delete' && isset($_POST['id'])) {
    $result = $doi_tuong_controller->deleteDoiTuong($_POST['id']);
    if ($result) {
        $success_message = "Xóa đối tượng tiêm chủng thành công.";
        $doi_tuong_list = $doi_tuong_controller->getAllDoiTuong();
    } else {
        $error_message = "Có lỗi xảy ra khi xóa đối tượng tiêm chủng.";
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

<a href="index.php?page=doi-tuong-tiem-chung-add" class="uk-button uk-button-primary uk-margin-bottom">Thêm đối tượng
    mới</a>

<table id="doi-tuong-table" class="uk-table uk-table-hover uk-table-striped">
    <thead>
        <tr>
            <th>Tên đối tượng</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($doi_tuong_list as $doi_tuong): ?>
            <tr>
                <td><?php echo htmlspecialchars($doi_tuong['ten_doi_tuong']); ?></td>
                <td>
                    <a href="index.php?page=doi-tuong-tiem-chung-edit&id=<?php echo htmlspecialchars($doi_tuong['doi_tuong_id']); ?>"
                        class="uk-button uk-button-primary uk-button-small">Sửa</a>
                    <button class="uk-button uk-button-danger uk-button-small"
                        onclick="openDeleteModal('<?php echo htmlspecialchars($doi_tuong['doi_tuong_id']); ?>')">Xóa</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<!-- Modal xác nhận xóa -->
<div id="delete-modal" class="uk-modal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title">Xác nhận xóa</h2>
        <p>Bạn có chắc chắn muốn xóa đối tượng tiêm chủng này?</p>
        <form id="delete-form" method="POST" action="index.php?page=doi-tuong-tiem-chung-list">
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
        // Khởi tạo DataTables cho bảng "Đối tượng tiêm chủng"
        $('#doi-tuong-table').DataTable({
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