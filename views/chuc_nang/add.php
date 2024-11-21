<?php
require_once 'controllers/chuc_nang_controller.php';
$chuc_nang_controller = new ChucNangController($conn);

$message = '';
$status = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $chuc_nang_controller->addChucNang($_POST['ten_chuc_nang'], $_POST['mo_ta'], $_POST['duong_dan']);
    if ($result) {
        header("Location: index.php?page=chuc-nang-list&message=add_success");
        exit();
    } else {
        $message = 'Có lỗi xảy ra khi thêm chức năng!';
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

<form class="uk-form-stacked" action="index.php?page=chuc-nang-add" method="POST">
    <div class="uk-margin">
        <label class="uk-form-label" for="ten_chuc_nang">Tên chức năng:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="ten_chuc_nang" name="ten_chuc_nang" type="text" required>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="mo_ta">Mô tả:</label>
        <div class="uk-form-controls">
            <textarea class="uk-textarea" id="mo_ta" name="mo_ta" rows="3"></textarea>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="duong_dan">Đường dẫn:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="duong_dan" name="duong_dan" type="text">
        </div>
    </div>
    <button class="uk-button uk-button-primary" type="submit">Thêm chức năng</button>
</form>