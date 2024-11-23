<?php
ob_start();
require_once __DIR__ . '/admin/controllers/lich_hen_controller.php';
require_once __DIR__ . '/admin/controllers/lich_tiem_controller.php';
require_once __DIR__ . '/admin/controllers/dat_coc_controller.php';
require_once __DIR__ . '/admin/controllers/khachhang_controller.php';
?>

<!DOCTYPE html>
<htm lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard</title>
        <!-- UIkit CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/css/uikit.min.css" />

        <!-- UIkit JS -->
        <script src="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/js/uikit.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/js/uikit-icons.min.js"></script>

        <!-- Font icon -->
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

        <!-- Notification -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

        <!-- Google font -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Mona+Sans:ital,wght@0,200..900;1,200..900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
            rel="stylesheet">

        <!-- Import css -->
        <link rel="stylesheet" href="./static/css/reset.css">
        <link rel="stylesheet" href="./static/css/main.css">
        <!-- Alert -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

        <!-- DataTables -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


    </head>

    <body>

        <?php include('includes/partials/header.php') ?>

        <div class="uk-container">
            <h1 class="uk-heading-small uk-text-center">Tra Cứu Thông Tin Khách Hàng</h1>
            <form method="POST"
                class="uk-margin-bottom uk-card uk-card-body uk-card-default uk-width-2xlarge uk-margin-auto">
                <div class="uk-margin">
                    <input class="uk-input" type="text" name="phoneOrCCCD" placeholder="Số Điện Thoại hoặc CCCD"
                        required>
                </div>
                <button class="uk-button uk-button-primary uk-align-center uk-width-1-1" type="submit">Tra Cứu</button>
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $phoneOrCCCD = trim($_POST['phoneOrCCCD']);

                    $khachHangController = new KhachHangController($conn);
                    $khachHang = $khachHangController->getKhachHangByPhoneOrCCCD($phoneOrCCCD);

                    if (!$khachHang) {
                        echo '<div class="uk-alert-warning" uk-alert>
                        <p>Khách hàng này chưa có lịch sử trong hệ thống.</p>
                      </div>';
                    } else {
                        echo '<div class="uk-card uk-card-default uk-card-body uk-margin">';
                        echo '<h3 class="uk-card-title">Thông tin khách hàng</h3>';
                        echo '<dl class="uk-description-list">';
                        echo '<dt>Họ và tên:</dt><dd>' . htmlspecialchars($khachHang['fullname']) . '</dd>';
                        echo '<dt>CCCD:</dt><dd>' . htmlspecialchars($khachHang['cccd']) . '</dd>';
                        echo '<dt>Điện thoại:</dt><dd>' . htmlspecialchars($khachHang['dienthoai']) . '</dd>';
                        echo '<dt>Địa chỉ:</dt><dd>' . htmlspecialchars($khachHang['diachi']) . '</dd>';
                        echo '</dl>';
                        echo '</div>';

                        $lichHenController = new LichHenController($conn);
                        $lichTiemController = new LichTiemController($conn);
                        $datCocController = new DatCocController($conn);

                        $lichHens = $lichHenController->getLichHenByPhoneOrCCCD($phoneOrCCCD);
                        $lichTiems = $lichTiemController->getLichTiemByPhoneOrCCCD($phoneOrCCCD);
                        $datCocs = $datCocController->getDatCocByPhoneOrCCCD($phoneOrCCCD);

                        if (!empty($lichHens)) {
                            // Tạo mảng ánh xạ trạng thái
                            $trangThaiMapping = [
                                'cho_xac_nhan' => 'Chờ xác nhận',
                                'da_xac_nhan' => 'Đã xác nhận',
                                'da_huy' => 'Đã hủy',
                                'hoan_thanh' => 'Hoàn thành'
                            ];

                            echo '<div class="uk-card uk-card-default uk-card-body uk-margin">';
                            echo '<h3 class="uk-card-title">Lịch Hẹn</h3>';
                            echo '<table class="uk-table uk-table-divider">';
                            echo '<thead><tr><th>Ngày</th><th>Giờ</th><th>Trạng thái</th></tr></thead><tbody>';

                            foreach ($lichHens as $lichHen) {
                                echo '<tr>';
                                echo '<td>' . htmlspecialchars($lichHen['ngay_hen']) . '</td>';
                                echo '<td>' . htmlspecialchars($lichHen['gio_bat_dau']) . '</td>';

                                // Kiểm tra trạng thái và lấy giá trị tiếng Việt
                                $trangThai = isset($trangThaiMapping[$lichHen['trang_thai']])
                                    ? $trangThaiMapping[$lichHen['trang_thai']]
                                    : 'Không xác định';
                                echo '<td>' . htmlspecialchars($trangThai) . '</td>';

                                echo '</tr>';
                            }

                            echo '</tbody></table></div>';
                        }


                        if (!empty($lichTiems)) {
                            // Tạo mảng ánh xạ trạng thái
                            $trangThaiMapping = [
                                'cho_tiem' => 'Chờ tiêm',
                                'da_tiem' => 'Đã tiêm',
                                'huy' => 'Hủy'
                            ];

                            echo '<div class="uk-card uk-card-default uk-card-body uk-margin">';
                            echo '<h3 class="uk-card-title">Lịch Tiêm</h3>';
                            echo '<table class="uk-table uk-table-divider">';
                            echo '<thead><tr><th>Ngày Tiêm</th><th>Vaccine</th><th>Trạng Thái</th></tr></thead><tbody>';

                            foreach ($lichTiems as $lichTiem) {
                                echo '<tr>';
                                echo '<td>' . htmlspecialchars($lichTiem['ngay_tiem']) . '</td>';
                                echo '<td>' . htmlspecialchars($lichTiem['ten_vaccine']) . '</td>';

                                // Kiểm tra trạng thái và lấy giá trị tiếng Việt
                                $trangThai = isset($trangThaiMapping[$lichTiem['trang_thai']])
                                    ? $trangThaiMapping[$lichTiem['trang_thai']]
                                    : 'Không xác định';
                                echo '<td>' . htmlspecialchars($trangThai) . '</td>';

                                echo '</tr>';
                            }

                            echo '</tbody></table></div>';
                        }


                        if (!empty($datCocs)) {
                            echo '<div class="uk-card uk-card-default uk-card-body uk-margin">';
                            echo '<h3 class="uk-card-title">Đặt Cọc</h3>';
                            echo '<table class="uk-table uk-table-divider">';
                            echo '<thead><tr><th>Tên Vaccine</th><th>Số Tiền</th><th>Ngày Đặt</th></tr></thead><tbody>';
                            foreach ($datCocs as $datCoc) {
                                echo '<tr>';
                                echo '<td>' . htmlspecialchars($datCoc['ten_vaccine']) . '</td>';
                                echo '<td>' . htmlspecialchars($datCoc['so_tien_dat_coc']) . '</td>';
                                echo '<td>' . htmlspecialchars($datCoc['ngay_dat_coc']) . '</td>';
                                echo '</tr>';
                            }
                            echo '</tbody></table></div>';
                        }
                    }
                }
                ?>
            </form>


        </div>
        <!-- Footer -->
        <?php include('includes/partials/footer.php') ?>
    </body>

    </html>