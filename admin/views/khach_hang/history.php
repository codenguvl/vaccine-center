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
        <h3 class="uk-card-title uk-margin-bottom">Thông tin khách hàng</h3>
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

    <div class="uk-card uk-card-default uk-card-body uk-margin">
        <h3 class="uk-card-title uk-margin-bottom">Lịch sử tiêm chủng</h3>
        <table id="lich_tiem_table" class="uk-table uk-table-striped">
            <thead>
                <tr>
                    <th>Ngày tiêm</th>
                    <th>Vaccine</th>
                    <th>Lần tiêm</th>
                    <th>Trạng thái</th>
                    <th>Bệnh</th> <!-- Thêm cột Bệnh -->
                </tr>
            </thead>
            <tbody>
                <?php
                $lich_tiem_list = $lich_tiem_controller->getAllLichTiemByKhachHangId($khachhang_id); // Sử dụng phương thức mới
                foreach ($lich_tiem_list as $lich_tiem):
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
                        <td><?php echo isset($lich_tiem['ten_benh']) ? htmlspecialchars($lich_tiem['ten_benh']) : ''; ?>
                        </td>
                        <!-- Hiển thị tên bệnh -->
                    </tr>
                    <?php
                endforeach;
                ?>
            </tbody>
        </table>
    </div>


    <!-- Lịch sử đặt hẹn -->
    <div class="uk-card uk-card-default uk-card-body uk-margin">
        <h3 class="uk-card-title uk-margin-bottom">Lịch sử đặt hẹn</h3>
        <table id="lich_hen_table" class="uk-table uk-table-striped">
            <thead>
                <tr>
                    <th>Ngày hẹn</th>
                    <th>Giờ hẹn</th>
                    <th>Trạng thái</th>
                    <!-- <th>Ghi chú</th> -->
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
                                    <?php
                                    // Hiển thị trạng thái lịch hẹn bằng tiếng Việt
                                    switch (htmlspecialchars($lich_hen['trang_thai'])) {
                                        case 'cho_xac_nhan':
                                            echo 'Chờ xác nhận';
                                            break;
                                        case 'da_xac_nhan':
                                            echo 'Đã xác nhận';
                                            break;
                                        case 'da_huy':
                                            echo 'Đã hủy';
                                            break;
                                        case 'hoan_thanh':
                                            echo 'Hoàn thành';
                                            break;
                                        default:
                                            echo 'Không xác định';
                                    }
                                    ?>
                                </span>
                            </td>

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
        <h3 class="uk-card-title uk-margin-bottom">Lịch sử thanh toán</h3>
        <table id="lich_thanh_toan_table" class="uk-table uk-table-striped">
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
                                        <?php
                                        // Hiển thị trạng thái thanh toán bằng tiếng Việt
                                        echo isset($thanh_toan['trang_thai']) ?
                                            (htmlspecialchars($thanh_toan['trang_thai']) == 'da_thanh_toan' ? 'Đã thanh toán' : 'Chưa thanh toán') : '';
                                        ?>
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
        <h3 class="uk-card-title uk-margin-bottom">Lịch sử đặt cọc</h3>
        <table id="lich_dat_coc_table" class="uk-table uk-table-striped">
            <thead>
                <tr>
                    <th>Ngày đặt cọc</th>
                    <th>Vaccine</th>
                    <th>Số tiền đặt cọc</th>
                    <!-- <th>Ghi chú</th> -->
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


                            </tr>
                            <?php
                        endif;
                    endif;
                endforeach;
                ?>
            </tbody>
        </table>
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

<script>
    $(document).ready(function () {
        $('#lich_tiem_table').DataTable();
        $('#lich_hen_table').DataTable();
        $('#lich_thanh_toan_table').DataTable();
        $('#lich_dat_coc_table').DataTable();
    });
</script>