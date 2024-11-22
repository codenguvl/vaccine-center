<?php
require_once 'controllers/phac_do_tiem_controller.php';
$phac_do_tiem_controller = new PhacDoTiemController($conn);

$id = isset($_GET['id']) ? $_GET['id'] : null;
$phac_do = $phac_do_tiem_controller->getPhacDoTiemById($id);
$lua_tuoi_list = $phac_do_tiem_controller->getAllLuaTuoi();
$lieu_luong_list = $phac_do_tiem_controller->getAllLieuLuong();

if (!$phac_do) {
    echo "Phác đồ tiêm không tồn tại.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $phac_do_tiem_controller->updatePhacDoTiem(
        $id,
        $_POST['ten_phac_do'],
        $_POST['lua_tuoi_id'],
        $_POST['lieu_luong_id'],
        $_POST['lich_tiem'],
        $_POST['lieu_nhac'],
        $_POST['ghi_chu']
    );
    if ($result) {
        header("Location: index.php?page=phac-do-tiem-list&message=edit_success");
        exit();
    } else {
        $message = 'Có lỗi xảy ra khi cập nhật phác đồ tiêm!';
        $status = 'danger';
    }
}
?>

<?php if (isset($message)): ?>
<div class="uk-alert-<?php echo $status; ?>" uk-alert>
    <a class="uk-alert-close" uk-close></a>
    <p><?php echo $message; ?></p>
</div>
<?php endif; ?>

<form class="uk-form-stacked" action="index.php?page=phac-do-tiem-edit&id=<?php echo $id; ?>" method="POST">
    <div class="uk-margin">
        <label class="uk-form-label" for="ten_phac_do">Tên phác đồ:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="ten_phac_do" name="ten_phac_do" type="text"
                value="<?php echo isset($phac_do['ten_phac_do']) ? htmlspecialchars($phac_do['ten_phac_do']) : ''; ?>"
                required>
        </div>
    </div>

    <div class="uk-margin">
        <label class="uk-form-label" for="lua_tuoi_id">Lứa tuổi:</label>
        <div class="uk-form-controls">
            <select class="uk-select" id="lua_tuoi_id" name="lua_tuoi_id" required>
                <option value="">Chọn lứa tuổi</option>
                <?php foreach ($lua_tuoi_list as $lua_tuoi): ?>
                <option value="<?php echo htmlspecialchars($lua_tuoi['lua_tuoi_id']); ?>"
                    <?php echo (isset($phac_do['lua_tuoi_id']) && $lua_tuoi['lua_tuoi_id'] == $phac_do['lua_tuoi_id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($lua_tuoi['mo_ta']); ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="uk-margin">
        <label class="uk-form-label" for="lieu_luong_id">Liều lượng:</label>
        <div class="uk-form-controls">
            <select class="uk-select" id="lieu_luong_id" name="lieu_luong_id" required>
                <option value="">Chọn liều lượng</option>
                <?php foreach ($lieu_luong_list as $lieu_luong): ?>
                <option value="<?php echo htmlspecialchars($lieu_luong['lieu_luong_id']); ?>"
                    <?php echo (isset($phac_do['lieu_luong_id']) && $lieu_luong['lieu_luong_id'] == $phac_do['lieu_luong_id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($lieu_luong['mo_ta']); ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="uk-margin">
        <label class="uk-form-label" for="lich_tiem">Lịch tiêm:</label>
        <div class="uk-form-controls">
            <textarea class="uk-textarea" id="lich_tiem" name="lich_tiem" rows="4"
                required><?php echo isset($phac_do['lich_tiem']) ? htmlspecialchars(trim($phac_do['lich_tiem'])) : ''; ?></textarea>
        </div>
    </div>

    <div class="uk-margin">
        <label class="uk-form-label" for="lieu_nhac">Liều nhắc:</label>
        <div class="uk-form-controls">
            <textarea class="uk-textarea" id="lieu_nhac" name="lieu_nhac"
                rows="4"><?php echo isset($phac_do['lieu_nhac']) ? htmlspecialchars(trim($phac_do['lieu_nhac'])) : ''; ?></textarea>
        </div>
    </div>

    <div class="uk-margin">
        <label class="uk-form-label" for="ghi_chu">Ghi chú:</label>
        <div class="uk-form-controls">
            <textarea class="uk-textarea" id="ghi_chu" name="ghi_chu"
                rows="4"><?php echo isset($phac_do['ghi_chu']) ? htmlspecialchars(trim($phac_do['ghi_chu'])) : ''; ?></textarea>
        </div>
    </div>

    <div class="uk-margin">
        <button class="uk-button uk-button-primary" type="submit">Cập nhật phác đồ tiêm</button>
        <a href="index.php?page=phac-do-tiem-list" class="uk-button uk-button-default">Quay lại</a>
    </div>
</form>