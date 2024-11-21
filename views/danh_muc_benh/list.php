<?php
require_once 'controllers/danh_muc_benh_controller.php';
$danh_muc_benh_controller = new DanhMucBenhController($conn);
$danh_muc_benh_list = $danh_muc_benh_controller->getAllDanhMucBenh();

if (isset($_POST['action']) && $_POST['action'] == 'delete' && isset($_POST['id'])) {
    $result = $danh_muc_benh_controller->deleteDanhMucBenh($_POST['id']);
    if ($result) {
        $success_message = "Xóa danh mục bệnh thành công.";
        $danh_muc_benh_list = $danh_muc_benh_controller->getAllDanhMucBenh();
    } else {
        $error_message = "Có lỗi xảy ra khi xóa danh mục bệnh.";
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

<a href="index.php?page=danh-muc-benh-add" class="uk-button uk-button-primary uk-margin-bottom">Thêm Danh mục bệnh
    mới</a>

<table id="danh-muc-benh-table" class="uk-table uk-table-hover uk-table-striped">
    <thead>
        <tr>
            <th>Tên danh mục</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($danh_muc_benh_list as $danh_muc): ?>
            <tr>
                <td><?php echo htmlspecialchars($danh_muc['ten_danh_muc']); ?></td>
                <td>
                    <a href="index.php?page=danh-muc-benh-edit&id=<?php echo htmlspecialchars($danh_muc['danh_muc_id']); ?>"
                        class="uk-button uk-button-primary uk-button-small">Sửa</a>
                    <button class="uk-button uk-button-danger uk-button-small"
                        onclick="openDeleteModal('<?php echo htmlspecialchars($danh_muc['danh_muc_id']); ?>')">Xóa</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<!-- Modal xác nhận xóa -->
<div id="delete-modal" class="uk-modal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title">Xác nhận xóa</h2>
        <p>Bạn có chắc chắn muốn xóa danh mục bệnh này?</p>
        <form id="delete-form" method="POST" action="index.php?page=danh-muc-benh-list">
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
        // Khởi tạo DataTable cho bảng Danh mục bệnh
        $('#danh-muc-benh-table').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/vi.json' // Ngôn ngữ tiếng Việt
            },
            pageLength: 10, // Số dòng hiển thị mặc định mỗi trang
            responsive: true // Giao diện phản hồi
        });
    });

    // Xử lý mở modal xác nhận xóa
    function openDeleteModal(id) {
        document.getElementById('delete-id').value = id;
        UIkit.modal('#delete-modal').show();
    }
</script>