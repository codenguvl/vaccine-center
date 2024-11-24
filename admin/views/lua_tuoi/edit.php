<?php
require_once 'controllers/lua_tuoi_controller.php';
$lua_tuoi_controller = new LuaTuoiController($conn);

$id = isset($_GET['id']) ? $_GET['id'] : null;
$lua_tuoi = $lua_tuoi_controller->getLuaTuoiById($id);

if (!$lua_tuoi) {
    echo "Lứa tuổi không tồn tại.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $lua_tuoi_controller->updateLuaTuoi($id, $_POST['ten_lua_tuoi'], $_POST['mo_ta']);

    if ($result) {
        header("Location: index.php?page=lua-tuoi-list&message=edit_success");
        exit();
    } else {
        $message = 'Có lỗi xảy ra khi cập nhật lứa tuổi!';
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

<form class="uk-form-stacked" action="index.php?page=lua-tuoi-edit&id=<?php echo $id; ?>" method="POST">
    <div class="uk-margin">
        <label class="uk-form-label" for="ten_lua_tuoi">Tên lứa tuổi:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="ten_lua_tuoi" name="ten_lua_tuoi" type="text"
                value="<?php echo htmlspecialchars($lua_tuoi['ten_lua_tuoi']); ?>" required>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="mo_ta">Mô tả:</label>
        <div class="uk-form-controls">

            <textarea class="uk-textarea" id="mo_ta" name="mo_ta"
                required><?php echo htmlspecialchars($lua_tuoi['mo_ta']); ?></textarea>
        </div>
    </div>
    <button class="uk-button uk-button-primary" type="submit">Cập nhật lứa tuổi</button>
</form>
<script>
CKEDITOR.replace('mo_ta');
</script>