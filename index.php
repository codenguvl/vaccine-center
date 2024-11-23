<?php
ob_start();
require_once __DIR__ . '/admin/config/mysql_connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Trang Chủ - Trung Tâm Tiêm Chủng OOPVC</title>

    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/css/uikit.min.css" />
    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/js/uikit-icons.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <!-- Google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Mona+Sans:ital,wght@0,200..900;1,200..900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="./static/css/main.css">

</head>

<body>
    <!-- Header -->
    <?php include('includes/partials/header.php') ?>

    <!-- Offcanvas Menu -->
    <div id="offcanvas-nav" uk-offcanvas="mode: push; overlay: true">
        <div class="uk-offcanvas-bar">
            <button class="uk-offcanvas-close" type="button" uk-close></button>
            <ul class="uk-nav uk-nav-default">
                <li><a href="index.php">Trang Chủ</a></li>
                <li><a href="about.php">Giới Thiệu</a></li>
                <li><a href="register.php">Đăng Ký Tiêm</a></li>
                <li><a href="check.php">Kiểm Tra Thông Tin</a></li>
            </ul>
        </div>
    </div>

    <!-- Slider -->
    <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slider>

        <!-- Slider Items -->
        <ul class="uk-slider-items uk-child-width-1-1">
            <li>
                <img src="static/images/banner1.webp" alt="Tiêm chủng an toàn" style="width: 100%; height: auto;">
            </li>
            <li>
                <img src="static/images/banner2.webp" alt="Đội ngũ chuyên gia" style="width: 100%; height: auto;">
            </li>
            <li>
                <img src="static/images/banner3.webp" alt="Dịch vụ uy tín" style="width: 100%; height: auto;">
            </li>
        </ul>

        <!-- Navigation -->
        <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous
            uk-slider-item="previous"></a>
        <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next
            uk-slider-item="next"></a>

    </div>
    <div>
        <img src="static/images/khuyenmai.gif" alt="">
    </div>

    <section class="uk-container category">
        <div class="uk-height-medium uk-flex uk-flex-center uk-flex-middle uk-background-cover uk-light"
            data-src="static/images/banner.webp" uk-img>
            <div class="category__wrap">
                <div class="category__description">
                    <h1>Tiêm Chủng OOPVC</h1>
                    <p>Vắc Xin Chính Hãng - Luôn Có Sẵn Hàng</p>
                </div>
                <div class="category__option">
                    <div class="uk-child-width-1-3@m uk-grid-small uk-grid-match" uk-grid>
                        <div onclick="window.location.href='register.php'" style="cursor: pointer;">
                            <div class="uk-card uk-card-default uk-card-body">
                                <h3 class="uk-card-title">Đăng Ký Tiêm</h3>
                                <p>Chọn lịch tiêm chủng phù hợp với thời gian của bạn thông qua hệ thống đăng ký trực
                                    tuyến tiện lợi, giúp bạn tiết kiệm thời gian và đảm bảo trải nghiệm dịch vụ chuyên
                                    nghiệp.</p>
                            </div>
                        </div>
                        <div onclick="window.location.href='check.php'" style="cursor: pointer;">
                            <div class="uk-card uk-card-default uk-card-body">
                                <h3 class="uk-card-title">Kiểm Tra Thông Tin</h3>
                                <p>Dễ dàng tra cứu lịch sử tiêm chủng và thông tin hồ sơ sức khỏe, giúp bạn theo dõi và
                                    quản lý các mũi tiêm một cách hiệu quả, chính xác và nhanh chóng.</p>
                            </div>
                        </div>
                        <div onclick="window.location.href='about.php'" style="cursor: pointer;">
                            <div class="uk-card uk-card-default uk-card-body">
                                <h3 class="uk-card-title">Về chúng tôi</h3>
                                <p>Khám phá thông tin về hệ thống của chúng tôi, cam kết mang lại dịch vụ tiêm chủng
                                    chất lượng,
                                    đội ngũ chuyên nghiệp, và những giá trị cốt lõi mà chúng tôi hướng tới.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- Footer -->
    <?php include('includes/partials/footer.php') ?>

</body>

</html>