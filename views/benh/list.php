<?php
require_once 'controllers/benh_controller.php';
$benh_controller = new BenhController($conn);
$benh_list = $benh_controller->getAllBenh();

if (isset($_POST['action']) && $_POST['action'] == 'delete' && isset($_POST['id'])) {
    $result = $benh_controller->deleteBenh($_POST['id']);
    if ($result) {
        $success_message = "Xóa bệnh thành công.";
        $benh_list = $benh_controller->getAllBenh();
    } else {
        $error_message = "Có lỗi xảy ra khi xóa bệnh.";
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

<a href="index.php?page=benh-add" class="uk-button uk-button-primary uk-margin-bottom">Thêm Bệnh mới</a>

<table id="benh-table" class="uk-table uk-table-hover uk-table-striped">
    <thead>
        <tr>
            <th>Tên bệnh</th>
            <th>Danh mục</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($benh_list as $benh): ?>
            <tr>
                <td><?php echo htmlspecialchars($benh['ten_benh']); ?></td>
                <td><?php echo htmlspecialchars($benh['ten_danh_muc']); ?></td>
                <td>
                    <a href="index.php?page=benh-edit&id=<?php echo htmlspecialchars($benh['benh_id']); ?>"
                        class="uk-button uk-button-primary uk-button-small">Sửa</a>
                    <button class="uk-button uk-button-danger uk-button-small"
                        onclick="openDeleteModal('<?php echo htmlspecialchars($benh['benh_id']); ?>')">Xóa</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<!-- Modal xác nhận xóa -->
<div id="delete-modal" class="uk-modal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title">Xác nhận xóa</h2>
        <p>Bạn có chắc chắn muốn xóa bệnh này?</p>
        <form id="delete-form" method="POST" action="index.php?page=benh-list">
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
        // Khởi tạo DataTable cho bảng Bệnh
        $('#benh-table').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/vi.json' // Đổi ngôn ngữ sang tiếng Việt
            },
            pageLength: 10, // Số dòng mặc định mỗi trang
            responsive: true // Đáp ứng giao diện
        });
    });

    // Xử lý modal xóa
    function openDeleteModal(id) {
        document.getElementById('delete-id').value = id;
        UIkit.modal('#delete-modal').show();
    }
</script>