<?php
require_once 'controllers/doi_tuong_tiem_chung_controller.php';
$doi_tuong_controller = new DoiTuongTiemChungController($conn);

$id = isset($_GET['id']) ? $_GET['id'] : null;
$doi_tuong = $doi_tuong_controller->getDoiTuongById($id);

if (!$doi_tuong) {
    echo "Đối tượng tiêm chủng không tồn tại.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $doi_tuong_controller->updateDoiTuong($id, $_POST['ten_doi_tuong']);
    if ($result) {
        header("Location: index.php?page=doi-tuong-tiem-chung-list&message=edit_success");
        exit();
    } else {
        $message = 'Có lỗi xảy ra khi cập nhật đối tượng tiêm chủng!';
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

<form class="uk-form-stacked" action="index.php?page=doi-tuong-tiem-chung-edit&id=<?php echo $id; ?>" method="POST">
    <div class="uk-margin">
        <label class="uk-form-label" for="ten_doi_tuong">Tên đối tượng:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="ten_doi_tuong" name="ten_doi_tuong" type="text"
                value="<?php echo htmlspecialchars($doi_tuong['ten_doi_tuong']); ?>" required>
        </div>
    </div>
    <button class="uk-button uk-button-primary" type="submit">Cập nhật đối tượng</button>
</form>