<?php
require_once 'controllers/dieu_kien_tiem_controller.php';
$dieu_kien_tiem_controller = new DieuKienTiemController($conn);

$message = '';
$status = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $dieu_kien_tiem_controller->addDieuKienTiem($_POST['ten_dieu_kien'], $_POST['mo_ta_dieu_kien']);
    if ($result) {
        header("Location: index.php?page=dieu-kien-tiem-list&message=add_success");
        exit();
    } else {
        $message = 'Có lỗi xảy ra khi thêm điều kiện tiêm!';
        $status = 'danger';
    }
}
?>

<?php if ($message): ?>
    <div class="uk-alert-<?php echo $status; ?>" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <p><?php echo $message; ?></p>
    </div>
<?php endif; ?>

<form class="uk-form-stacked" action="index.php?page=dieu-kien-tiem-add" method="POST">
    <div class="uk-margin">
        <label class="uk-form-label" for="ten_dieu_kien">Tên điều kiện:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="ten_dieu_kien" name="ten_dieu_kien" type="text" required>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="mo_ta_dieu_kien">Mô tả điều kiện:</label>
        <div class="uk-form-controls">
            <textarea class="uk-textarea" id="mo_ta_dieu_kien" name="mo_ta_dieu_kien" rows="5" required></textarea>
        </div>
    </div>
    <button class="uk-button uk-button-primary" type="submit">Thêm điều kiện tiêm</button>
</form>