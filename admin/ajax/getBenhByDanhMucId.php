<?php
require_once __DIR__ . '/../config/mysql_connection.php';
require_once __DIR__ . '/../controllers/benh_controller.php';

$danh_muc_id = $_POST['danh_muc_id'] ?? null;

if ($danh_muc_id) {
    $benh_controller = new BenhController($conn);
    $benh_list = $benh_controller->getBenhByDanhMucId($danh_muc_id);

    foreach ($benh_list as $benh) {
        echo '<option value="' . htmlspecialchars($benh['benh_id']) . '">' . htmlspecialchars($benh['ten_benh']) . '</option>';
    }
} else {
    echo '<option value="">Chọn bệnh</option>';
}
?>