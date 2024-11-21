<?php
require_once 'controllers/vai_tro_controller.php';
$vai_tro_controller = new VaiTroController($conn);

$id = isset($_GET['id']) ? $_GET['id'] : null;
error_log("Requested vai_tro id: " . $id);

$vai_tro = $vai_tro_controller->getVaiTroById($id);

if (!$vai_tro) {
    error_log("Vai tro not found for id: " . $id);
    echo "Vai trò không tồn tại.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $chuc_nang_ids = isset($_POST['chuc_nang']) ? $_POST['chuc_nang'] : [];
    $result = $vai_tro_controller->updateVaiTro($id, $_POST['ten_vai_tro'], $_POST['mo_ta'], $chuc_nang_ids);

    if ($result) {
        $vai_tro = $vai_tro_controller->getVaiTroById($id);
        if (!$vai_tro) {
            error_log("Vai tro not found after update for id: " . $id);
            echo "Có lỗi xảy ra sau khi cập nhật vai trò.";
            exit;
        }
        $message = 'Cập nhật vai trò thành công.';
        $status = 'success';
    } else {
        $message = 'Có lỗi xảy ra khi cập nhật vai trò.';
        $status = 'danger';
    }
}

$all_chuc_nang = $vai_tro_controller->getAllChucNang();
$selected_chuc_nang = $vai_tro_controller->getChucNangForVaiTro($id);

if (is_array($selected_chuc_nang)) {
    $selected_chuc_nang_ids = array_column($selected_chuc_nang, 'id');
} else {
    $selected_chuc_nang_ids = [];
}

// Nhóm các chức năng
$grouped_chuc_nang = [];
foreach ($all_chuc_nang as $chuc_nang) {
    $name = $chuc_nang['ten_chuc_nang'];
    $parts = explode(' ', $name);
    array_shift($parts);
    $module = implode(' ', $parts);
    if (!isset($grouped_chuc_nang[$module])) {
        $grouped_chuc_nang[$module] = [];
    }
    $grouped_chuc_nang[$module][] = $chuc_nang;
}
?>

<?php if (isset($message)): ?>
<div class="uk-alert-<?php echo $status; ?>" uk-alert>
    <a class="uk-alert-close" uk-close></a>
    <p><?php echo $message; ?></p>
</div>
<?php endif; ?>

<form class="uk-form-stacked" action="index.php?page=vai-tro-edit&id=<?php echo $id; ?>" method="POST">
    <div class="uk-margin">
        <label class="uk-form-label" for="ten_vai_tro">Tên vai trò:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="ten_vai_tro" name="ten_vai_tro" type="text"
                value="<?php echo htmlspecialchars($vai_tro['ten_vai_tro']); ?>" required>
        </div>
    </div>

    <div class="uk-margin">
        <label class="uk-form-label" for="mo_ta">Mô tả:</label>
        <div class="uk-form-controls">
            <textarea class="uk-textarea" id="mo_ta" name="mo_ta"
                rows="3"><?php echo htmlspecialchars($vai_tro['mo_ta']); ?></textarea>
        </div>
    </div>

    <div class="uk-margin">
        <label class="uk-form-label">Chức năng:</label>
        <button type="button" class="uk-button uk-button-default uk-margin-small-bottom" id="checkAll">Chọn tất
            cả</button>

        <div class="uk-grid-small uk-child-width-1-3@s" uk-grid>
            <?php foreach ($grouped_chuc_nang as $module => $chuc_nangs): ?>
            <div>
                <h4 class="uk-badge"><?php echo ucfirst($module); ?></h4>
                <div class="uk-form-controls uk-form-controls-text">
                    <?php foreach ($chuc_nangs as $chuc_nang): ?>
                    <label>
                        <input class="uk-checkbox chuc-nang-checkbox" type="checkbox" name="chuc_nang[]"
                            value="<?php echo $chuc_nang['id']; ?>"
                            <?php echo in_array($chuc_nang['id'], $selected_chuc_nang_ids) ? 'checked' : ''; ?>>
                        <?php echo $chuc_nang['ten_chuc_nang']; ?>
                    </label><br>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <button class="uk-button uk-button-primary" type="submit">Cập nhật vai trò</button>
</form>

<script>
document.getElementById('checkAll').addEventListener('click', function() {
    var checkboxes = document.getElementsByClassName('chuc-nang-checkbox');
    var isChecked = this.getAttribute('data-checked') === 'true';

    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = !isChecked;
    }

    this.setAttribute('data-checked', (!isChecked).toString());
    this.textContent = isChecked ? 'Chọn tất cả' : 'Bỏ chọn tất cả';
});
</script>

<style>
.uk-first-column h4 {
    text-transform: capitalize;
    font-size: 14px;
    margin-bottom: 5px;
    padding: 10px 10px;
}

.uk-first-column h4::first-letter {
    text-transform: uppercase;
}
</style>