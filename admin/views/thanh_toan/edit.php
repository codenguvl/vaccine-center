<?php
require_once 'controllers/thanh_toan_controller.php';

$thanh_toan_controller = new ThanhToanController($conn);

$id = isset($_GET['id']) ? $_GET['id'] : null;
$thanh_toan = $thanh_toan_controller->getThanhToanById($id);

if (!$thanh_toan) {
    echo "Thanh toán không tồn tại.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $thanh_toan_controller->updateThanhToan(
        $id,
        $_POST['trang_thai'],
        $_POST['ngay_thanh_toan'],
        $_POST['ghi_chu']
    );

    if ($result) {
        header("Location: index.php?page=thanh-toan-list&message=edit_success");
        exit();
    } else {
        $error_message = "Có lỗi xảy ra khi cập nhật thanh toán!";
    }
}
?>

<?php if (isset($error_message)): ?>
<div class="uk-alert-danger" uk-alert>
    <a class="uk-alert-close" uk-close></a>
    <p><?php echo $error_message; ?></p>
</div>
<?php endif; ?>

<form class="uk-form-stacked" action="index.php?page=thanh-toan-edit&id=<?php echo $id; ?>" method="POST">
    <div class="uk-margin">
        <dl class="uk-description-list">
            <dt>Khách hàng:</dt>
            <dd><?php echo htmlspecialchars($thanh_toan['fullname']); ?></dd>

            <dt>Vaccine:</dt>
            <dd><?php echo htmlspecialchars($thanh_toan['ten_vaccine']); ?></dd>

            <dt>Ngày hẹn:</dt>
            <dd><?php echo htmlspecialchars($thanh_toan['ngay_hen']); ?></dd>

            <dt>Giá vaccine:</dt>
            <dd><?php echo number_format($thanh_toan['gia_tien'], 0, ',', '.'); ?> VNĐ</dd>

            <dt>Số tiền đã đặt cọc:</dt>
            <dd><?php echo number_format($thanh_toan['so_tien_dat_coc'], 0, ',', '.'); ?> VNĐ</dd>

            <dt>Số tiền cần thanh toán:</dt>
            <dd><?php echo number_format($thanh_toan['so_tien_con_lai'], 0, ',', '.'); ?> VNĐ</dd>
        </dl>
    </div>

    <div class="uk-margin">
        <label class="uk-form-label" for="trang_thai">Trạng thái:</label>
        <div class="uk-form-controls">
            <select class="uk-select" id="trang_thai" name="trang_thai" required
                <?php echo $thanh_toan['trang_thai'] == 'da_thanh_toan' ? 'disabled' : ''; ?>>
                <option value="chua_thanh_toan"
                    <?php echo $thanh_toan['trang_thai'] == 'chua_thanh_toan' ? 'selected' : ''; ?>>
                    Chưa thanh toán
                </option>
                <option value="da_thanh_toan"
                    <?php echo $thanh_toan['trang_thai'] == 'da_thanh_toan' ? 'selected' : ''; ?>>
                    Đã thanh toán
                </option>
            </select>
        </div>
    </div>

    <div class="uk-margin">
        <label class="uk-form-label" for="ngay_thanh_toan">Ngày thanh toán:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="ngay_thanh_toan" name="ngay_thanh_toan" type="date"
                value="<?php echo $thanh_toan['ngay_thanh_toan'] ?? ''; ?>"
                <?php echo $thanh_toan['trang_thai'] == 'da_thanh_toan' ? 'disabled' : ''; ?>>
        </div>
    </div>

    <div class="uk-margin">
        <label class="uk-form-label" for="ghi_chu">Ghi chú:</label>
        <div class="uk-form-controls">
            <textarea class="uk-textarea" id="ghi_chu" name="ghi_chu" rows="3"
                <?php echo $thanh_toan['trang_thai'] == 'da_thanh_toan' ? 'disabled' : ''; ?>><?php echo htmlspecialchars($thanh_toan['ghi_chu'] ?? ''); ?></textarea>
        </div>
    </div>

    <div class="uk-margin">
        <?php if ($thanh_toan['trang_thai'] != 'da_thanh_toan'): ?>
        <button class="uk-button uk-button-primary" type="submit">Cập nhật thanh toán</button>
        <?php endif; ?>
        <a class="uk-button uk-button-default" href="index.php?page=thanh-toan-list">Quay lại</a>
    </div>
</form>

<?php if ($thanh_toan['trang_thai'] == 'da_thanh_toan'): ?>
<!-- Hiển thị thông tin lịch tiêm nếu đã được tạo -->
<?php
                    require_once 'controllers/lich_tiem_controller.php';
                    $lich_tiem_controller = new LichTiemController($conn);
                    $lich_tiem = $lich_tiem_controller->getLichTiemByLichHen($thanh_toan['lich_hen_id']);
                    ?>

<?php if ($lich_tiem): ?>
<div class="uk-margin-large-top">
    <h3>Thông tin lịch tiêm</h3>
    <div class="uk-card uk-card-default uk-card-body">
        <dl class="uk-description-list">
            <dt>Ngày tiêm:</dt>
            <dd><?php echo htmlspecialchars($lich_tiem['ngay_tiem']); ?></dd>

            <dt>Lần tiêm:</dt>
            <dd><?php echo htmlspecialchars($lich_tiem['lan_tiem']); ?></dd>

            <dt>Trạng thái:</dt>
            <dd>
                <?php
                                        $status_class = '';
                                        $status_text = '';
                                        switch ($lich_tiem['trang_thai']) {
                                            case 'cho_tiem':
                                                $status_class = 'uk-label-warning';
                                                $status_text = 'Chờ tiêm';
                                                break;
                                            case 'da_tiem':
                                                $status_class = 'uk-label-success';
                                                $status_text = 'Đã tiêm';
                                                break;
                                            case 'huy':
                                                $status_class = 'uk-label-danger';
                                                $status_text = 'Hủy';
                                                break;
                                        }
                                        ?>
                <span class="uk-label <?php echo $status_class; ?>"><?php echo $status_text; ?></span>
            </dd>

            <?php if ($lich_tiem['ghi_chu']): ?>
            <dt>Ghi chú:</dt>
            <dd><?php echo htmlspecialchars($lich_tiem['ghi_chu']); ?></dd>
            <?php endif; ?>
        </dl>

        <div class="uk-margin">
            <a href="index.php?page=lich-tiem-edit&id=<?php echo $lich_tiem['lich_tiem_id']; ?>"
                class="uk-button uk-button-primary uk-button-small">
                Cập nhật lịch tiêm
            </a>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Hiển thị lịch sử thanh toán -->
<div class="uk-margin-large-top">
    <h3>Lịch sử thanh toán</h3>
    <div class="uk-card uk-card-default uk-card-body">
        <table class="uk-table uk-table-small uk-table-divider">
            <thead>
                <tr>
                    <th>Ngày</th>
                    <th>Loại</th>
                    <th>Số tiền</th>
                    <th>Ghi chú</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo htmlspecialchars($thanh_toan['ngay_dat_coc'] ?? '---'); ?></td>
                    <td>Đặt cọc</td>
                    <td><?php echo number_format($thanh_toan['so_tien_dat_coc'], 0, ',', '.'); ?> VNĐ</td>
                    <td>Đặt cọc vaccine</td>
                </tr>
                <tr>
                    <td><?php echo htmlspecialchars($thanh_toan['ngay_thanh_toan']); ?></td>
                    <td>Thanh toán số tiền còn lại</td>
                    <td><?php echo number_format($thanh_toan['so_tien_con_lai'], 0, ',', '.'); ?> VNĐ</td>
                    <td><?php echo htmlspecialchars($thanh_toan['ghi_chu'] ?? ''); ?></td>
                </tr>
                <tr class="uk-text-bold">
                    <td colspan="2">Tổng cộng:</td>
                    <td><?php echo number_format($thanh_toan['gia_tien'], 0, ',', '.'); ?> VNĐ</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tự động điền ngày thanh toán khi chọn trạng thái đã thanh toán
    const trangThaiSelect = document.getElementById('trang_thai');
    const ngayThanhToanInput = document.getElementById('ngay_thanh_toan');

    trangThaiSelect.addEventListener('change', function() {
        if (this.value === 'da_thanh_toan' && !ngayThanhToanInput.value) {
            const today = new Date().toISOString().split('T')[0];
            ngayThanhToanInput.value = today;
        }
    });

    // Yêu cầu ngày thanh toán khi chọn trạng thái đã thanh toán
    const form = document.querySelector('form');
    form.addEventListener('submit', function(event) {
        if (trangThaiSelect.value === 'da_thanh_toan' && !ngayThanhToanInput.value) {
            event.preventDefault();
            UIkit.notification({
                message: 'Vui lòng chọn ngày thanh toán',
                status: 'danger'
            });
        }
    });
});
</script>