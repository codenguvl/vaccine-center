<?php
require_once 'controllers/khachhang_controller.php';
$khachhang_controller = new KhachHangController($conn);
$khachhang_list = $khachhang_controller->getAllKhachHang();

// Handle delete action
if (isset($_POST['action']) && $_POST['action'] == 'delete' && isset($_POST['id'])) {
    $result = $khachhang_controller->deleteKhachHang($_POST['id']);
    if ($result) {
        $success_message = "Xóa khách hàng thành công.";
        $khachhang_list = $khachhang_controller->getAllKhachHang();
    } else {
        $error_message = "Có lỗi xảy ra khi xóa khách hàng.";
    }
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

<!-- Form lọc -->
<form method="POST" action="" class="uk-form-stacked">
    <div class="uk-margin">
        <label class="uk-form-label" for="benh_id">Bệnh</label>
        <div class="uk-form-controls">
            <select name="benh_id" id="benh_id" class="uk-select">
                <option value="">Chọn bệnh</option>
                <?php foreach ($vaccine_controller->getAllBenh() as $benh): ?>
                    <option value="<?php echo $benh['benh_id']; ?>"><?php echo htmlspecialchars($benh['ten_benh']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="uk-margin">
        <label class="uk-form-label" for="danh_muc_id">Danh mục bệnh</label>
        <div class="uk-form-controls">
            <select name="danh_muc_id" id="danh_muc_id" class="uk-select">
                <option value="">Chọn danh mục</option>
                <?php foreach ($vaccine_controller->getAllDanhMuc() as $danh_muc): ?>
                    <option value="<?php echo $danh_muc['danh_muc_id']; ?>">
                        <?php echo htmlspecialchars($danh_muc['ten_danh_muc']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="uk-margin">
        <label class="uk-form-label" for="doi_tuong_id">Đối tượng tiêm chủng</label>
        <div class="uk-form-controls">
            <select name="doi_tuong_id" id="doi_tuong_id" class="uk-select">
                <option value="">Chọn đối tượng</option>
                <?php foreach ($vaccine_controller->getAllDoiTuong() as $doi_tuong): ?>
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
                <?php foreach ($vaccine_controller->getAllLuaTuoi() as $lua_tuoi): ?>
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
                <?php foreach ($vaccine_controller->getAllDieuKien() as $dieu_kien): ?>
                    <option value="<?php echo $dieu_kien['dieu_kien_id']; ?>">
                        <?php echo htmlspecialchars($dieu_kien['ten_dieu_kien']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <button type="submit" name="filter" class="uk-button uk-button-primary">Lọc</button>
</form>

<a href="index.php?page=khach-hang-add" class="uk-button uk-button-primary uk-margin-bottom">Thêm Khách hàng mới</a>

<table id="khachhang-table" class="uk-table uk-table-hover uk-table-striped">
    <thead>
        <tr>
            <th>Họ và tên</th>
            <th>CCCD</th>
            <th>Ngày sinh</th>
            <th>Giới tính</th>
            <th>Điện thoại</th>
            <th>Địa chỉ</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($khachhang_list as $khachhang): ?>
            <tr>
                <td><?php echo htmlspecialchars($khachhang['fullname']); ?></td>
                <td><?php echo htmlspecialchars($khachhang['cccd']); ?></td>
                <td><?php echo htmlspecialchars($khachhang['ngaysinh']); ?></td>
                <td><?php echo htmlspecialchars($khachhang['gioitinh']); ?></td>
                <td><?php echo htmlspecialchars($khachhang['dienthoai']); ?></td>
                <td><?php echo htmlspecialchars($khachhang['diachi']); ?></td>
                <td>
                    <a href="index.php?page=khach-hang-edit&id=<?php echo htmlspecialchars($khachhang['khachhang_id']); ?>"
                        class="uk-button uk-button-primary uk-button-small">Sửa</a>
                    <button class="uk-button uk-button-danger uk-button-small"
                        onclick="openDeleteModal('<?php echo htmlspecialchars($khachhang['khachhang_id']); ?>')">Xóa</button>
                    <a href="index.php?page=khach-hang-history&id=<?php echo htmlspecialchars($khachhang['khachhang_id']); ?>"
                        class="uk-button uk-button-secondary uk-button-small">Lịch sử</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<!-- Modal xác nhận xóa -->
<div id="delete-modal" class="uk-modal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title">Xác nhận xóa</h2>
        <p>Bạn có chắc chắn muốn xóa khách hàng này?</p>
        <form id="delete-form" method="POST" action="index.php?page=khach-hang-list">
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
    $(document).ready(function () {
        $('#khachhang-table').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/vi.json' // Ngôn ngữ tiếng Việt
            },
            pageLength: 10, // Hiển thị 10 dòng mỗi trang
            responsive: true // Tự động điều chỉnh giao diện
        });
    });

    // Mở modal xác nhận xóa
    function openDeleteModal(id) {
        document.getElementById('delete-id').value = id;
        UIkit.modal('#delete-modal').show();
    }
</script>