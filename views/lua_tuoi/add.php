<?php
require_once 'controllers/lua_tuoi_controller.php';
$lua_tuoi_controller = new LuaTuoiController($conn);

$message = '';
$status = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $lua_tuoi_controller->addLuaTuoi($_POST['mo_ta']);
    if ($result) {
        header("Location: index.php?page=lua-tuoi-list&message=add_success");
        exit();
    } else {
        $message = 'Có lỗi xảy ra khi thêm lứa tuổi!';
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

<form class="uk-form-stacked" action="index.php?page=lua-tuoi-add" method="POST">
    <div class="uk-margin">
        <label class="uk-form-label" for="mo_ta">Mô tả:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="mo_ta" name="mo_ta" type="text" required>
        </div>
    </div>
    <button class="uk-button uk-button-primary" type="submit">Thêm lứa tuổi</button>
</form>