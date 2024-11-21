<?php
require_once 'controllers/danh_muc_benh_controller.php';
$danh_muc_benh_controller = new DanhMucBenhController($conn);

$id = isset($_GET['id']) ? $_GET['id'] : null;
$danh_muc = $danh_muc_benh_controller->getDanhMucBenhById($id);

if (!$danh_muc) {
    echo "Danh mục bệnh không tồn tại.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $danh_muc_benh_controller->updateDanhMucBenh($id, $_POST['ten_danh_muc']);

    if ($result) {
        header("Location: index.php?page=danh-muc-benh-list&message=edit_success");
        exit();
    } else {
        $message = 'Có lỗi xảy ra khi cập nhật danh mục bệnh!';
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

<form class="uk-form-stacked" action="index.php?page=danh-muc-benh-edit&id=<?php echo $id; ?>" method="POST">
    <div class="uk-margin">
        <label class="uk-form-label" for="ten_danh_muc">Tên danh mục:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="ten_danh_muc" name="ten_danh_muc" type="text"
                value="<?php echo htmlspecialchars($danh_muc['ten_danh_muc']); ?>" required>
        </div>
    </div>
    <button class="uk-button uk-button-primary" type="submit">Cập nhật danh mục</button>
</form>