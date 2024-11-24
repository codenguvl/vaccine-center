<?php
require_once 'controllers/lua_tuoi_controller.php';
$lua_tuoi_controller = new LuaTuoiController($conn);

$message = '';
$status = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $lua_tuoi_controller->addLuaTuoi($_POST['ten_lua_tuoi'], $_POST['mo_ta']);
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
        <label class="uk-form-label" for="ten_lua_tuoi">Tên lứa tuổi:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="ten_lua_tuoi" name="ten_lua_tuoi" type="text" required>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="mo_ta">Mô tả:</label>
        <div class="uk-form-controls">
            <textarea class="uk-textarea" id="mo_ta" name="mo_ta" required></textarea>
        </div>
    </div>
    <button class="uk-button uk-button-primary" type="submit">Thêm lứa tuổi</button>
</form>
<script>
CKEDITOR.replace('mo_ta');
</script>