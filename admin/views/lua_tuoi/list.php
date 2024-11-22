<?php
require_once 'controllers/lua_tuoi_controller.php';
$lua_tuoi_controller = new LuaTuoiController($conn);
$lua_tuoi_list = $lua_tuoi_controller->getAllLuaTuoi();

if (isset($_POST['action']) && $_POST['action'] == 'delete' && isset($_POST['id'])) {
    $result = $lua_tuoi_controller->deleteLuaTuoi($_POST['id']);
    if ($result) {
        $success_message = "Xóa lứa tuổi thành công.";
        $lua_tuoi_list = $lua_tuoi_controller->getAllLuaTuoi();
    } else {
        $error_message = "Có lỗi xảy ra khi xóa lứa tuổi.";
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

<a href="index.php?page=lua-tuoi-add" class="uk-button uk-button-primary uk-margin-bottom">Thêm Lứa tuổi mới</a>

<table id="lua-tuoi-table" class="uk-table uk-table-hover uk-table-striped">
    <thead>
        <tr>
            <th>Mô tả</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($lua_tuoi_list as $lua_tuoi): ?>
            <tr>
                <td><?php echo htmlspecialchars($lua_tuoi['mo_ta']); ?></td>
                <td>
                    <a href="index.php?page=lua-tuoi-edit&id=<?php echo htmlspecialchars($lua_tuoi['lua_tuoi_id']); ?>"
                        class="uk-button uk-button-primary uk-button-small">Sửa</a>
                    <button class="uk-button uk-button-danger uk-button-small"
                        onclick="openDeleteModal('<?php echo htmlspecialchars($lua_tuoi['lua_tuoi_id']); ?>')">Xóa</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Modal xác nhận xóa -->
<div id="delete-modal" class="uk-modal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title">Xác nhận xóa</h2>
        <p>Bạn có chắc chắn muốn xóa lứa tuổi này?</p>
        <form id="delete-form" method="POST" action="index.php?page=lua-tuoi-list">
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
    $(document).ready(function () {
        $('#lua-tuoi-table').DataTable({
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