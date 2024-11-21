<?php
require_once 'controllers/vai_tro_controller.php';
$vai_tro_controller = new VaiTroController($conn);
$vai_tro_list = $vai_tro_controller->getAllVaiTro();

// Handle delete action
if (isset($_POST['action']) && $_POST['action'] == 'delete' && isset($_POST['id'])) {
    $result = $vai_tro_controller->deleteVaiTro($_POST['id']);
    if ($result['success']) {
        $success_message = $result['message'];
        $vai_tro_list = $vai_tro_controller->getAllVaiTro();
    } else {
        $error_message = $result['message'];
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

<a href="index.php?page=vai-tro-add" class="uk-button uk-button-primary uk-margin-bottom">Thêm Vai trò mới</a>

<table class="uk-table uk-table-hover uk-table-striped" id="vai-tro-table">
    <thead>
        <tr>
            <th>Tên vai trò</th>
            <th>Mô tả</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($vai_tro_list as $vai_tro): ?>
        <tr>
            <td><?php echo htmlspecialchars($vai_tro['ten_vai_tro']); ?></td>
            <td><?php echo htmlspecialchars($vai_tro['mo_ta']); ?></td>
            <td>
                <a href="index.php?page=vai-tro-edit&id=<?php echo htmlspecialchars($vai_tro['id']); ?>"
                    class="uk-button uk-button-primary uk-button-small">Sửa</a>
                <button class="uk-button uk-button-danger uk-button-small"
                    onclick="openDeleteModal('<?php echo htmlspecialchars($vai_tro['id']); ?>')">Xóa</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Modal xác nhận xóa -->
<div id="delete-modal" class="uk-modal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title">Xác nhận xóa</h2>
        <p>Bạn có chắc chắn muốn xóa vai trò này?</p>
        <form id="delete-form" method="POST" action="index.php?page=vai-tro-list">
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
    // Cập nhật id vai trò vào form
    document.getElementById('delete-id').value = id;
    // Mở modal
    UIkit.modal('#delete-modal').show();
}
$(document).ready(function() {
    $('#vai-tro-table').DataTable({
        "language": {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/vi.json' // Đổi ngôn ngữ sang tiếng Việt
        },
        "paging": true, // Enable pagination
        "searching": true, // Enable search functionality
        "ordering": true, // Enable column sorting
        "info": true, // Show table information (e.g., "Showing 1 to 10 of 100 entries")
    });
});
</script>