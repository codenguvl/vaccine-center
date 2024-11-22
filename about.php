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
    <meta name="description" content="Trung tâm tiêm chủng OOPVC - Dịch vụ tiêm chủng chất lượng cao" />
    <meta name="author" content="OOPVC" />
    <title>Giới Thiệu - Trung Tâm Tiêm Chủng OOPVC</title>
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/css/uikit.min.css" />
    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/js/uikit-icons.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google font -->
    <link
        href="https://fonts.googleapis.com/css2?family=Mona+Sans:ital,wght@0,200..900;1,200..900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <!-- Import css -->
    <link rel="stylesheet" href="./static/css/reset.css">
    <link rel="stylesheet" href="./static/css/main.css">
</head>

<body>

    <?php include('includes/partials/header.php') ?>

    <div class="uk-container uk-margin-small-top">
        <!-- Section Header -->
        <h1 class="uk-heading-small">Giới Thiệu Về Trung Tâm Tiêm Chủng OOPVC</h1>
        <p>Trung tâm Tiêm chủng OOPVC tự hào là một trong những đơn vị cung cấp dịch vụ tiêm chủng chất lượng cao, uy
            tín, giúp bảo vệ sức khỏe cộng đồng và phòng ngừa các bệnh nguy hiểm. Với đội ngũ y bác sĩ giàu kinh nghiệm,
            cơ sở vật chất hiện đại, chúng tôi cam kết mang đến cho khách hàng những dịch vụ an toàn, hiệu quả và thuận
            tiện nhất.</p>

        <!-- Mission -->
        <h2 class="uk-heading-small">Sứ Mệnh Của Chúng Tôi</h2>
        <p>Chúng tôi cam kết mang lại những dịch vụ tiêm chủng an toàn, hiệu quả, đồng thời nâng cao ý thức bảo vệ sức
            khỏe cho mọi người. Sứ mệnh của Trung tâm Tiêm chủng OOPVC là cung cấp các dịch vụ tiêm vắc-xin phòng ngừa
            các bệnh truyền nhiễm cho mọi lứa tuổi, từ trẻ em đến người lớn, giúp bảo vệ sức khỏe gia đình bạn khỏi các
            bệnh dịch nguy hiểm.</p>


        <!-- Why Choose Us -->
        <h2 class="uk-heading-small">Tại Sao Chọn OOPVC?</h2>
        <ul class="uk-list uk-list-bullet">
            <li><strong>Đội ngũ bác sĩ chuyên môn cao</strong>: Các bác sĩ tại OOPVC đều được đào tạo chuyên sâu và có
                nhiều năm kinh nghiệm trong lĩnh vực tiêm chủng.</li>
            <li><strong>Cơ sở vật chất hiện đại</strong>: Trung tâm được trang bị các thiết bị y tế hiện đại, đảm bảo
                quá trình tiêm chủng an toàn và hiệu quả.</li>
            <li><strong>Phương pháp tiêm chủng an toàn</strong>: Chúng tôi áp dụng các quy trình tiêm chủng đạt chuẩn
                quốc tế, đảm bảo an toàn tuyệt đối cho khách hàng.</li>
            <li><strong>Giá cả hợp lý</strong>: Chúng tôi cam kết cung cấp dịch vụ tiêm chủng chất lượng cao với mức giá
                phải chăng, phù hợp với mọi đối tượng khách hàng.</li>
        </ul>

        <!-- Contact Us Section -->
        <h2 class="uk-heading-small">Liên Hệ Với Chúng Tôi</h2>
        <p>Để biết thêm thông tin chi tiết về các dịch vụ tiêm chủng, vui lòng liên hệ với chúng tôi qua các phương thức
            dưới đây:</p>
        <ul class="uk-list">
            <li><strong>Địa chỉ</strong>: Nguyễn Văn Cừ Nối Dài, An Khánh, Ninh Kiều, Cần Thơ</li>
            <li><strong>Điện thoại</strong>: +84 123 456 789</li>
            <li><strong>Email</strong>: trungtamtiemvaccineoopvc@gmail.com</li>
        </ul>

        <div class="uk-text-center uk-margin-bottom">
            <a href="contact.php" class="uk-button uk-button-primary">Liên Hệ Ngay</a>
        </div>

    </div>

    <?php include('includes/partials/footer.php') ?>

</body>

</html>