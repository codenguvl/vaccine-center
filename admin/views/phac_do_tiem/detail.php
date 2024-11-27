<?php
require_once 'controllers/phac_do_tiem_controller.php';
$phac_do_tiem_controller = new PhacDoTiemController($conn);

if (isset($_GET['id'])) {
    $phac_do = $phac_do_tiem_controller->getPhacDoTiemById($_GET['id']);
    if (!$phac_do) {
        die("Phác đồ tiêm không tồn tại.");
    }
} else {
    die("ID không hợp lệ.");
}
?>

<div class="uk-container">
    <h1 class="uk-heading-line"><span>Chi tiết phác đồ tiêm</span></h1>
    <table class="uk-table uk-table-divider">
        <tbody>
            <tr>
                <th>Tên phác đồ</th>
                <td><?php echo htmlspecialchars($phac_do['ten_phac_do']); ?></td>
            </tr>
            <tr>
                <th>Lứa tuổi</th>
                <td><?php echo htmlspecialchars($phac_do['lua_tuoi_mo_ta']); ?></td>
            </tr>
            <tr>
                <th>Liều lượng</th>
                <td><?php echo htmlspecialchars($phac_do['lieu_luong_mo_ta']); ?></td>
            </tr>
            <tr>
                <th>Lịch tiêm</th>
                <td><?php echo $phac_do['lich_tiem']; ?></td>
            </tr>
            <tr>
                <th>Liều nhắc</th>
                <td><?php echo $phac_do['lieu_nhac']; ?></td>
            </tr>
            <tr>
                <th>Ghi chú</th>
                <td><?php echo $phac_do['ghi_chu']; ?></td>
            </tr>
        </tbody>
    </table>
</div>