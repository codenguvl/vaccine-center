<header class="header">
    <div class="uk-container">
        <nav class="uk-navbar-container" uk-navbar>
            <div class="uk-navbar-left">
                <svg fill="none" height="48" viewBox="0 0 40 48" width="40" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="14" cy="18" fill="#1570ef" r="14" />
                    <circle cx="26" cy="30" fill="#53b1fd" r="14" />
                </svg>
                <a class="uk-navbar-item uk-logo" href="index.php">OOPVC</a>
            </div>
            <div class="uk-navbar-right">
                <!-- Navbar for larger screens -->
                <ul class="uk-navbar-nav uk-visible@m">
                    <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'uk-active' : ''; ?>"><a
                            href="index.php">Trang Chủ</a></li>
                    <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'about.php') ? 'uk-active' : ''; ?>"><a
                            href="about.php">Giới Thiệu</a></li>
                    <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'register.php') ? 'uk-active' : ''; ?>"><a
                            href="register.php">Đăng Ký Tiêm</a></li>
                    <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'check.php') ? 'uk-active' : ''; ?>"><a
                            href="check.php">Kiểm Tra Thông Tin</a></li>
                </ul>

                <!-- Hamburger menu for smaller screens -->
                <a class="uk-navbar-toggle uk-hidden@m" href="#offcanvas-nav" uk-toggle>
                    <span uk-navbar-toggle-icon></span>
                </a>
            </div>
        </nav>
    </div>
</header>