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
    <title>Đăng Ký Lịch Tiêm</title>

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
</head>

<body>

    <?php include('includes/partials/header.php') ?>

    <div class="uk-container">
        <form action="" method="POST" class="uk-margin-bottom">
            <!-- Thông tin người tiêm -->
            <fieldset class="uk-fieldset">
                <legend class="uk-legend">Thông Tin Người Tiêm</legend>
                <div class="uk-margin">
                    <label for="name" class="uk-form-label">Họ và Tên</label>
                    <input class="uk-input" type="text" id="name" name="name" placeholder="Họ và Tên" required>
                </div>
                <div class="uk-margin">
                    <label for="dob" class="uk-form-label">Ngày Sinh</label>
                    <input class="uk-input" type="date" id="dob" name="dob" required>
                </div>
                <div class="uk-margin">
                    <label for="gender" class="uk-form-label">Giới Tính</label>
                    <select class="uk-select" id="gender" name="gender" required>
                        <option value="">Chọn Giới Tính</option>
                        <option value="male">Nam</option>
                        <option value="female">Nữ</option>
                    </select>
                </div>
                <div class="uk-margin">
                    <label for="customer_id" class="uk-form-label">Mã Khách Hàng VNVC (nếu có)</label>
                    <input class="uk-input" type="text" id="customer_id" name="customer_id"
                        placeholder="Mã Khách Hàng VNVC">
                </div>
                <div class="uk-margin">
                    <label for="province" class="uk-form-label">Tỉnh Thành</label>
                    <select class="uk-select" id="province" name="province" required>
                        <option value="">Chọn Tỉnh Thành</option>
                        <!-- Các lựa chọn tỉnh thành sẽ được thêm vào ở đây -->
                    </select>
                </div>
                <div class="uk-margin">
                    <label for="district" class="uk-form-label">Quận Huyện</label>
                    <select class="uk-select" id="district" name="district" required disabled>
                        <option value="">Chọn Quận Huyện</option>
                    </select>
                </div>
                <div class="uk-margin">
                    <label for="ward" class="uk-form-label">Phường Xã</label>
                    <select class="uk-select" id="ward" name="ward" required disabled>
                        <option value="">Chọn Phường Xã</option>
                    </select>
                </div>
                <div class="uk-margin">
                    <label for="address" class="uk-form-label">Số Nhà, Tên Đường</label>
                    <input class="uk-input" type="text" id="address" name="address" placeholder="Số nhà, tên đường"
                        required>
                </div>
            </fieldset>

            <!-- Thông tin người liên hệ -->
            <fieldset class="uk-fieldset">
                <legend class="uk-legend">Thông Tin Người Liên Hệ</legend>
                <div class="uk-margin">
                    <label for="contact_name" class="uk-form-label">Họ và Tên Người Liên Hệ</label>
                    <input class="uk-input" type="text" id="contact_name" name="contact_name"
                        placeholder="Họ và Tên Người Liên Hệ" required>
                </div>
                <div class="uk-margin">
                    <label for="relation" class="uk-form-label">Mối Quan Hệ Với Người Tiêm</label>
                    <select class="uk-select" id="relation" name="relation" required>
                        <option value="">Chọn Mối Quan Hệ</option>
                        <option value="parent">Bố/Mẹ</option>
                        <option value="relative">Người Thân</option>
                        <option value="friend">Bạn Bè</option>
                    </select>
                </div>
                <div class="uk-margin">
                    <label for="contact_phone" class="uk-form-label">Số Điện Thoại Người Liên Hệ</label>
                    <input class="uk-input" type="text" id="contact_phone" name="contact_phone"
                        placeholder="Số Điện Thoại" required>
                </div>
            </fieldset>

            <!-- Thông tin dịch vụ -->
            <fieldset class="uk-fieldset">
                <legend class="uk-legend">Thông Tin Dịch Vụ</legend>
                <div class="uk-margin">
                    <label for="vaccine_type" class="uk-form-label">Loại Vắc Xin Muốn Đăng Ký</label>
                    <select class="uk-select" id="vaccine_type" name="vaccine_type" required>
                        <option value="">Chọn Loại Vắc Xin</option>
                        <option value="package">Vắc Xin Gói</option>
                        <option value="single">Vắc Xin Lẻ</option>
                    </select>
                </div>
                <div class="uk-margin">
                    <label for="preferred_date" class="uk-form-label">Ngày Mong Muốn Tiêm</label>
                    <input class="uk-input" type="date" id="preferred_date" name="preferred_date" required>
                </div>
            </fieldset>

            <!-- Submit button -->
            <button class="uk-button uk-button-primary" type="submit">Đăng Ký Lịch Tiêm</button>
        </form>
    </div>
    <!-- Footer -->
    <?php include('includes/partials/footer.php') ?>

</body>

</html>