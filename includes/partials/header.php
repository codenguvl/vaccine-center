<header class="header">
    <div class="uk-container">
        <nav class="uk-navbar-container" uk-navbar>
            <div class="uk-navbar-left">
                <svg fill="none" height="48" viewBox="0 0 40 48" width="40" xmlns="http://www.w3.org/2000/svg">
                    <g clip-rule="evenodd" fill-rule="evenodd">
                        <path
                            d="m34.5868 8.40061-9.6868-2.59556c-.6687-.17919-1.2108.23679-1.2108.92911v10.02854c0 .6923.5421 1.3988 1.2108 1.578l9.6868 2.5955c.6687.1792 1.2109-.2368 1.2109-.9291v-10.02848c0-.69232-.5422-1.39882-1.2109-1.57801zm-9.6868-6.35625c-2.6749-.71674-4.8434.94718-4.8434 3.71647v10.02847c0 2.7693 2.1685 5.5953 4.8434 6.312l9.6868 2.5956c2.6749.7168 4.8434-.9472 4.8434-3.7165v-10.0284c0-2.76934-2.1685-5.59533-4.8434-6.31207z"
                            fill="#8098f9" />
                        <path
                            d="m26.9812 16.5707-12.1085-3.2444c-.6687-.1792-1.2109.2368-1.2109.9291v12.5356c0 .6923.5422 1.3988 1.2109 1.578l12.1085 3.2445c.6687.1792 1.2108-.2368 1.2108-.9291v-12.5356c0-.6924-.5421-1.3989-1.2108-1.5781zm-12.1085-7.0051c-2.6749-.71674-4.8434.9472-4.8434 3.7165v12.5356c0 2.7693 2.1685 5.5953 4.8434 6.312l12.1085 3.2445c2.6749.7167 4.8433-.9472 4.8433-3.7165v-12.5356c0-2.7693-2.1684-5.5953-4.8433-6.312z"
                            fill="#6172f3" />
                        <path
                            d="m19.3736 24.7409-14.53021-3.8934c-.66873-.1792-1.21085.2368-1.21085.9291v15.0428c0 .6923.54212 1.3988 1.21085 1.578l14.53021 3.8933c.6687.1792 1.2108-.2368 1.2108-.9291v-15.0427c0-.6923-.5421-1.3988-1.2108-1.578zm-14.53021-7.6541c-2.67493-.7167-4.84339.9472-4.84339 3.7165v15.0427c0 2.7693 2.16846 5.5953 4.84339 6.3121l14.53021 3.8933c2.6749.7168 4.8433-.9472 4.8433-3.7164v-15.0428c0-2.7693-2.1684-5.5953-4.8433-6.312z"
                            fill="#444ce7" />
                    </g>
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