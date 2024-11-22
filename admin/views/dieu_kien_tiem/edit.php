<?php
require_once 'controllers/dieu_kien_tiem_controller.php';
$dieu_kien_tiem_controller = new DieuKienTiemController($conn);

$id = isset($_GET['id']) ? $_GET['id'] : null;
$dieu_kien = $dieu_kien_tiem_controller->getDieuKienTiemById($id);

if (!$dieu_kien) {
    echo "Điều kiện tiêm không tồn tại.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $dieu_kien_tiem_controller->updateDieuKienTiem($id, $_POST['ten_dieu_kien'], $_POST['mo_ta_dieu_kien']);
    if ($result) {
        header("Location: index.php?page=dieu-kien-tiem-list&message=edit_success");
        exit();
    } else {
        $message = 'Có lỗi xảy ra khi cập nhật điều kiện tiêm!';
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

<form class="uk-form-stacked" action="index.php?page=dieu-kien-tiem-edit&id=<?php echo $id; ?>" method="POST">
    <div class="uk-margin">
        <label class="uk-form-label" for="ten_dieu_kien">Tên điều kiện:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="ten_dieu_kien" name="ten_dieu_kien" type="text"
                value="<?php echo htmlspecialchars($dieu_kien['ten_dieu_kien']); ?>" required>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="mo_ta_dieu_kien">Mô tả điều kiện:</label>
        <div class="uk-form-controls">
            <textarea class="uk-textarea" id="mo_ta_dieu_kien" name="mo_ta_dieu_kien" rows="5"
                required><?php echo htmlspecialchars($dieu_kien['mo_ta_dieu_kien']); ?></textarea>
        </div>
    </div>
    <button class="uk-button uk-button-primary" type="submit">Cập nhật điều kiện tiêm</button>
</form>