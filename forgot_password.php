<?php
require_once __DIR__ . '/config/mysql_connection.php';
require_once __DIR__ . '/controllers/tai_khoan_controller.php';
require_once __DIR__ . '/controllers/mat_khau_tam_controller.php';
require_once __DIR__ . '/libs/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/libs/PHPMailer/SMTP.php';
require_once __DIR__ . '/libs/PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$tai_khoan_controller = new TaiKhoanController($conn);
$mat_khau_tam_controller = new MatKhauTamController($conn);

// Dọn dẹp mật khẩu tạm cũ
$mat_khau_tam_controller->cleanupOldPasswords();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    $user = $tai_khoan_controller->getUserByEmail($email);

    if ($user) {
        // Tạo mật khẩu tạm mới
        $temp_pass_result = $mat_khau_tam_controller->createTempPassword($user['id']);

        if ($temp_pass_result['success']) {
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'trungtamtiemvaccineoopvc@gmail.com';
                $mail->Password = 'fujb dggc kruw infa';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('trungtamtiemvaccineoopvc@gmail.com', 'Trung Tâm Tiêm Vaccine');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';
                $mail->Subject = 'Mật khẩu tạm thời - Trung Tâm Tiêm Vaccine';
                $mail->Body = "
                    <p>Xin chào,</p>
                    <p>Chúng tôi nhận được yêu cầu cấp mật khẩu tạm thời từ bạn.</p>
                    <p>Mật khẩu tạm thời của bạn là: <strong>{$temp_pass_result['password']}</strong></p>
                    <p>Mật khẩu này sẽ có hiệu lực trong vòng 24 giờ.</p>
                    <p>Sau khi đăng nhập, bạn nên đổi lại mật khẩu mới.</p>
                    <p>Nếu bạn không thực hiện yêu cầu này, vui lòng liên hệ với chúng tôi ngay.</p>
                    <br>
                    <p>Trân trọng,</p>
                    <p>Trung Tâm Tiêm Vaccine</p>";

                $mail->send();
                $success = "Vui lòng kiểm tra email của bạn để nhận mật khẩu tạm thời.";
            } catch (Exception $e) {
                $error = "Không thể gửi email. Lỗi: {$mail->ErrorInfo}";
                error_log("Email sending error: " . $mail->ErrorInfo);
            }
        } else {
            $error = "Có lỗi xảy ra khi tạo mật khẩu tạm thời.";
        }
    } else {
        $error = "Email không tồn tại trong hệ thống.";
    }
}

include __DIR__ . '/views/forgot_password.php';