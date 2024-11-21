<?php
require_once 'controllers/danh_muc_benh_controller.php';
$danh_muc_benh_controller = new DanhMucBenhController($conn);

$message = '';
$status = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $danh_muc_benh_controller->addDanhMucBenh($_POST['ten_danh_muc']);
    if ($result) {
        header("Location: index.php?page=danh-muc-benh-list&message=add_success");
        exit();
    } else {
        $message = 'Có lỗi xảy ra khi thêm danh mục bệnh!';
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

<form class="uk-form-stacked" action="index.php?page=danh-muc-benh-add" method="POST">
    <div class="uk-margin">
        <label class="uk-form-label" for="ten_danh_muc">Tên danh mục:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="ten_danh_muc" name="ten_danh_muc" type="text" required>
        </div>
    </div>
    <button class="uk-button uk-button-primary" type="submit">Thêm danh mục</button>
</form>