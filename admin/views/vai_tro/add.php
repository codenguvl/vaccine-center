<?php
require_once 'controllers/vai_tro_controller.php';
$vai_tro_controller = new VaiTroController($conn);

$message = '';
$status = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $chuc_nang_ids = isset($_POST['chuc_nang']) ? $_POST['chuc_nang'] : [];
    $result = $vai_tro_controller->addVaiTro($_POST['ten_vai_tro'], $_POST['mo_ta'], $chuc_nang_ids);
    if ($result) {
        header("Location: index.php?page=vai-tro-list&message=add_success");
        exit();
    } else {
        $message = 'Có lỗi xảy ra khi thêm vai trò!';
        $status = 'danger';
    }
}

$all_chuc_nang = $vai_tro_controller->getAllChucNang();

$grouped_chuc_nang = [];
foreach ($all_chuc_nang as $chuc_nang) {
    $name = $chuc_nang['ten_chuc_nang'];
    // Bỏ từ đầu tiên (Xem/Thêm/Sửa)
    $parts = explode(' ', $name);
    array_shift($parts);
    $module = implode(' ', $parts); // Ghép các từ còn lại
    if (!isset($grouped_chuc_nang[$module])) {
        $grouped_chuc_nang[$module] = [];
    }
    $grouped_chuc_nang[$module][] = $chuc_nang;
}
?>
<?php if ($message): ?>
<div class="uk-alert-<?php echo $status; ?>" uk-alert>
    <a class="uk-alert-close" uk-close></a>
    <p><?php echo $message; ?></p>
</div>
<?php endif; ?>
<form class="uk-form-stacked" action="index.php?page=vai-tro-add" method="POST">
    <div class="uk-margin">
        <label class="uk-form-label" for="ten_vai_tro">Tên vai trò:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="ten_vai_tro" name="ten_vai_tro" type="text" required>
        </div>
    </div>

    <div class="uk-margin">
        <label class="uk-form-label" for="mo_ta">Mô tả:</label>
        <div class="uk-form-controls">
            <textarea class="uk-textarea" id="mo_ta" name="mo_ta" rows="3"></textarea>
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
                            value="<?php echo $chuc_nang['id']; ?>">
                        <?php echo $chuc_nang['ten_chuc_nang']; ?>
                    </label><br>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <button class="uk-button uk-button-primary" type="submit">Thêm vai trò</button>
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