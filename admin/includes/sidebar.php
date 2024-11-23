<div id="offcanvas-nav" uk-offcanvas="mode: push; overlay: true">
    <div class="uk-offcanvas-bar">
        <button class="uk-offcanvas-close" type="button" uk-close></button>
        <h3>Quản lý</h3>
        <ul class="uk-nav uk-nav-default">
            <li class="uk-active"><a href="index.php">Tổng quan</a></li>
            <li class="uk-parent">
                <a href="#" uk-toggle="target: #submenu-vai-tro">Quản lý Vai trò</a>
                <ul id="submenu-vai-tro" class="uk-nav-sub" hidden>
                    <li><a href="index.php?page=vai-tro-list">Danh sách</a></li>
                    <li><a href="index.php?page=vai-tro-add">Thêm mới</a></li>
                </ul>
            </li>
            <li class="uk-parent">
                <a href="#" uk-toggle="target: #submenu-chuc-nang">Quản lý Chức năng</a>
                <ul id="submenu-chuc-nang" class="uk-nav-sub" hidden>
                    <li><a href="index.php?page=chuc-nang-list">Danh sách</a></li>
                    <li><a href="index.php?page=chuc-nang-add">Thêm mới</a></li>
                </ul>
            </li>
            <li class="uk-parent">
                <a href="#" uk-toggle="target: #submenu-tai-khoan">Quản lý Tài khoản</a>
                <ul id="submenu-tai-khoan" class="uk-nav-sub" hidden>
                    <li><a href="index.php?page=tai-khoan-list">Danh sách</a></li>
                    <li><a href="index.php?page=tai-khoan-add">Thêm mới</a></li>
                </ul>
            </li>
            <li class="uk-parent">
                <a href="#" uk-toggle="target: #submenu-khach-hang">Quản lý Khách hàng</a>
                <ul id="submenu-khach-hang" class="uk-nav-sub" hidden>
                    <li><a href="index.php?page=khach-hang-list">Danh sách</a></li>
                    <li><a href="index.php?page=khach-hang-add">Thêm mới</a></li>
                </ul>
            </li>
            <li class="uk-parent">
                <a href="#" uk-toggle="target: #submenu-danh-muc-benh">Quản lý Danh mục bệnh</a>
                <ul id="submenu-danh-muc-benh" class="uk-nav-sub" hidden>
                    <li><a href="index.php?page=danh-muc-benh-list">Danh sách</a></li>
                    <li><a href="index.php?page=danh-muc-benh-add">Thêm mới</a></li>
                </ul>
            </li>
            <li class="uk-parent">
                <a href="#" uk-toggle="target: #submenu-benh">Quản lý Bệnh</a>
                <ul id="submenu-benh" class="uk-nav-sub" hidden>
                    <li><a href="index.php?page=benh-list">Danh sách</a></li>
                    <li><a href="index.php?page=benh-add">Thêm mới</a></li>
                </ul>
            </li>
            <li class="uk-parent">
                <a href="#" uk-toggle="target: #submenu-doi-tuong-tiem-chung">Quản lý Đối tượng tiêm chủng</a>
                <ul id="submenu-doi-tuong-tiem-chung" class="uk-nav-sub" hidden>
                    <li><a href="index.php?page=doi-tuong-tiem-chung-list">Danh sách</a></li>
                    <li><a href="index.php?page=doi-tuong-tiem-chung-add">Thêm mới</a></li>
                </ul>
            </li>
            <li class="uk-parent">
                <a href="#" uk-toggle="target: #submenu-lua-tuoi">Quản lý Lứa tuổi</a>
                <ul id="submenu-lua-tuoi" class="uk-nav-sub" hidden>
                    <li><a href="index.php?page=lua-tuoi-list">Danh sách</a></li>
                    <li><a href="index.php?page=lua-tuoi-add">Thêm mới</a></li>
                </ul>
            </li>
            <li class="uk-parent">
                <a href="#" uk-toggle="target: #submenu-lieu-luong-tiem">Quản lý Liều lượng</a>
                <ul id="submenu-lieu-luong-tiem" class="uk-nav-sub" hidden>
                    <li><a href="index.php?page=lieu-luong-tiem-list">Danh sách</a></li>
                    <li><a href="index.php?page=lieu-luong-tiem-add">Thêm mới</a></li>
                </ul>
            </li>
            <li class="uk-parent">
                <a href="#" uk-toggle="target: #submenu-phac-do-tiem">Quản lý Phác đồ tiêm</a>
                <ul id="submenu-phac-do-tiem" class="uk-nav-sub" hidden>
                    <li><a href="index.php?page=phac-do-tiem-list">Danh sách</a></li>
                    <li><a href="index.php?page=phac-do-tiem-add">Thêm mới</a></li>
                </ul>
            </li>
            <li class="uk-parent">
                <a href="#" uk-toggle="target: #submenu-dieu-kien-tiem">Quản lý Điều kiện tiêm</a>
                <ul id="submenu-dieu-kien-tiem" class="uk-nav-sub" hidden>
                    <li><a href="index.php?page=dieu-kien-tiem-list">Danh sách</a></li>
                    <li><a href="index.php?page=dieu-kien-tiem-add">Thêm mới</a></li>
                </ul>
            </li>
            <li class="uk-parent">
                <a href="#" uk-toggle="target: #submenu-vaccine">Quản lý Vaccine</a>
                <ul id="submenu-vaccine" class="uk-nav-sub" hidden>
                    <li><a href="index.php?page=vaccine-list">Danh sách</a></li>
                    <li><a href="index.php?page=vaccine-add">Thêm mới</a></li>
                </ul>
            </li>
            <li class="uk-parent">
                <a href="#" uk-toggle="target: #submenu-dang-ky-tiem-tai-nha">Quản lý Đăng ký tiêm</a>
                <ul id="submenu-dang-ky-tiem-tai-nha" class="uk-nav-sub" hidden>
                    <li><a href="index.php?page=dang-ky-tiem-tai-nha-list">Danh sách</a></li>
                </ul>
            </li>
            <li class="uk-parent">
                <a href="#" uk-toggle="target: #submenu-lich-hen">Quản lý Lịch hẹn</a>
                <ul id="submenu-lich-hen" class="uk-nav-sub" hidden>
                    <li><a href="index.php?page=lich-hen-list">Danh sách</a></li>
                    <li><a href="index.php?page=lich-hen-add">Thêm mới</a></li>
                </ul>
            </li>
            <li class="uk-parent">
                <a href="#" uk-toggle="target: #submenu-lich-tiem">Quản lý Lịch tiêm</a>
                <ul id="submenu-lich-tiem" class="uk-nav-sub" hidden>
                    <li><a href="index.php?page=lich-tiem-list">Danh sách</a></li>
                    <li><a href="index.php?page=lich-tiem-add">Thêm mới</a></li>
                </ul>
            </li>
            <li class="uk-parent">
                <a href="#" uk-toggle="target: #submenu-thanh-toan">Quản lý Thanh toán</a>
                <ul id="submenu-thanh-toan" class="uk-nav-sub" hidden>
                    <li><a href="index.php?page=thanh-toan-list">Danh sách</a></li>
                    <li><a href="index.php?page=thanh-toan-add">Thêm mới</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>