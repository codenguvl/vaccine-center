<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION['user_id']);
$userName = $isLoggedIn ? $_SESSION['user_name'] : '';

$avatarPath = 'static/images/default-avatar.png'; // Đường dẫn mặc định cho avatar

if ($isLoggedIn) {
    // Khởi tạo controller
    require_once 'controllers/tai_khoan_controller.php';
    $tai_khoan_controller = new TaiKhoanController($conn);

    // Lấy avatar từ controller
    $avatarPath = $tai_khoan_controller->getAvatar($_SESSION['user_id']) ?: $avatarPath;
}
?>
<style>
/* Thêm style cho navbar và breadcrumb */
.uk-navbar-container {
    border-bottom: 1px solid #e5e5e5;
}

.uk-breadcrumb {
    margin: 0;
    padding: 10px 15px;
}

.uk-breadcrumb>li>a {
    color: #666;
}

.uk-breadcrumb>li>a:hover {
    color: #1e87f0;
    text-decoration: none;
}

.uk-breadcrumb>li.uk-active>span {
    color: #333;
    font-weight: 500;
    color: #1e87f0 !important;
}

.uk-breadcrumb>*>* {
    font-size: 15px important;
}

/* Style cho avatar và username */
.d-flex {
    display: flex;
    align-items: center;
    gap: 10px;
}

.d-flex img {
    width: 32px;
    height: 32px;
    border-radius: 50%;
}

/* Style cho sticky navbar */
.uk-sticky-fixed {
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
</style>
<nav class="uk-navbar-container" uk-navbar>
    <button class="uk-button uk-button-default uk-margin-small-right" type="button" uk-toggle="target: #offcanvas-nav">
        <i class="fa-solid fa-bars"></i>
    </button>
    <div class="uk-navbar-left ">

        <!-- Logo -->
        <a class="uk-navbar-item uk-logo" href="#"><svg fill="none" height="48" viewBox="0 0 40 48" width="40"
                xmlns="http://www.w3.org/2000/svg">
                <circle cx="14" cy="18" fill="#1570ef" r="14" />
                <circle cx="26" cy="30" fill="#53b1fd" r="14" />
            </svg> <span class="uk-text-bolder">OOPVC</span></a>
    </div>

    <?php include('includes/breadcrumb.php'); ?>

    <div class="uk-navbar-right">
        <!-- Search Icon -->
        <div>
            <a class="uk-navbar-toggle" uk-search-icon href="#"></a>
            <div class="uk-navbar-dropdown" uk-drop="mode: click; pos: left-center; offset: 0">
                <form class="uk-search uk-search-navbar uk-width-1-1">
                    <input class="uk-search-input" type="search" placeholder="Search...">
                </form>
            </div>
        </div>


        <ul class="uk-navbar-nav">
            <?php if ($isLoggedIn): ?>
            <li>
                <div class="d-flex">
                    <img src="<?php echo htmlspecialchars($avatarPath); ?>" alt="User Avatar">
                    <span><?php echo htmlspecialchars($userName); ?></span>
                </div>
                <div class="uk-navbar-dropdown" uk-drop="mode: click; pos: bottom-right;">
                    <ul class="uk-nav uk-navbar-dropdown-nav">
                        <li><a href="index.php?page=profile">Thông tin cá nhân</a></li>
                        <li><a href="#">Cài đặt</a></li>
                        <li><a href="logout.php">Đăng xuất</a></li>
                    </ul>
                </div>
            </li>
            <?php else: ?>
            <li><a href="login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>