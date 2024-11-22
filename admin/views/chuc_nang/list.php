<?php
require_once 'controllers/chuc_nang_controller.php';
$chuc_nang_controller = new ChucNangController($conn);
$chuc_nang_list = $chuc_nang_controller->getAllChucNang();

// Handle delete action
if (isset($_POST['action']) && $_POST['action'] == 'delete' && isset($_POST['id'])) {
    $result = $chuc_nang_controller->deleteChucNang($_POST['id']);
    if ($result) {
        $success_message = "Xóa chức năng thành công.";
        $chuc_nang_list = $chuc_nang_controller->getAllChucNang();
    } else {
        $error_message = "Có lỗi xảy ra khi xóa chức năng.";
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

<a href="index.php?page=chuc-nang-add" class="uk-button uk-button-primary uk-margin-bottom">Thêm Chức năng mới</a>

<table id="chuc-nang-table" class="uk-table uk-table-hover uk-table-striped">
    <thead>
        <tr>
            <th>Tên chức năng</th>
            <th>Mô tả</th>
            <th>Đường dẫn</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($chuc_nang_list as $chuc_nang): ?>
            <tr>
                <td><?php echo htmlspecialchars($chuc_nang['ten_chuc_nang']); ?></td>
                <td><?php echo htmlspecialchars($chuc_nang['mo_ta']); ?></td>
                <td><?php echo htmlspecialchars($chuc_nang['duong_dan']); ?></td>
                <td>
                    <a href="index.php?page=chuc-nang-edit&id=<?php echo htmlspecialchars($chuc_nang['id']); ?>"
                        class="uk-button uk-button-primary uk-button-small">Sửa</a>
                    <button class="uk-button uk-button-danger uk-button-small"
                        onclick="openDeleteModal('<?php echo htmlspecialchars($chuc_nang['id']); ?>')">Xóa</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<!-- Modal xác nhận xóa -->
<div id="delete-modal" class="uk-modal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title">Xác nhận xóa</h2>
        <p>Bạn có chắc chắn muốn xóa chức năng này?</p>
        <form id="delete-form" method="POST" action="index.php?page=chuc-nang-list">
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
    $(document).ready(function () {
        // Biến bảng thành DataTable
        $('#chuc-nang-table').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/vi.json' // Thay đổi ngôn ngữ sang tiếng Việt nếu cần
            },
            pageLength: 10, // Số lượng hàng hiển thị mặc định
            responsive: true // Đáp ứng giao diện di động
        });
    });
</script>