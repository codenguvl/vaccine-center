<?php
require_once 'controllers/khachhang_controller.php';
require_once 'controllers/lich_tiem_controller.php';
require_once 'controllers/lich_hen_controller.php';
require_once 'controllers/thanh_toan_controller.php';
require_once 'controllers/dat_coc_controller.php';

$khachhang_id = isset($_GET['id']) ? $_GET['id'] : null;

$khachhang_controller = new KhachHangController($conn);
$lich_tiem_controller = new LichTiemController($conn);
$lich_hen_controller = new LichHenController($conn);
$thanh_toan_controller = new ThanhToanController($conn);
$dat_coc_controller = new DatCocController($conn);

$khachhang = $khachhang_controller->getKhachHangById($khachhang_id);

if (!$khachhang) {
    echo "Không tìm thấy thông tin khách hàng.";
    exit;
}
?>

<div class="uk-container">
    <h2 class="uk-heading-divider">Lịch sử khách hàng: <?php echo htmlspecialchars($khachhang['fullname']); ?></h2>

    <!-- Thông tin cơ bản -->
    <div class="uk-card uk-card-default uk-card-body uk-margin">
        <h3 class="uk-card-title">Thông tin khách hàng</h3>
        <dl class="uk-description-list">
            <dt>Họ và tên:</dt>
            <dd><?php echo htmlspecialchars($khachhang['fullname']); ?></dd>

            <dt>CCCD:</dt>
            <dd><?php echo htmlspecialchars($khachhang['cccd']); ?></dd>

            <dt>Ngày sinh:</dt>
            <dd><?php echo htmlspecialchars($khachhang['ngaysinh']); ?></dd>

            <dt>Điện thoại:</dt>
            <dd><?php echo htmlspecialchars($khachhang['dienthoai']); ?></dd>

            <dt>Địa chỉ:</dt>
            <dd><?php echo htmlspecialchars($khachhang['diachi']); ?></dd>
        </dl>
    </div>

    <!-- Lịch sử tiêm -->
    <div class="uk-card uk-card-default uk-card-body uk-margin">
        <h3 class="uk-card-title">Lịch sử tiêm chủng</h3>
        <table class="uk-table uk-table-striped">
            <thead>
                <tr>
                    <th>Ngày tiêm</th>
                    <th>Vaccine</th>
                    <th>Lần tiêm</th>
                    <th>Trạng thái</th>
                    <th>Ghi chú</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $lich_tiem_list = $lich_tiem_controller->getAllLichTiem();
                foreach ($lich_tiem_list as $lich_tiem):
                    if (isset($lich_tiem['khachhang_id']) && $lich_tiem['khachhang_id'] == $khachhang_id):
                        ?>
                <tr>
                    <td><?php echo isset($lich_tiem['ngay_tiem']) ? htmlspecialchars($lich_tiem['ngay_tiem']) : ''; ?>
                    </td>
                    <td><?php echo isset($lich_tiem['ten_vaccine']) ? htmlspecialchars($lich_tiem['ten_vaccine']) : ''; ?>
                    </td>
                    <td><?php echo isset($lich_tiem['lan_tiem']) ? htmlspecialchars($lich_tiem['lan_tiem']) : ''; ?>
                    </td>
                    <td>
                        <span
                            class="uk-badge uk-badge-<?php echo isset($lich_tiem['trang_thai']) && $lich_tiem['trang_thai'] == 'da_tiem' ? 'success' : 'warning'; ?>">
                            <?php echo isset($lich_tiem['trang_thai']) && $lich_tiem['trang_thai'] == 'da_tiem' ? 'Đã tiêm' : 'Chờ tiêm'; ?>
                        </span>
                    </td>
                    <td><?php echo isset($lich_tiem['ghi_chu']) ? htmlspecialchars($lich_tiem['ghi_chu']) : ''; ?></td>
                </tr>
                <?php
                    endif;
                endforeach;
                ?>
            </tbody>
        </table>
    </div>


    <!-- Lịch sử đặt hẹn -->
    <div class="uk-card uk-card-default uk-card-body uk-margin">
        <h3 class="uk-card-title">Lịch sử đặt hẹn</h3>
        <table class="uk-table uk-table-striped">
            <thead>
                <tr>
                    <th>Ngày hẹn</th>
                    <th>Giờ hẹn</th>
                    <th>Trạng thái</th>
                    <th>Ghi chú</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $lich_hen_list = $lich_hen_controller->getAllLichHen();
                foreach ($lich_hen_list as $lich_hen):
                    if ($lich_hen['khachhang_id'] == $khachhang_id):
                        ?>
                <tr>
                    <td><?php echo htmlspecialchars($lich_hen['ngay_hen']); ?></td>
                    <td><?php echo htmlspecialchars($lich_hen['gio_bat_dau']); ?></td>
                    <td>
                        <span class="uk-badge">
                            <?php echo htmlspecialchars($lich_hen['trang_thai']); ?>
                        </span>
                    </td>
                    <td><?php echo htmlspecialchars($lich_hen['ghi_chu']); ?></td>
                </tr>
                <?php
                    endif;
                endforeach;
                ?>
            </tbody>
        </table>
    </div>

    <!-- Lịch sử thanh toán -->
    <div class="uk-card uk-card-default uk-card-body uk-margin">
        <h3 class="uk-card-title">Lịch sử thanh toán</h3>
        <table class="uk-table uk-table-striped">
            <thead>
                <tr>
                    <th>Ngày thanh toán</th>
                    <th>Số tiền</th>
                    <th>Trạng thái</th>
                    <th>Ghi chú</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $lich_hen_list = $lich_hen_controller->getAllLichHen();
                foreach ($lich_hen_list as $lich_hen):
                    if ($lich_hen['khachhang_id'] == $khachhang_id):
                        $thanh_toan = $thanh_toan_controller->getThanhToanByLichHen($lich_hen['lich_hen_id']);
                        if ($thanh_toan):
                            ?>
                <tr>
                    <td><?php echo isset($thanh_toan['ngay_thanh_toan']) ? htmlspecialchars($thanh_toan['ngay_thanh_toan']) : ''; ?>
                    </td>
                    <td><?php echo isset($thanh_toan['so_tien_con_lai']) ? number_format($thanh_toan['so_tien_con_lai'], 0, ',', '.') . ' VNĐ' : ''; ?>
                    </td>
                    <td>
                        <span class="uk-badge">
                            <?php echo isset($thanh_toan['trang_thai']) ? htmlspecialchars($thanh_toan['trang_thai']) : ''; ?>
                        </span>
                    </td>
                    <td><?php echo isset($thanh_toan['ghi_chu']) ? htmlspecialchars($thanh_toan['ghi_chu']) : ''; ?>
                    </td>
                </tr>
                <?php
                        endif;
                    endif;
                endforeach;
                ?>
            </tbody>
        </table>
    </div>


    <!-- Lịch sử đặt cọc -->
    <div class="uk-card uk-card-default uk-card-body uk-margin">
        <h3 class="uk-card-title">Lịch sử đặt cọc</h3>
        <table class="uk-table uk-table-striped">
            <thead>
                <tr>
                    <th>Ngày đặt cọc</th>
                    <th>Vaccine</th>
                    <th>Số tiền đặt cọc</th>
                    <th>Trạng thái</th>
                    <th>Ghi chú</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $lich_hen_list = $lich_hen_controller->getAllLichHen();
                foreach ($lich_hen_list as $lich_hen):
                    if ($lich_hen['khachhang_id'] == $khachhang_id && isset($lich_hen['dat_coc_id'])):
                        $dat_coc = $dat_coc_controller->getDatCocById($lich_hen['dat_coc_id']);
                        if ($dat_coc):
                            ?>
                <tr>
                    <td><?php echo isset($dat_coc['ngay_dat_coc']) ? htmlspecialchars($dat_coc['ngay_dat_coc']) : ''; ?>
                    </td>
                    <td><?php echo isset($dat_coc['ten_vaccine']) ? htmlspecialchars($dat_coc['ten_vaccine']) : ''; ?>
                    </td>
                    <td><?php echo isset($dat_coc['so_tien_dat_coc']) ? number_format($dat_coc['so_tien_dat_coc'], 0, ',', '.') . ' VNĐ' : ''; ?>
                    </td>
                    <td>
                        <span class="uk-badge">
                            <?php echo isset($dat_coc['trang_thai']) ? htmlspecialchars($dat_coc['trang_thai']) : ''; ?>
                        </span>
                    </td>
                    <td><?php echo isset($dat_coc['ghi_chu']) ? htmlspecialchars($dat_coc['ghi_chu']) : ''; ?></td>
                </tr>
                <?php
                        endif;
                    endif;
                endforeach;
                ?>
            </tbody>
        </table>
    </div>


    <div class="uk-margin">
        <a href="index.php?page=khach-hang-list" class="uk-button uk-button-default">Quay lại danh sách</a>
    </div>
</div>

<style>
.uk-badge {
    padding: 5px 10px;
    border-radius: 3px;
}

.uk-badge-success {
    background-color: #32d296;
}

.uk-badge-warning {
    background-color: #faa05a;
}
</style>