<?php
require_once 'controllers/lieu_luong_tiem_controller.php';
$lieu_luong_tiem_controller = new LieuLuongTiemController($conn);

$id = isset($_GET['id']) ? $_GET['id'] : null;
$lieu_luong_tiem = $lieu_luong_tiem_controller->getLieuLuongTiemById($id);

if (!$lieu_luong_tiem) {
    echo "Liều lượng tiêm không tồn tại.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $lieu_luong_tiem_controller->updateLieuLuongTiem($id, $_POST['mo_ta']);

    if ($result) {
        header("Location: index.php?page=lieu-luong-tiem-list&message=edit_success");
        exit();
    } else {
        $message = 'Có lỗi xảy ra khi cập nhật liều lượng tiêm!';
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

<form class="uk-form-stacked" action="index.php?page=lieu-luong-tiem-edit&id=<?php echo $id; ?>" method="POST">
    <div class="uk-margin">
        <label class="uk-form-label" for="mo_ta">Mô tả:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="mo_ta" name="mo_ta" type="text"
                value="<?php echo htmlspecialchars($lieu_luong_tiem['mo_ta']); ?>" required>
        </div>
    </div>
    <button class="uk-button uk-button-primary" type="submit">Cập nhật liều lượng tiêm</button>
</form>