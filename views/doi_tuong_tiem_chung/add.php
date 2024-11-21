<?php
require_once 'controllers/doi_tuong_tiem_chung_controller.php';
$doi_tuong_controller = new DoiTuongTiemChungController($conn);

$message = '';
$status = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $doi_tuong_controller->addDoiTuong($_POST['ten_doi_tuong']);
    if ($result) {
        header("Location: index.php?page=doi-tuong-tiem-chung-list&message=add_success");
        exit();
    } else {
        $message = 'Có lỗi xảy ra khi thêm đối tượng tiêm chủng!';
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

<form class="uk-form-stacked" action="index.php?page=doi-tuong-tiem-chung-add" method="POST">
    <div class="uk-margin">
        <label class="uk-form-label" for="ten_doi_tuong">Tên đối tượng:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="ten_doi_tuong" name="ten_doi_tuong" type="text" required>
        </div>
    </div>
    <button class="uk-button uk-button-primary" type="submit">Thêm đối tượng</button>
</form>