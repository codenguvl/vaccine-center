<?php
require_once 'controllers/vaccine_controller.php';
require_once 'controllers/benh_controller.php';
require_once 'controllers/danh_muc_benh_controller.php';
require_once 'controllers/doi_tuong_tiem_chung_controller.php';
require_once 'controllers/lua_tuoi_controller.php';
require_once 'controllers/dieu_kien_tiem_controller.php';
$vaccine_controller = new VaccineController($conn);
$benh_controller = new BenhController($conn);
$danh_muc_benh_controller = new DanhMucBenhController($conn);
$doi_tuong_tiem_chung_controller = new DoiTuongTiemChungController($conn);
$lua_tuoi_controller = new LuaTuoiController($conn);
$dieu_kien_tiem_controlle = new DieuKienTiemController($conn);
$vaccine_list = $vaccine_controller->getAllVaccine();

if (isset($_POST['action']) && $_POST['action'] == 'delete' && isset($_POST['id'])) {
    $result = $vaccine_controller->deleteVaccine($_POST['id']);
    if ($result) {
        $success_message = "Xóa vaccine thành công.";
        $vaccine_list = $vaccine_controller->getAllVaccine();
    } else {
        $error_message = "Có lỗi xảy ra khi xóa vaccine.";
    }
}

$active_filters = [];
$filter_names = [];
if (isset($_POST['filter'])) {
    $filters = [
        'benh_id' => $_POST['benh_id'] ?? null,
        'danh_muc_id' => $_POST['danh_muc_id'] ?? null,
        'doi_tuong_id' => $_POST['doi_tuong_id'] ?? null,
        'lua_tuoi_id' => $_POST['lua_tuoi_id'] ?? null,
        'dieu_kien_id' => $_POST['dieu_kien_id'] ?? null,
    ];
    foreach ($filters as $key => $value) {
        if ($value) {
            $active_filters[$key] = $value;
        }
    }
    if (!empty($_POST['danh_muc_id'])) {
        $active_filters['danh_muc_id'] = $_POST['danh_muc_id'];
        $filter_names['danh_muc_id'] = $danh_muc_benh_controller->getDanhMucBenhById($_POST['danh_muc_id']); // Lấy tên danh mục
    }
    if (!empty($_POST['benh_id'])) {
        $active_filters['benh_id'] = $_POST['benh_id'];
        $filter_names['benh_id'] = $benh_controller->getBenhById($_POST['benh_id']); // Lấy tên bệnh
    }
    if (!empty($_POST['doi_tuong_id'])) {
        $active_filters['doi_tuong_id'] = $_POST['doi_tuong_id'];
        $filter_names['doi_tuong_id'] = $doi_tuong_tiem_chung_controller->getDoiTuongById($_POST['doi_tuong_id']); // Lấy tên đối tượng
    }
    if (!empty($_POST['lua_tuoi_id'])) {
        $active_filters['lua_tuoi_id'] = $_POST['lua_tuoi_id'];
        $filter_names['lua_tuoi_id'] = $lua_tuoi_controller->getLuaTuoiById($_POST['lua_tuoi_id']); // Lấy tên lứa tuổi
    }
    if (!empty($_POST['dieu_kien_id'])) {
        $active_filters['dieu_kien_id'] = $_POST['dieu_kien_id'];
        $filter_names['dieu_kien_id'] = $dieu_kien_tiem_controlle->getDieuKienTiemById($_POST['dieu_kien_id']); // Lấy tên điều kiện
    }
    $vaccine_list = $vaccine_controller->getFilteredVaccines($filters);
}
?>


<?php if (isset($success_message)): ?>
    <div class="uk-alert-success" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <p><?php echo $success_message; ?></p>
    </div>
<?php endif; ?>

<?php if (isset($error_message)): ?>
    <div class="uk-alert-danger" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <p><?php echo $error_message; ?></p>
    </div>
<?php endif; ?>
<!-- Modal lọc -->
<div id="filter-modal" class="uk-modal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title">Lọc Vaccine</h2>
        <form method="POST" action="" class="uk-form-stacked">
            <div class="uk-margin">
                <label class="uk-form-label" for="danh_muc_id">Danh mục bệnh</label>
                <div class="uk-form-controls">
                    <select name="danh_muc_id" id="danh_muc_id" class="uk-select">
                        <option value="">Chọn danh mục</option>
                        <?php foreach ($danh_muc_benh_controller->getAllDanhMucBenh() as $danh_muc): ?>
                            <option value="<?php echo $danh_muc['danh_muc_id']; ?>">
                                <?php echo htmlspecialchars($danh_muc['ten_danh_muc']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="uk-form-controls">
                <select name="benh_id" id="benh_id" class="uk-select" disabled>
                    <option value="">Chọn bệnh</option>
                    <?php foreach ($benh_controller->getAllBenh() as $benh): ?>
                        <option value="<?php echo $benh['benh_id']; ?>">
                            <?php echo htmlspecialchars($benh['ten_benh']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="doi_tuong_id">Đối tượng tiêm chủng</label>
                <div class="uk-form-controls">
                    <select name="doi_tuong_id" id="doi_tuong_id" class="uk-select">
                        <option value="">Chọn đối tượng</option>
                        <?php foreach ($doi_tuong_tiem_chung_controller->getAllDoiTuong() as $doi_tuong): ?>
                            <option value="<?php echo $doi_tuong['doi_tuong_id']; ?>">
                                <?php echo htmlspecialchars($doi_tuong['ten_doi_tuong']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="lua_tuoi_id">Lứa tuổi</label>
                <div class="uk-form-controls">
                    <select name="lua_tuoi_id" id="lua_tuoi_id" class="uk-select">
                        <option value="">Chọn lứa tuổi</option>
                        <?php foreach ($lua_tuoi_controller->getAllLuaTuoi() as $lua_tuoi): ?>
                            <option value="<?php echo $lua_tuoi['lua_tuoi_id']; ?>">
                                <?php echo htmlspecialchars($lua_tuoi['ten_lua_tuoi']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="dieu_kien_id">Điều kiện tiêm</label>
                <div class="uk-form-controls">
                    <select name="dieu_kien_id" id="dieu_kien_id" class="uk-select">
                        <option value="">Chọn điều kiện</option>
                        <?php foreach ($dieu_kien_tiem_controlle->getAllDieuKienTiem() as $dieu_kien): ?>
                            <option value="<?php echo $dieu_kien['dieu_kien_id']; ?>">
                                <?php echo htmlspecialchars($dieu_kien['ten_dieu_kien']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="uk-flex uk-flex-between ">
                <button type="submit" name="filter" class="uk-button uk-button-primary">Lọc</button>
                <button class="uk-button uk-button-default uk-modal-close" type="button">Đóng</button>
            </div>
        </form>

    </div>
</div>



<div class="uk-flex uk-flex-between uk-margin-bottom">
    <a href="index.php?page=vaccine-add" class="uk-button uk-button-primary">Thêm Vaccine mới</a>
    <button class="uk-button uk-button-primary" onclick="UIkit.modal('#filter-modal').show()">Lọc</button>
</div>

<?php if (!empty($filter_names)): ?>
    <div class="uk-margin">
        <div class="uk-badge uk-margin-small-right">Danh mục:
            <?php echo isset($filter_names['danh_muc_id']['ten_danh_muc']) ? htmlspecialchars($filter_names['danh_muc_id']['ten_danh_muc']) : 'N/A'; ?>
        </div>
        <div class="uk-badge uk-margin-small-right">Bệnh:
            <?php echo isset($filter_names['benh_id']['ten_benh']) ? htmlspecialchars($filter_names['benh_id']['ten_benh']) : 'N/A'; ?>
        </div>
        <div class="uk-badge uk-margin-small-right">Đối tượng:
            <?php echo isset($filter_names['doi_tuong_id']['ten_doi_tuong']) ? htmlspecialchars($filter_names['doi_tuong_id']['ten_doi_tuong']) : 'N/A'; ?>
        </div>
        <div class="uk-badge uk-margin-small-right">Lứa tuổi:
            <?php echo isset($filter_names['lua_tuoi_id']['ten_lua_tuoi']) ? htmlspecialchars($filter_names['lua_tuoi_id']['ten_lua_tuoi']) : 'N/A'; ?>
        </div>
        <div class="uk-badge uk-margin-small-right">Điều kiện:
            <?php echo isset($filter_names['dieu_kien_id']['ten_dieu_kien']) ? htmlspecialchars($filter_names['dieu_kien_id']['ten_dieu_kien']) : 'N/A'; ?>
        </div>
        <div class="uk-badge uk-margin-small-right uk-background-default">
            <a href="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
                Reset bộ lọc
            </a>
        </div>

    </div>

<?php endif; ?>



<table class="uk-table uk-table-hover uk-table-striad" id="vaccine-table">
    <thead>
        <tr>
            <th>Tên vaccine</th>
            <th>Nhà SX</th>
            <th>Loại</th>
            <th>Số lô</th>
            <th>NSX</th>
            <th>HSD</th>
            <th>Giá tiền</th>
            <th>Số lượng</th>
            <th>Bệnh</th>
            <th>Đối tượng</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($vaccine_list as $vaccine): ?>
            <tr>
                <td><?php echo htmlspecialchars($vaccine['ten_vaccine']); ?></td>
                <td><?php echo htmlspecialchars($vaccine['nha_san_xuat']); ?></td>
                <td><?php
                echo ($vaccine['loai_vaccine'] == 'tiem_mot_lan') ? 'Tiêm một lần' :
                    (($vaccine['loai_vaccine'] == 'tiem_nhac_lai') ? 'Tiêm nhắc lại' : 'N/A');
                ?></td>

                <td><?php echo htmlspecialchars($vaccine['so_lo_san_xuat']); ?></td>
                <td><?php echo date('d-m-Y', strtotime($vaccine['ngay_san_xuat'])); ?></td>
                <td><?php echo date('d-m-Y', strtotime($vaccine['han_su_dung'])); ?></td>
                <td><?php echo number_format($vaccine['gia_tien'], 0, ',', '.'); ?> đ</td>
                <td><?php echo htmlspecialchars($vaccine['so_luong']); ?></td>
                <td><?php echo htmlspecialchars($vaccine['ten_benh']); ?></td>
                <td><?php echo htmlspecialchars($vaccine['ten_doi_tuong']); ?></td>
                <td>
                    <a href="index.php?page=vaccine-edit&id=<?php echo htmlspecialchars($vaccine['vaccin_id']); ?>"
                        class="uk-button uk-button-primary uk-button-small">Sửa</a>
                    <button class="uk-button uk-button-danger uk-button-small"
                        onclick="openDeleteModal('<?php echo htmlspecialchars($vaccine['vaccin_id']); ?>')">Xóa</button>
                    <a href="index.php?page=vaccine-detail&id=<?php echo htmlspecialchars($vaccine['vaccin_id']); ?>"
                        class="uk-button uk-button-secondary uk-button-small">Xem chi tiết</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Modal xác nhận xóa -->
<div id="delete-modal" class="uk-modal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title">Xác nhận xóa</h2>
        <p>Bạn có chắc chắn muốn xóa vaccine này?</p>
        <form id="delete-form" method="POST" action="index.php?page=vaccine-list">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="id" id="delete-id" value="">
            <p class="uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close" type="button">Hủy</button>
                <button class="uk-button uk-button-danger" type="submit">Xóa</button>
            </p>
        </form>
    </div>
</div>

<script>
    function openDeleteModal(id) {
        document.getElementById('delete-id').value = id;
        UIkit.modal('#delete-modal').show();
    }
    $(document).ready(function () {
        $('#vaccine-table').DataTable({
            "language": {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/vi.json' // Đổi ngôn ngữ sang tiếng Việt
            },
            "paging": true, // Enable pagination
            "searching": true, // Enable search functionality
            "ordering": true, // Enable column sorting
            "info": true, // Show table information (e.g., "Showing 1 to 10 of 100 entries")
        });
    });
</script>

<script>
    function openDeleteModal(id) {
        document.getElementById('delete-id').value = id;
        UIkit.modal('#delete-modal').show();
    }
    $(document).ready(function () {
        // Bắt sự kiện khi danh mục bệnh thay đổi
        $('#danh_muc_id').change(function () {
            var danh_muc_id = $(this).val();
            var benhDropdown = $('#benh_id');

            if (danh_muc_id) {
                // Bỏ trạng thái disabled khi danh mục được chọn
                benhDropdown.prop('disabled', false);

                // Gọi AJAX để cập nhật danh sách bệnh
                $.ajax({
                    url: 'ajax/getBenhByDanhMucId.php', // Đường dẫn đến file xử lý
                    type: 'POST',
                    data: {
                        danh_muc_id: danh_muc_id
                    },
                    success: function (data) {
                        benhDropdown.html(data); // Cập nhật dropdown bệnh
                    }
                });
            } else {
                // Reset dropdown bệnh và đặt lại trạng thái disabled
                benhDropdown.html('<option value="">Chọn bệnh</option>');
                benhDropdown.prop('disabled', true);
            }
        });
    });
</script>