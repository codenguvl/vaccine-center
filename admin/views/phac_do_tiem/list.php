<?php
require_once 'controllers/phac_do_tiem_controller.php';
$phac_do_tiem_controller = new PhacDoTiemController($conn);
$phac_do_list = $phac_do_tiem_controller->getAllPhacDoTiem();

if (isset($_POST['action']) && $_POST['action'] == 'delete' && isset($_POST['id'])) {
    $result = $phac_do_tiem_controller->deletePhacDoTiem($_POST['id']);
    if ($result) {
        $success_message = "Xóa phác đồ tiêm thành công.";
        $phac_do_list = $phac_do_tiem_controller->getAllPhacDoTiem();
    } else {
        $error_message = "Có lỗi xảy ra khi xóa phác đồ tiêm.";
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

<a href="index.php?page=phac-do-tiem-add" class="uk-button uk-button-primary uk-margin-bottom">Thêm Phác đồ tiêm mới</a>

<table id="phac-do-table" class="uk-table uk-table-hover uk-table-striped">
    <thead>
        <tr>
            <th>Tên phác đồ</th>
            <th>Lứa tuổi</th>
            <th>Liều lượng</th>
            <th>Lịch tiêm</th>
            <th>Liều nhắc</th>
            <th>Ghi chú</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($phac_do_list as $phac_do): ?>
            <tr>
                <td><?php echo isset($phac_do['ten_phac_do']) ? htmlspecialchars($phac_do['ten_phac_do']) : ''; ?></td>
                <td><?php echo isset($phac_do['lua_tuoi_mo_ta']) ? htmlspecialchars($phac_do['lua_tuoi_mo_ta']) : ''; ?>
                </td>
                <td><?php echo isset($phac_do['lieu_luong_mo_ta']) ? htmlspecialchars($phac_do['lieu_luong_mo_ta']) : ''; ?>
                </td>
                <td><?php echo isset($phac_do['lich_tiem']) ? nl2br(htmlspecialchars($phac_do['lich_tiem'])) : ''; ?></td>
                <td><?php echo isset($phac_do['lieu_nhac']) ? nl2br(htmlspecialchars($phac_do['lieu_nhac'])) : ''; ?></td>
                <td><?php echo isset($phac_do['ghi_chu']) ? nl2br(htmlspecialchars($phac_do['ghi_chu'])) : ''; ?></td>
                <td>
                    <a href="index.php?page=phac-do-tiem-edit&id=<?php echo isset($phac_do['phac_do_id']) ? htmlspecialchars($phac_do['phac_do_id']) : ''; ?>"
                        class="uk-button uk-button-primary uk-button-small">Sửa</a>
                    <button class="uk-button uk-button-danger uk-button-small"
                        onclick="openDeleteModal('<?php echo isset($phac_do['phac_do_id']) ? htmlspecialchars($phac_do['phac_do_id']) : ''; ?>')">Xóa</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Modal xác nhận xóa -->
<div id="delete-modal" class="uk-modal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title">Xác nhận xóa</h2>
        <p>Bạn có chắc chắn muốn xóa phác đồ tiêm này?</p>
        <form id="delete-form" method="POST" action="index.php?page=phac-do-tiem-list">
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
        $('#phac-do-table').DataTable({
            "language": {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/vi.json' // Đổi ngôn ngữ sang tiếng Việt
            },
            "ordering": true, // cho phép sắp xếp cột
            "searching": true, // hiển thị hộp tìm kiếm
            "paging": true, // cho phép phân trang
            "lengthChange": true, // cho phép điều chỉnh số lượng hàng trên mỗi trang
            "pageLength": 10 // số lượng hàng hiển thị mỗi trang
        });
    });
</script>