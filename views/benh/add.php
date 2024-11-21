<?php
require_once 'controllers/benh_controller.php';
require_once 'controllers/danh_muc_benh_controller.php';

$benh_controller = new BenhController($conn);
$danh_muc_benh_controller = new DanhMucBenhController($conn);
$danh_muc_list = $danh_muc_benh_controller->getAllDanhMucBenh();

$message = '';
$status = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $benh_controller->addBenh($_POST['ten_benh'], $_POST['danh_muc_id']);
    if ($result) {
        header("Location: index.php?page=benh-list&message=add_success");
        exit();
    } else {
        $message = 'Có lỗi xảy ra khi thêm bệnh!';
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

<form class="uk-form-stacked" action="index.php?page=benh-add" method="POST">
    <div class="uk-margin">
        <label class="uk-form-label" for="ten_benh">Tên bệnh:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="ten_benh" name="ten_benh" type="text" required>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="danh_muc_id">Danh mục bệnh:</label>
        <div class="uk-form-controls">
            <select class="uk-select" id="danh_muc_id" name="danh_muc_id" required>
                <option value="">Chọn danh mục</option>
                <?php foreach ($danh_muc_list as $danh_muc): ?>
                    <option value="<?php echo $danh_muc['danh_muc_id']; ?>">
                        <?php echo htmlspecialchars($danh_muc['ten_danh_muc']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <button class="uk-button uk-button-primary" type="submit">Thêm bệnh</button>
</form>