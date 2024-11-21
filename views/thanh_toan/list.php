<?php
require_once 'controllers/thanh_toan_controller.php';
$thanh_toan_controller = new ThanhToanController($conn);
$thanh_toan_list = $thanh_toan_controller->getAllThanhToan();

if (isset($_POST['action']) && $_POST['action'] == 'update_status') {
    $result = $thanh_toan_controller->xuLyThanhToan($_POST['id']);
    if ($result) {
        $success_message = "Cập nhật trạng thái thanh toán thành công.";
        $thanh_toan_list = $thanh_toan_controller->getAllThanhToan();
    } else {
        $error_message = "Có lỗi xảy ra khi cập nhật trạng thái.";
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

<table id="thanh-toan-table" class="uk-table uk-table-hover uk-table-striped">
    <thead>
        <tr>
            <th>Khách hàng</th>
            <th>Vaccine</th>
            <th>Ngày hẹn</th>
            <th>Tiền vaccine</th>
            <th>Đã đặt cọc</th>
            <th>Còn lại</th>
            <th>Trạng thái</th>
            <th>Ngày thanh toán</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($thanh_toan_list as $thanh_toan): ?>
            <tr>
                <td><?php echo htmlspecialchars($thanh_toan['fullname']); ?></td>
                <td><?php echo htmlspecialchars($thanh_toan['ten_vaccine']); ?></td>
                <td><?php echo htmlspecialchars($thanh_toan['ngay_hen']); ?></td>
                <td><?php echo number_format($thanh_toan['gia_tien'], 0, ',', '.'); ?> VNĐ</td>
                <td><?php echo number_format($thanh_toan['so_tien_dat_coc'], 0, ',', '.'); ?> VNĐ</td>
                <td><?php echo number_format($thanh_toan['so_tien_con_lai'], 0, ',', '.'); ?> VNĐ</td>
                <td>
                    <?php
                    $status_class = $thanh_toan['trang_thai'] == 'da_thanh_toan' ? 'uk-label-success' : 'uk-label-warning';
                    $status_text = $thanh_toan['trang_thai'] == 'da_thanh_toan' ? 'Đã thanh toán' : 'Chưa thanh toán';
                    ?>
                    <span class="uk-label <?php echo $status_class; ?>"><?php echo $status_text; ?></span>
                </td>
                <td><?php echo $thanh_toan['ngay_thanh_toan'] ? htmlspecialchars($thanh_toan['ngay_thanh_toan']) : '---'; ?>
                </td>
                <td>
                    <?php if ($thanh_toan['trang_thai'] != 'da_thanh_toan'): ?>
                        <button class="uk-button uk-button-primary uk-button-small"
                            onclick="confirmPayment(<?php echo $thanh_toan['thanh_toan_id']; ?>)">
                            Xác nhận thanh toán
                        </button>
                    <?php endif; ?>
                    <a href="index.php?page=thanh-toan-edit&id=<?php echo $thanh_toan['thanh_toan_id']; ?>"
                        class="uk-button uk-button-secondary uk-button-small">Chi tiết</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Modal xác nhận thanh toán -->
<div id="confirm-payment-modal" class="uk-modal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title">Xác nhận thanh toán</h2>
        <p>Bạn có chắc chắn muốn xác nhận thanh toán này?</p>
        <form id="payment-form" method="POST">
            <input type="hidden" name="action" value="update_status">
            <input type="hidden" name="id" id="payment-id" value="">
            <p class="uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close" type="button">Hủy</button>
                <button class="uk-button uk-button-primary" type="submit">Xác nhận</button>
            </p>
        </form>
    </div>
</div>

<script>
    function confirmPayment(id) {
        document.getElementById('payment-id').value = id;
        UIkit.modal('#confirm-payment-modal').show();
    }
    $(document).ready(function () {
        $('#thanh-toan-table').DataTable({
            "language": {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/vi.json' // Đổi ngôn ngữ sang tiếng Việt
            },
            "paging": true,
            "searching": true,
            "ordering": true,
            "order": [
                [0, 'asc']
            ], // Default sort by first column
            "lengthChange": true
        });
    });
</script>