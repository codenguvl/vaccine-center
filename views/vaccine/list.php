<?php
require_once 'controllers/vaccine_controller.php';
$vaccine_controller = new VaccineController($conn);
$vaccine_list = $vaccine_controller->getAllVaccine();

if (isset($_POST['action']) && $_POST['action'] == 'delete' && isset($_POST['id'])) {
    $result = $vaccine_controller->deleteVaccine($_POST['id']);
    if ($result) {
        $success_message = "Xóa vaccine thành công.";
        $vaccine_list = $vaccine_controller->getAllVaccine();
    } else {
        $error_message = "Có lỗi xảy ra khi xóa vaccine.";
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

<a href="index.php?page=vaccine-add" class="uk-button uk-button-primary uk-margin-bottom">Thêm Vaccine mới</a>

<table class="uk-table uk-table-hover uk-table-striped" id="vaccine-table">
    <thead>
        <tr>
            <th>Tên vaccine</th>
            <th>Nhà SX</th>
            <th>Loại</th>
            <th>Số lô</th>
            <th>NSX</th>
            <th>HSD</th>
            <th>Giá tiền</th>
            <th>Số lượng</th>
            <th>Bệnh</th>
            <th>Đối tượng</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($vaccine_list as $vaccine): ?>
            <tr>
                <td><?php echo htmlspecialchars($vaccine['ten_vaccine']); ?></td>
                <td><?php echo htmlspecialchars($vaccine['nha_san_xuat']); ?></td>
                <td><?php echo htmlspecialchars($vaccine['loai_vaccine']); ?></td>
                <td><?php echo htmlspecialchars($vaccine['so_lo_san_xuat']); ?></td>
                <td><?php echo htmlspecialchars($vaccine['ngay_san_xuat']); ?></td>
                <td><?php echo htmlspecialchars($vaccine['han_su_dung']); ?></td>
                <td><?php echo number_format($vaccine['gia_tien'], 0, ',', '.'); ?> đ</td>
                <td><?php echo htmlspecialchars($vaccine['so_luong']); ?></td>
                <td><?php echo htmlspecialchars($vaccine['ten_benh']); ?></td>
                <td><?php echo htmlspecialchars($vaccine['ten_doi_tuong']); ?></td>
                <td>
                    <a href="index.php?page=vaccine-edit&id=<?php echo htmlspecialchars($vaccine['vaccin_id']); ?>"
                        class="uk-button uk-button-primary uk-button-small">Sửa</a>
                    <button class="uk-button uk-button-danger uk-button-small"
                        onclick="openDeleteModal('<?php echo htmlspecialchars($vaccine['vaccin_id']); ?>')">Xóa</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Modal xác nhận xóa -->
<div id="delete-modal" class="uk-modal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title">Xác nhận xóa</h2>
        <p>Bạn có chắc chắn muốn xóa vaccine này?</p>
        <form id="delete-form" method="POST" action="index.php?page=vaccine-list">
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
        $('#vaccine-table').DataTable({
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