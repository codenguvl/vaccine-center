<?php
require_once 'controllers/chuc_nang_controller.php';
$chuc_nang_controller = new ChucNangController($conn);

$id = isset($_GET['id']) ? $_GET['id'] : null;
$chuc_nang = $chuc_nang_controller->getChucNangById($id);

if (!$chuc_nang) {
    echo "Chức năng không tồn tại.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $chuc_nang_controller->updateChucNang($id, $_POST['ten_chuc_nang'], $_POST['mo_ta'], $_POST['duong_dan']);

    if ($result) {
        header("Location: index.php?page=chuc-nang-list&message=edit_success");
        exit();
    } else {
        $message = 'Có lỗi xảy ra khi cập nhật chức năng: ' . error_get_last()['message'];
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

<form class="uk-form-stacked" action="index.php?page=chuc-nang-edit&id=<?php echo $id; ?>" method="POST">
    <div class="uk-margin">
        <label class="uk-form-label" for="ten_chuc_nang">Tên chức năng:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="ten_chuc_nang" name="ten_chuc_nang" type="text"
                value="<?php echo htmlspecialchars($chuc_nang['ten_chuc_nang']); ?>" required>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="mo_ta">Mô tả:</label>
        <div class="uk-form-controls">
            <textarea class="uk-textarea" id="mo_ta" name="mo_ta"
                rows="3"><?php echo htmlspecialchars($chuc_nang['mo_ta']); ?></textarea>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="duong_dan">Đường dẫn:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="duong_dan" name="duong_dan" type="text"
                value="<?php echo htmlspecialchars($chuc_nang['duong_dan']); ?>">
        </div>
    </div>
    <button class="uk-button uk-button-primary" type="submit">Cập nhật chức năng</button>
</form>