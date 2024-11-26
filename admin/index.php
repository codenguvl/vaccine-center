<?php
ob_start();
require_once __DIR__ . '/config/mysql_connection.php';
require_once __DIR__ . '/controllers/tai_khoan_controller.php';

$tai_khoan_controller = new TaiKhoanController($conn);

if (!$tai_khoan_controller->isLoggedIn()) {
    header('Location: login.php');
    exit;
}
function getCustomPageTitle($page)
{
    $titles = [
        'home' => 'Trang chủ',
        // Profile
        'profile' => 'Thông tin cá nhân',
        // Vai trò
        'vai-tro-list' => 'Danh sách vai trò',
        'vai-tro-add' => 'Thêm vai trò',
        'vai-tro-edit' => 'Sửa vai trò',
        // Chức năng
        'chuc-nang-list' => 'Danh sách chức năng',
        'chuc-nang-add' => 'Thêm chức năng',
        'chuc-nang-edit' => 'Sửa chức năng',
        // Nhóm vai trò
        'nhom-vai-tro-list' => 'Danh sách nhóm vai trò',
        'nhom-vai-tro-add' => 'Thêm nhóm vai trò',
        'nhom-vai-tro-edit' => 'Sửa nhóm vai trò',
        // Tài khoản
        'tai-khoan-list' => 'Danh sách tài khoản',
        'tai-khoan-add' => 'Thêm tài khoản',
        'tai-khoan-edit' => 'Sửa tài khoản',
        // Khách hàng
        'khach-hang-list' => 'Danh sách khách hàng',
        'khach-hang-add' => 'Thêm khách hàng',
        'khach-hang-edit' => 'Sửa khách hàng',
        'khach-hang-history' => 'Lịch sử khách hàng',
        // Danh mục bệnh
        'danh-muc-benh-list' => 'Danh sách danh mục bệnh',
        'danh-muc-benh-add' => 'Thêm danh mục bệnh',
        'danh-muc-benh-edit' => 'Sửa danh mục bệnh',
        // Bệnh
        'benh-list' => 'Danh sách bệnh',
        'benh-add' => 'Thêm bệnh',
        'benh-edit' => 'Sửa bệnh',
        // Đối tượng tiêm chủng
        'doi-tuong-tiem-chung-list' => 'Danh sách đối tượng tiêm chủng',
        'doi-tuong-tiem-chung-add' => 'Thêm đối tượng tiêm chủng',
        'doi-tuong-tiem-chung-edit' => 'Sửa đối tượng tiêm chủng',
        // Phác đồ tiêm
        'phac-do-tiem-list' => 'Danh sách phác đồ tiêm',
        'phac-do-tiem-add' => 'Thêm phác đồ tiêm',
        'phac-do-tiem-edit' => 'Sửa phác đồ tiêm',
        'phac-do-tiem-detail' => 'Chi tiết phác đồ tiêm',
        // Điều kiện tiêm
        'dieu-kien-tiem-list' => 'Danh sách điều kiện tiêm',
        'dieu-kien-tiem-add' => 'Thêm điều kiện tiêm',
        'dieu-kien-tiem-edit' => 'Sửa điều kiện tiêm',
        // Vaccine
        'vaccine-list' => 'Danh sách vaccine',
        'vaccine-add' => 'Thêm vaccine',
        'vaccine-edit' => 'Sửa vaccine',
        'vaccine-detail' => 'Chi tiết vaccine',
        // Lịch hẹn
        'lich-hen-list' => 'Danh sách lịch hẹn',
        'lich-hen-add' => 'Thêm lịch hẹn',
        'lich-hen-edit' => 'Sửa lịch hẹn',
        // Lịch tiêm
        'lich-tiem-list' => 'Danh sách lịch tiêm',
        'lich-tiem-add' => 'Thêm lịch tiêm',
        'lich-tiem-edit' => 'Sửa lịch tiêm',
        // Thanh toán
        'thanh-toan-list' => 'Danh sách thanh toán',
        'thanh-toan-add' => 'Thêm thanh toán',
        'thanh-toan-edit' => 'Sửa thanh toán',
        // Lứa tuổi
        'lua-tuoi-list' => 'Danh sách lứa tuổi',
        'lua-tuoi-add' => 'Thêm lứa tuổi',
        'lua-tuoi-edit' => 'Sửa lứa tuổi',
        // Liều lượng tiêm
        'lieu-luong-tiem-list' => 'Danh sách liều lượng tiêm',
        'lieu-luong-tiem-add' => 'Thêm liều lượng tiêm',
        'lieu-luong-tiem-edit' => 'Sửa liều lượng tiêm',
        // Đăng ký tiêm
        'dang-ky-tiem-tai-nha-list' => 'Danh sách đăng ký tiêm',
        'dang-ky-tiem-tai-nha-detail' => 'Chi tiết đăng ký tiêm',
    ];
    return isset($titles[$page]) ? $titles[$page] : 'Trang chủ';
}

$current_page = isset($_GET['page']) ? $_GET['page'] : 'home';
$page_title = getCustomPageTitle($current_page); // Lấy tiêu đề trang riêng


?>


<!DOCTYPE html>
<htm lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title><?php echo htmlspecialchars($page_title); ?></title>

        <link rel="icon" href="favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <link rel="icon" href="favicon.ico" type="image/ico">

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

        <!-- Text editor -->
        <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.css">
        <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

    </head>
    <?php
    $current_page = isset($_GET['page']) ? $_GET['page'] : 'home';
    if (isset($_SESSION['current_page'])) {
        $current_page = $_SESSION['current_page'];
    }

    if ($current_page != 'home') {
        $user_id = $_SESSION['user_id'];
        $has_permission = $tai_khoan_controller->getTaiKhoanModel()->checkPermission($user_id, $current_page);

        if (!$has_permission) {
            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Không có quyền truy cập',
                text: 'Bạn không có quyền truy cập trang này!'
            }).then((result) => {
                window.location.href = 'index.php?page=home';
            });
        </script>";
            exit;
        }
    } ?>

    <body>
        <!-- Navbar -->
        <?php include('includes/navbar.php') ?>

        <div class="uk-grid-collapse" uk-grid>
            <!-- Sidebar -->
            <?php include('includes/sidebar.php') ?>

            <!-- Main Content -->
            <div class="uk-width-expand uk-padding">
                <main>
                    <?php
                    include 'config/mysql_connection.php';

                    $current_page = isset($_GET['page']) ? $_GET['page'] : '';
                    if (isset($_SESSION['current_page'])) {
                        $current_page = $_SESSION['current_page'];
                    }

                    switch ($current_page) {
                        case 'home':
                            include 'views/home.php';
                            break;
                        case 'profile':
                            include 'views/tai_khoan/profile.php';
                            break;
                        case 'vai-tro-list':
                            include 'views/vai_tro/list.php';
                            break;
                        case 'vai-tro-add':
                            include 'views/vai_tro/add.php';
                            break;
                        case 'vai-tro-edit':
                            include 'views/vai_tro/edit.php';
                            break;
                        case 'chuc-nang-list':
                            include 'views/chuc_nang/list.php';
                            break;
                        case 'chuc-nang-add':
                            include 'views/chuc_nang/add.php';
                            break;
                        case 'chuc-nang-edit':
                            include 'views/chuc_nang/edit.php';
                            break;
                        case 'nhom-vai-tro-list':
                            include 'views/nhom_vai_tro/list.php';
                            break;
                        case 'nhom-vai-tro-add':
                            include 'views/nhom_vai_tro/add.php';
                            break;
                        case 'nhom-vai-tro-edit':
                            include 'views/nhom_vai_tro/edit.php';
                            break;
                        case 'tai-khoan-list':
                            include 'views/tai_khoan/list.php';
                            break;
                        case 'tai-khoan-add':
                            include 'views/tai_khoan/add.php';
                            break;
                        case 'tai-khoan-edit':
                            include 'views/tai_khoan/edit.php';
                            break;
                        case 'khach-hang-history':
                            include 'views/khach_hang/history.php';
                            break;
                        case 'khach-hang-list':
                            include 'views/khach_hang/list.php';
                            break;
                        case 'khach-hang-add':
                            include 'views/khach_hang/add.php';
                            break;
                        case 'khach-hang-edit':
                            include 'views/khach_hang/edit.php';
                            break;
                        case 'danh-muc-benh-list':
                            include 'views/danh_muc_benh/list.php';
                            break;
                        case 'danh-muc-benh-add':
                            include 'views/danh_muc_benh/add.php';
                            break;
                        case 'danh-muc-benh-edit':
                            include 'views/danh_muc_benh/edit.php';
                            break;
                        case 'benh-list':
                            include 'views/benh/list.php';
                            break;
                        case 'benh-add':
                            include 'views/benh/add.php';
                            break;
                        case 'benh-edit':
                            include 'views/benh/edit.php';
                            break;
                        case 'doi-tuong-tiem-chung-list':
                            include 'views/doi_tuong_tiem_chung/list.php';
                            break;
                        case 'doi-tuong-tiem-chung-add':
                            include 'views/doi_tuong_tiem_chung/add.php';
                            break;
                        case 'doi-tuong-tiem-chung-edit':
                            include 'views/doi_tuong_tiem_chung/edit.php';
                            break;
                        case 'phac-do-tiem-list':
                            include 'views/phac_do_tiem/list.php';
                            break;
                        case 'phac-do-tiem-add':
                            include 'views/phac_do_tiem/add.php';
                            break;
                        case 'phac-do-tiem-edit':
                            include 'views/phac_do_tiem/edit.php';
                            break;
                        case 'phac-do-tiem-detail':
                            include 'views/phac_do_tiem/detail.php';
                            break;
                        case 'dieu-kien-tiem-list':
                            include 'views/dieu_kien_tiem/list.php';
                            break;
                        case 'dieu-kien-tiem-add':
                            include 'views/dieu_kien_tiem/add.php';
                            break;
                        case 'dieu-kien-tiem-edit':
                            include 'views/dieu_kien_tiem/edit.php';
                            break;
                        case 'vaccine-list':
                            include 'views/vaccine/list.php';
                            break;
                        case 'vaccine-add':
                            include 'views/vaccine/add.php';
                            break;
                        case 'vaccine-edit':
                            include 'views/vaccine/edit.php';
                            break;
                        case 'vaccine-detail':
                            include 'views/vaccine/detail.php';
                            break;
                        case 'lich-hen-list':
                            include 'views/lich_hen/list.php';
                            break;
                        case 'lich-hen-add':
                            include 'views/lich_hen/add.php';
                            break;
                        case 'lich-hen-edit':
                            include 'views/lich_hen/edit.php';
                            break;
                        case 'lich-tiem-list':
                            include 'views/lich_tiem/list.php';
                            break;
                        case 'lich-tiem-add':
                            include 'views/lich_tiem/add.php';
                            break;
                        case 'lich-tiem-edit':
                            include 'views/lich_tiem/edit.php';
                            break;
                        case 'thanh-toan-list':
                            include 'views/thanh_toan/list.php';
                            break;
                        case 'thanh-toan-add':
                            include 'views/thanh_toan/add.php';
                            break;
                        case 'thanh-toan-edit':
                            include 'views/thanh_toan/edit.php';
                            break;
                        case 'lua-tuoi-list':
                            include 'views/lua_tuoi/list.php';
                            break;
                        case 'lua-tuoi-add':
                            include 'views/lua_tuoi/add.php';
                            break;
                        case 'lua-tuoi-edit':
                            include 'views/lua_tuoi/edit.php';
                            break;
                        case 'lieu-luong-tiem-list':
                            include 'views/lieu_luong_tiem/list.php';
                            break;
                        case 'lieu-luong-tiem-add':
                            include 'views/lieu_luong_tiem/add.php';
                            break;
                        case 'lieu-luong-tiem-edit':
                            include 'views/lieu_luong_tiem/edit.php';
                            break;
                        case 'dang-ky-tiem-tai-nha-list':
                            include 'views/dang_ky_tiem_tai_nha/list.php';
                            break;
                        case 'dang-ky-tiem-tai-nha-detail':
                            include 'views/dang_ky_tiem_tai_nha/detail.php';
                            break;
                        default:
                            include 'views/home.php';
                    }
                    ?>
                </main>
            </div>
        </div>

        <!-- Footer (optional) -->
        <footer class="uk-text-center uk-padding uk-background-muted">
            <p>&copy; 2024 OOPVC Dashboard</p>
        </footer>

    </body>

    </html>