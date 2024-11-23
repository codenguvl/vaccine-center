<?php
function getBreadcrumbTitle($page)
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
        // Điều kiện tiêm
        'dieu-kien-tiem-list' => 'Danh sách điều kiện tiêm',
        'dieu-kien-tiem-add' => 'Thêm điều kiện tiêm',
        'dieu-kien-tiem-edit' => 'Sửa điều kiện tiêm',
        // Vaccine
        'vaccine-list' => 'Danh sách vaccine',
        'vaccine-add' => 'Thêm vaccine',
        'vaccine-edit' => 'Sửa vaccine',
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

function getParentPage($page)
{
    $parents = [
        // Vai trò
        'vai-tro-add' => 'vai-tro-list',
        'vai-tro-edit' => 'vai-tro-list',
        // Chức năng
        'chuc-nang-add' => 'chuc-nang-list',
        'chuc-nang-edit' => 'chuc-nang-list',
        // Nhóm vai trò
        'nhom-vai-tro-add' => 'nhom-vai-tro-list',
        'nhom-vai-tro-edit' => 'nhom-vai-tro-list',
        // Tài khoản
        'tai-khoan-add' => 'tai-khoan-list',
        'tai-khoan-edit' => 'tai-khoan-list',
        // Khách hàng
        'khach-hang-add' => 'khach-hang-list',
        'khach-hang-edit' => 'khach-hang-list',
        'khach-hang-history' => 'khach-hang-list',
        // Danh mục bệnh
        'danh-muc-benh-add' => 'danh-muc-benh-list',
        'danh-muc-benh-edit' => 'danh-muc-benh-list',
        // Bệnh
        'benh-add' => 'benh-list',
        'benh-edit' => 'benh-list',
        // Đối tượng tiêm chủng
        'doi-tuong-tiem-chung-add' => 'doi-tuong-tiem-chung-list',
        'doi-tuong-tiem-chung-edit' => 'doi-tuong-tiem-chung-list',
        // Phác đồ tiêm
        'phac-do-tiem-add' => 'phac-do-tiem-list',
        'phac-do-tiem-edit' => 'phac-do-tiem-list',
        // Điều kiện tiêm
        'dieu-kien-tiem-add' => 'dieu-kien-tiem-list',
        'dieu-kien-tiem-edit' => 'dieu-kien-tiem-list',
        // Vaccine
        'vaccine-add' => 'vaccine-list',
        'vaccine-edit' => 'vaccine-list',
        // Lịch hẹn
        'lich-hen-add' => 'lich-hen-list',
        'lich-hen-edit' => 'lich-hen-list',
        // Lịch tiêm
        'lich-tiem-add' => 'lich-tiem-list',
        'lich-tiem-edit' => 'lich-tiem-list',
        // Thanh toán
        'thanh-toan-add' => 'thanh-toan-list',
        'thanh-toan-edit' => 'thanh-toan-list',
        // Lứa tuổi
        'lua-tuoi-add' => 'lua-tuoi-list',
        'lua-tuoi-edit' => 'lua-tuoi-list',
        // Liều lượng tiêm
        'lieu-luong-tiem-add' => 'lieu-luong-tiem-list',
        'lieu-luong-tiem-edit' => 'lieu-luong-tiem-list',
        // Đăng ký tiêm
        'dang-ky-tiem-tai-nha-detail' => 'dang-ky-tiem-tai-nha-list',
    ];

    return isset($parents[$page]) ? $parents[$page] : 'home';
}

$current_page = isset($_GET['page']) ? $_GET['page'] : 'home';
$breadcrumb = [];

// Add home
$breadcrumb[] = [
    'title' => 'Trang chủ',
    'link' => 'index.php',
    'active' => ($current_page == 'home')
];

// Add parent if exists
if ($current_page != 'home') {
    $parent_page = getParentPage($current_page);
    if ($parent_page != 'home') {
        $breadcrumb[] = [
            'title' => getBreadcrumbTitle($parent_page),
            'link' => 'index.php?page=' . $parent_page,
            'active' => false
        ];
    }
}

// Add current page
if ($current_page != 'home') {
    $breadcrumb[] = [
        'title' => getBreadcrumbTitle($current_page),
        'link' => 'index.php?page=' . $current_page,
        'active' => true
    ];
}
?>

<div class="uk-section uk-section-xsmall uk-section-muted">
    <div class="uk-container">
        <ul class="uk-breadcrumb">
            <?php foreach ($breadcrumb as $item): ?>
                <li <?php echo $item['active'] ? 'class="uk-active"' : ''; ?>>
                    <?php if ($item['active']): ?>
                        <span><?php echo htmlspecialchars($item['title']); ?></span>
                    <?php else: ?>
                        <a href="<?php echo htmlspecialchars($item['link']); ?>">
                            <?php echo htmlspecialchars($item['title']); ?>
                        </a>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>