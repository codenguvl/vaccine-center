<?php
require_once 'controllers/lich_tiem_controller.php';
require_once 'controllers/phan_ung_sau_tiem_controller.php';
$lich_tiem_controller = new LichTiemController($conn);
$lich_tiem_list = $lich_tiem_controller->getAllLichTiem();
$phan_ung_controller = new PhanUngSauTiemController($conn);


if (isset($_POST['action']) && $_POST['action'] == 'delete' && isset($_POST['id'])) {
    $result = $lich_tiem_controller->deleteLichTiem($_POST['id']);
    if ($result) {
        $success_message = "Xóa lịch tiêm thành công.";
        $lich_tiem_list = $lich_tiem_controller->getAllLichTiem();
    } else {
        $error_message = "Có lỗi xảy ra khi xóa lịch tiêm.";
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'update_status' && isset($_POST['id'])) {
    $result = $lich_tiem_controller->capNhatTrangThaiTiem(
        $_POST['id'],
        $_POST['trang_thai'],
        $_POST['ghi_chu']
    );
    if ($result) {
        $success_message = "Cập nhật trạng thái tiêm thành công.";
        $lich_tiem_list = $lich_tiem_controller->getAllLichTiem();
    } else {
        $error_message = "Có lỗi xảy ra khi cập nhật trạng thái.";
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'add_phan_ung') {
    try {
        $result = $phan_ung_controller->addPhanUng(
            $_POST['lich_tiem_id'],
            $_POST['phan_ung'],
            $_POST['muc_do'],
            $_POST['ghi_chu']
        );
        if ($result) {
            $success_message = "Ghi nhận phản ứng sau tiêm thành công.";
        }
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}

$lich_tiem_phan_ung = [];
foreach ($lich_tiem_list as $lich_tiem) {
    if ($lich_tiem['trang_thai'] === 'da_tiem') {
        $phan_ung = $phan_ung_controller->getPhanUngByLichTiem($lich_tiem['lich_tiem_id']);
        if (!empty($phan_ung)) {
            $lich_tiem_phan_ung[$lich_tiem['lich_tiem_id']] = $phan_ung;
        }
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

<a href="index.php?page=lich-tiem-add" class="uk-button uk-button-primary uk-margin-bottom">Thêm Lịch tiêm mới</a>

<table id="lichTiemTable" class="display uk-table uk-table-hover uk-table-striped">
    <thead>
        <tr>
            <th>Khách hàng</th>
            <th>Điện thoại</th>
            <th>Vaccine</th>
            <th>Ngày tiêm</th>
            <th>Lần tiêm</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($lich_tiem_list as $lich_tiem): ?>
            <tr>
                <td><?php echo htmlspecialchars($lich_tiem['fullname'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($lich_tiem['dienthoai'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($lich_tiem['ten_vaccine'] ?? ''); ?></td>
                <td><?php echo date('d-m-Y', strtotime($lich_tiem['ngay_tiem'])); ?></td>
                <td><?php echo htmlspecialchars($lich_tiem['lan_tiem'] ?? ''); ?></td>
                <td>
                    <?php
                    $status_class = '';
                    $status_text = 'Không xác định';

                    if (isset($lich_tiem['trang_thai'])) {
                        switch ($lich_tiem['trang_thai']) {
                            case 'cho_tiem':
                                $status_class = 'uk-label-warning';
                                $status_text = 'Chờ tiêm';
                                break;
                            case 'da_tiem':
                                $status_class = 'uk-label-success';
                                $status_text = 'Đã tiêm';
                                break;
                            case 'huy':
                                $status_class = 'uk-label-danger';
                                $status_text = 'Hủy';
                                break;
                        }
                    }
                    ?>
                    <span class="uk-label <?php echo $status_class; ?>"><?php echo $status_text; ?></span>
                </td>
                <td>
                    <!-- Action Dropdown -->
                    <div class="uk-inline">
                        <button class="uk-button uk-button-default uk-button-small" type="button"
                            uk-toggle="target: #action-dropdown-<?php echo htmlspecialchars($lich_tiem['lich_tiem_id'] ?? ''); ?>">
                            <span uk-icon="icon: more"></span>
                        </button>

                        <div id="action-dropdown-<?php echo htmlspecialchars($lich_tiem['lich_tiem_id'] ?? ''); ?>"
                            uk-dropdown="mode: click">
                            <ul class="uk-nav uk-dropdown-nav">
                                <?php if ($lich_tiem['trang_thai'] !== 'da_tiem' && $lich_tiem['trang_thai'] !== 'huy'): ?>
                                    <li><a href="javascript:void(0);"
                                            onclick="openStatusModal('<?php echo htmlspecialchars($lich_tiem['lich_tiem_id'] ?? ''); ?>')">Cập
                                            nhật trạng thái</a></li>
                                <?php endif; ?>

                                <?php if ($lich_tiem['trang_thai'] === 'da_tiem'): ?>
                                    <?php if (isset($lich_tiem_phan_ung[$lich_tiem['lich_tiem_id']])): ?>
                                        <li><a href="javascript:void(0);"
                                                onclick="openViewPhanUngModal('<?php echo htmlspecialchars($lich_tiem['lich_tiem_id'] ?? ''); ?>')">Xem
                                                phản ứng</a></li>
                                    <?php else: ?>
                                        <li><a href="javascript:void(0);"
                                                onclick="openPhanUngModal('<?php echo htmlspecialchars($lich_tiem['lich_tiem_id'] ?? ''); ?>', '<?php echo htmlspecialchars($lich_tiem['fullname'] ?? ''); ?>', '<?php echo htmlspecialchars($lich_tiem['ten_vaccine'] ?? ''); ?>')">Ghi
                                                nhận phản ứng</a></li>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <li><a
                                        href="index.php?page=lich-tiem-edit&id=<?php echo htmlspecialchars($lich_tiem['lich_tiem_id'] ?? ''); ?>">Sửa</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </td>

            </tr>
        <?php endforeach; ?>
    </tbody>

</table>

<!-- Modal xem phản ứng -->
<div id="view-phan-ung-modal" class="uk-modal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title">Thông tin phản ứng sau tiêm</h2>
        <div id="phan-ung-content"></div>
        <p class="uk-text-right">
            <button class="uk-button uk-button-default uk-modal-close" type="button">Đóng</button>
        </p>
    </div>
</div>


<!-- Modal ghi nhận phản ứng -->
<div id="phan-ung-modal" class="uk-modal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title">Ghi nhận phản ứng sau tiêm</h2>
        <form id="phan-ung-form" method="POST" action="index.php?page=lich-tiem-list">
            <input type="hidden" name="action" value="add_phan_ung">
            <input type="hidden" name="lich_tiem_id" id="phan-ung-lich-tiem-id" value="">

            <div class="uk-margin">
                <label class="uk-form-label">Thông tin tiêm:</label>
                <div id="thong-tin-tiem" class="uk-text-meta"></div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="phan_ung">Phản ứng sau tiêm:</label>
                <textarea class="uk-textarea" id="phan_ung" name="phan_ung" rows="3" required></textarea>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="muc_do">Mức độ:</label>
                <select class="uk-select" id="muc_do" name="muc_do" required>
                    <option value="nhe">Nhẹ</option>
                    <option value="trung_binh">Trung bình</option>
                    <option value="nang">Nặng</option>
                </select>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="ghi_chu">Ghi chú:</label>
                <textarea class="uk-textarea" id="ghi_chu" name="ghi_chu" rows="2"></textarea>
            </div>

            <p class="uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close" type="button">Hủy</button>
                <button class="uk-button uk-button-primary" type="submit">Lưu</button>
            </p>
        </form>
    </div>
</div>


<!-- Modal cập nhật trạng thái -->
<div id="status-modal" class="uk-modal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title">Cập nhật trạng thái tiêm</h2>
        <form id="status-form" method="POST" action="index.php?page=lich-tiem-list">
            <input type="hidden" name="action" value="update_status">
            <input type="hidden" name="id" id="status-id" value="">

            <div class="uk-margin">
                <label class="uk-form-label">Trạng thái:</label>
                <select class="uk-select" name="trang_thai" required>
                    <option value="da_tiem">Đã tiêm</option>
                    <option value="huy">Hủy</option>
                </select>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label">Ghi chú:</label>
                <textarea class="uk-textarea" name="ghi_chu" rows="3"></textarea>
            </div>

            <p class="uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close" type="button">Hủy</button>
                <button class="uk-button uk-button-primary" type="submit">Cập nhật</button>
            </p>
        </form>
    </div>
</div>

<!-- Modal xác nhận xóa -->
<div id="delete-modal" class="uk-modal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title">Xác nhận xóa</h2>
        <p>Bạn có chắc chắn muốn xóa lịch tiêm này?</p>
        <form id="delete-form" method="POST" action="index.php?page=lich-tiem-list">
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
    function openStatusModal(id) {
        document.getElementById('status-id').value = id;
        UIkit.modal('#status-modal').show();
    }

    function openDeleteModal(id) {
        document.getElementById('delete-id').value = id;
        UIkit.modal('#delete-modal').show();
    }

    function openPhanUngModal(lichTiemId, tenKhachHang, tenVaccine) {
        document.getElementById('phan-ung-lich-tiem-id').value = lichTiemId;
        document.getElementById('thong-tin-tiem').innerHTML = `
        <p><strong>Khách hàng:</strong> ${tenKhachHang}</p>
        <p><strong>Vaccine:</strong> ${tenVaccine}</p>
    `;
        UIkit.modal('#phan-ung-modal').show();
    }

    // Thêm validation cho form phản ứng
    document.getElementById('phan-ung-form')?.addEventListener('submit', function (e) {
        const phanUng = document.getElementById('phan_ung').value.trim();
        const mucDo = document.getElementById('muc_do').value;

        if (!phanUng || !mucDo) {
            e.preventDefault();
            UIkit.notification({
                message: 'Vui lòng điền đầy đủ thông tin bắt buộc',
                status: 'danger'
            });
        }
    });


    // Thêm vào phần script
    function openViewPhanUngModal(lichTiemId) {
        const phanUngList = <?php echo json_encode($lich_tiem_phan_ung); ?>;
        const phanUngInfo = phanUngList[lichTiemId];

        let content = '<div class="uk-margin">';
        phanUngInfo.forEach(phanUng => {
            const mucDoClass = {
                'nhe': 'uk-text-success',
                'trung_binh': 'uk-text-warning',
                'nang': 'uk-text-danger'
            }[phanUng.muc_do] || '';

            const mucDoText = {
                'nhe': 'Nhẹ',
                'trung_binh': 'Trung bình',
                'nang': 'Nặng'
            }[phanUng.muc_do] || phanUng.muc_do;

            content += `
            <div class="uk-card uk-card-default uk-card-body uk-margin-small">
                <h4>Phản ứng: ${phanUng.phan_ung}</h4>
                <p class="uk-margin-small"><strong class="${mucDoClass}">Mức độ: ${mucDoText}</strong></p>
                <p class="uk-margin-small"><strong>Thời gian:</strong> ${new Date(phanUng.ngay_xu_ly).toLocaleString('vi-VN')}</p>
                ${phanUng.ghi_chu ? `<p class="uk-margin-small"><strong>Ghi chú:</strong> ${phanUng.ghi_chu}</p>` : ''}
            </div>
        `;
        });
        content += '</div>';

        document.getElementById('phan-ung-content').innerHTML = content;
        UIkit.modal('#view-phan-ung-modal').show();
    }

    // Cập nhật lại trang sau khi thêm phản ứng thành công
    document.getElementById('phan-ung-form')?.addEventListener('submit', function (e) {
        const phanUng = document.getElementById('phan_ung').value.trim();
        const mucDo = document.getElementById('muc_do').value;

        if (!phanUng || !mucDo) {
            e.preventDefault();
            UIkit.notification({
                message: 'Vui lòng điền đầy đủ thông tin bắt buộc',
                status: 'danger'
            });
        } else {
            // Thêm một flag để biết form đã được submit thành công
            localStorage.setItem('phanUngSubmitted', 'true');
        }
    });

    // Kiểm tra và reload trang nếu cần
    document.addEventListener('DOMContentLoaded', function () {
        if (localStorage.getItem('phanUngSubmitted')) {
            localStorage.removeItem('phanUngSubmitted');
            location.reload();
        }
    });
</script>

<script>
    $(document).ready(function () {
        $('#lichTiemTable').DataTable({
            // Các tùy chọn bạn có thể thêm nếu cần
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/vi.json" // Hỗ trợ tiếng Việt
            },
            "pageLength": 10, // Số dòng mỗi trang
            "lengthMenu": [5, 10, 25, 50], // Tùy chọn số dòng mỗi trang
            "order": []
        });
    });
</script>