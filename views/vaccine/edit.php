<?php
require_once 'controllers/vaccine_controller.php';
require_once 'controllers/benh_controller.php';
require_once 'controllers/doi_tuong_tiem_chung_controller.php';
require_once 'controllers/phac_do_tiem_controller.php';
require_once 'controllers/dieu_kien_tiem_controller.php';

$vaccine_controller = new VaccineController($conn);
$benh_controller = new BenhController($conn);
$doi_tuong_controller = new DoiTuongTiemChungController($conn);
$phac_do_controller = new PhacDoTiemController($conn);
$dieu_kien_controller = new DieuKienTiemController($conn);

$id = isset($_GET['id']) ? $_GET['id'] : null;
$vaccine = $vaccine_controller->getVaccineById($id);

if (!$vaccine) {
    echo "Vaccine không tồn tại.";
    exit;
}

$benh_list = $benh_controller->getAllBenh();
$doi_tuong_list = $doi_tuong_controller->getAllDoiTuong();
$phac_do_list = $phac_do_controller->getAllPhacDoTiem();
$dieu_kien_list = $dieu_kien_controller->getAllDieuKienTiem();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = $vaccine_controller->validateData($_POST);
    
    if (empty($errors)) {
        $result = $vaccine_controller->updateVaccine($id, $_POST);
        if ($result) {
            header("Location: index.php?page=vaccine-list&message=edit_success");
            exit();
        } else {
            $message = 'Có lỗi xảy ra khi cập nhật vaccine!';
            $status = 'danger';
        }
    }
}
?>

<?php if (isset($message)): ?>
<div class="uk-alert-<?php echo $status; ?>" uk-alert>
    <a class="uk-alert-close" uk-close></a>
    <p><?php echo $message; ?></p>
</div>
<?php endif; ?>

<?php if (!empty($errors)): ?>
<div class="uk-alert-warning" uk-alert>
    <a class="uk-alert-close" uk-close></a>
    <ul>
        <?php foreach ($errors as $error): ?>
        <li><?php echo $error; ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<form class="uk-form-stacked" action="" method="POST">
    <div class="uk-grid-small" uk-grid>
        <!-- Thông tin cơ bản -->
        <div class="uk-width-1-2@s">
            <div class="uk-margin">
                <label class="uk-form-label" for="ten_vaccine">Tên vaccine:</label>
                <div class="uk-form-controls">
                    <input class="uk-input" id="ten_vaccine" name="ten_vaccine" type="text"
                        value="<?php echo htmlspecialchars($vaccine['ten_vaccine']); ?>" required>
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="nha_san_xuat">Nhà sản xuất:</label>
                <div class="uk-form-controls">
                    <input class="uk-input" id="nha_san_xuat" name="nha_san_xuat" type="text"
                        value="<?php echo htmlspecialchars($vaccine['nha_san_xuat']); ?>" required>
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="loai_vaccine">Loại vaccine:</label>
                <div class="uk-form-controls">
                    <select class="uk-select" id="loai_vaccine" name="loai_vaccine" required>
                        <option value="tiem_mot_lan"
                            <?php echo $vaccine['loai_vaccine'] == 'tiem_mot_lan' ? 'selected' : ''; ?>>
                            Tiêm một lần
                        </option>
                        <option value="tiem_nhac_lai"
                            <?php echo $vaccine['loai_vaccine'] == 'tiem_nhac_lai' ? 'selected' : ''; ?>>
                            Tiêm nhắc lại
                        </option>
                    </select>
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="so_lo_san_xuat">Số lô sản xuất:</label>
                <div class="uk-form-controls">
                    <input class="uk-input" id="so_lo_san_xuat" name="so_lo_san_xuat" type="text"
                        value="<?php echo htmlspecialchars($vaccine['so_lo_san_xuat']); ?>" required>
                </div>
            </div>
        </div>

        <!-- Thông tin thời gian và số lượng -->
        <div class="uk-width-1-2@s">
            <div class="uk-margin">
                <label class="uk-form-label" for="ngay_san_xuat">Ngày sản xuất:</label>
                <div class="uk-form-controls">
                    <input class="uk-input" id="ngay_san_xuat" name="ngay_san_xuat" type="date"
                        value="<?php echo $vaccine['ngay_san_xuat']; ?>" required>
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="han_su_dung">Hạn sử dụng:</label>
                <div class="uk-form-controls">
                    <input class="uk-input" id="han_su_dung" name="han_su_dung" type="date"
                        value="<?php echo $vaccine['han_su_dung']; ?>" required>
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="ngay_nhap">Ngày nhập:</label>
                <div class="uk-form-controls">
                    <input class="uk-input" id="ngay_nhap" name="ngay_nhap" type="date"
                        value="<?php echo $vaccine['ngay_nhap']; ?>" required>
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="gia_tien">Giá tiền:</label>
                <div class="uk-form-controls">
                    <input class="uk-input" id="gia_tien" name="gia_tien" type="number" step="0.01"
                        value="<?php echo $vaccine['gia_tien']; ?>" required>
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="so_luong">Số lượng:</label>
                <div class="uk-form-controls">
                    <input class="uk-input" id="so_luong" name="so_luong" type="number"
                        value="<?php echo $vaccine['so_luong']; ?>" required>
                </div>
            </div>
        </div>

        <!-- Thông tin mô tả và ghi chú -->
        <div class="uk-width-1-1">
            <div class="uk-margin">
                <label class="uk-form-label" for="mo_ta">Mô tả:</label>
                <div class="uk-form-controls">
                    <textarea class="uk-textarea" id="mo_ta" name="mo_ta"
                        rows="4"><?php echo htmlspecialchars($vaccine['mo_ta']); ?></textarea>
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="ghi_chu">Ghi chú:</label>
                <div class="uk-form-controls">
                    <textarea class="uk-textarea" id="ghi_chu" name="ghi_chu"
                        rows="4"><?php echo htmlspecialchars($vaccine['ghi_chu']); ?></textarea>
                </div>
            </div>
        </div>

        <!-- Thông tin liên kết -->
        <div class="uk-width-1-2@s">
            <div class="uk-margin">
                <label class="uk-form-label" for="benh_id">Bệnh:</label>
                <div class="uk-form-controls">
                    <select class="uk-select" id="benh_id" name="benh_id">
                        <option value="">Chọn bệnh</option>
                        <?php foreach ($benh_list as $benh): ?>
                        <option value="<?php echo $benh['benh_id']; ?>"
                            <?php echo $benh['benh_id'] == $vaccine['benh_id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($benh['ten_benh']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="doi_tuong_id">Đối tượng tiêm chủng:</label>
                <div class="uk-form-controls">
                    <select class="uk-select" id="doi_tuong_id" name="doi_tuong_id">
                        <option value="">Chọn đối tượng</option>
                        <?php foreach ($doi_tuong_list as $doi_tuong): ?>
                        <option value="<?php echo $doi_tuong['doi_tuong_id']; ?>"
                            <?php echo $doi_tuong['doi_tuong_id'] == $vaccine['doi_tuong_id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($doi_tuong['ten_doi_tuong']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="uk-width-1-2@s">
            <div class="uk-margin">
                <label class="uk-form-label" for="phac_do_id">Phác đồ tiêm:</label>
                <div class="uk-form-controls">
                    <select class="uk-select" id="phac_do_id" name="phac_do_id">
                        <option value="">Chọn phác đồ</option>
                        <?php foreach ($phac_do_list as $phac_do): ?>
                        <option value="<?php echo $phac_do['phac_do_id']; ?>"
                            <?php echo $phac_do['phac_do_id'] == $vaccine['phac_do_id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($phac_do['ten_phac_do']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="dieu_kien_id">Điều kiện tiêm:</label>
                <div class="uk-form-controls">
                    <select class="uk-select" id="dieu_kien_id" name="dieu_kien_id">
                        <option value="">Chọn điều kiện</option>
                        <?php foreach ($dieu_kien_list as $dieu_kien): ?>
                        <option value="<?php echo $dieu_kien['dieu_kien_id']; ?>"
                            <?php echo $dieu_kien['dieu_kien_id'] == $vaccine['dieu_kien_id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($dieu_kien['ten_dieu_kien']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="uk-margin">
        <button class="uk-button uk-button-primary" type="submit">Cập nhật vaccine</button>
        <a href="index.php?page=vaccine-list" class="uk-button uk-button-default">Quay lại</a>
    </div>
</form>