<?php
require_once 'controllers/lich_hen_controller.php';
$lich_hen_controller = new LichHenController($conn);
$lich_hen_list = $lich_hen_controller->getAllLichHen();

if (isset($_POST['action']) && $_POST['action'] == 'delete' && isset($_POST['id'])) {
    $result = $lich_hen_controller->deleteLichHen($_POST['id']);
    if ($result) {
        $success_message = "Xóa lịch hẹn thành công.";
        $lich_hen_list = $lich_hen_controller->getAllLichHen();
    } else {
        $error_message = "Có lỗi xảy ra khi xóa lịch hẹn.";
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'update_status' && isset($_POST['id'])) {
    $trang_thai = $_POST['trang_thai'];

    // Sử dụng phương thức mới để cập nhật trạng thái
    $result = $lich_hen_controller->updateLichHenStatus($_POST['id'], $trang_thai);
    if ($result) {
        $success_message = "Cập nhật trạng thái lịch hẹn thành công.";
        $lich_hen_list = $lich_hen_controller->getAllLichHen();
    } else {
        $error_message = "Có lỗi xảy ra khi cập nhật trạng thái lịch hẹn.";
    }
}
?>




<?php if (isset($error_message)): ?>
<div class="uk-alert-danger" uk-alert>
    <a class="uk-alert-close" uk-close></a>
    <p><?php echo $error_message; ?></p>
</div>
<?php endif; ?>

<?php if (isset($success_message)): ?>
<div class="uk-alert-success" uk-alert>
    <a class="uk-alert-close" uk-close></a>
    <p><?php echo $success_message; ?></p>
</div>
<?php endif; ?>

<a href="index.php?page=lich-hen-add" class="uk-button uk-button-primary uk-margin-bottom">Thêm Lịch hẹn mới</a>
<!-- Thay đổi trong phần header của bảng -->
<table id="lichHenTable" class="uk-table uk-table-hover uk-table-striped">
    <thead>
        <tr>
            <th>Khách hàng</th>
            <th>Điện thoại</th>
            <th>Ngày hẹn</th>
            <th>Thời gian</th> <!-- Đổi từ "Giờ hẹn" thành "Thời gian" -->
            <th>Trạng thái</th>
            <th>Vaccine</th>
            <th>Tiền đặt cọc</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($lich_hen_list as $lich_hen): ?>
        <tr data-id="<?php echo $lich_hen['lich_hen_id']; ?>">
            <td><?php echo htmlspecialchars($lich_hen['fullname']); ?></td>
            <td><?php echo htmlspecialchars($lich_hen['dienthoai']); ?></td>
            <td><?php echo date('d/m/Y', strtotime($lich_hen['ngay_hen'])); ?></td>
            <td>
                <?php
                    echo date('H:i', strtotime($lich_hen['gio_bat_dau'])) . ' - ' .
                        date('H:i', strtotime($lich_hen['gio_ket_thuc']));
                    ?>
            </td>
            <td>
                <?php
                    $status_class = '';
                    switch ($lich_hen['trang_thai']) {
                        case 'cho_xac_nhan':
                            $status_class = 'uk-label-warning';
                            $status_text = 'Chờ xác nhận';
                            break;
                        case 'da_xac_nhan':
                            $status_class = 'uk-label-success';
                            $status_text = 'Đã xác nhận';
                            break;
                        case 'da_huy':
                            $status_class = 'uk-label-danger';
                            $status_text = 'Đã hủy';
                            break;
                        case 'hoan_thanh':
                            $status_class = 'uk-label-primary';
                            $status_text = 'Hoàn thành';
                            break;
                    }
                    ?>
                <span class="uk-label <?php echo $status_class; ?> status-text"><?php echo $status_text; ?></span>
            </td>
            <td><?php echo htmlspecialchars($lich_hen['ten_vaccine'] ?? 'Không có'); ?></td>
            <td>
                <?php if (isset($lich_hen['so_tien_dat_coc'])): ?>
                <?php echo number_format($lich_hen['so_tien_dat_coc'], 0, ',', '.'); ?> VNĐ
                <?php else: ?>
                Chưa đặt cọc
                <?php endif; ?>
            </td>


            <td>
                <!-- Biểu tượng cho các hành động -->
                <button class="uk-button uk-button-small uk-button-default" uk-tooltip="title: Hành động; pos: bottom"
                    uk-icon="icon: more; ratio: 1.5"
                    uk-toggle="target: #actions-<?php echo $lich_hen['lich_hen_id']; ?>"></button>


                <?php
                    require_once 'controllers/thanh_toan_controller.php';
                    $thanh_toan_controller = new ThanhToanController($conn);
                    $thanh_toan = $thanh_toan_controller->getThanhToanByLichHen($lich_hen['lich_hen_id']);
                    ?>
                <!-- Dropdown chứa các hành động -->
                <div id="actions-<?php echo $lich_hen['lich_hen_id']; ?>" class="uk-dropdown"
                    uk-dropdown="mode: click; pos: bottom-right">
                    <ul class="uk-nav uk-dropdown-nav">
                        <?php if (!$thanh_toan && $lich_hen['trang_thai'] == 'da_xac_nhan'): ?>
                        <li><a href="index.php?page=thanh-toan-add&lich_hen_id=<?php echo $lich_hen['lich_hen_id']; ?>">Tạo
                                thanh
                                toán</a></li>
                        <?php elseif ($thanh_toan): ?>
                        <li><a href="index.php?page=thanh-toan-edit&id=<?php echo $thanh_toan['thanh_toan_id']; ?>">Xem
                                thanh
                                toán</a></li>
                        <?php endif; ?>
                        <li><a href="index.php?page=lich-hen-edit&id=<?php echo $lich_hen['lich_hen_id']; ?>">Sửa</a>
                        </li>
                        <li><a href="javascript:void(0)"
                                onclick="openDeleteModal('<?php echo $lich_hen['lich_hen_id']; ?>')">Xóa</a></li>
                        <li><a href="javascript:void(0)"
                                onclick="openUpdateStatusModal('<?php echo $lich_hen['lich_hen_id']; ?>')">Cập nhật
                                trạng thái</a></li>
                        <li><a href="javascript:void(0)"
                                onclick="sendReminder('<?php echo $lich_hen['dienthoai']; ?>', '<?php echo $lich_hen['email']; ?>', '<?php echo $lich_hen['ngay_hen']; ?>', '<?php echo $lich_hen['gio_bat_dau']; ?>')">Gửi
                                nhắc nhở</a></li>
                    </ul>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Modal cập nhật trạng thái lịch hẹn -->
<div id="update-status-modal" class="uk-modal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title">Cập nhật trạng thái lịch hẹn</h2>
        <form id="update-status-form" method="POST" action="index.php?page=lich-hen-list">
            <input type="hidden" name="action" value="update_status">
            <input type="hidden" name="id" id="update-status-id" value="">
            <div class="uk-margin">
                <label class="uk-form-label" for="trang_thai">Trạng thái</label>
                <select class="uk-select" name="trang_thai" id="trang_thai" required>
                    <option value="cho_xac_nhan">Chờ xác nhận</option>
                    <option value="da_xac_nhan">Đã xác nhận</option>
                    <option value="da_huy">Đã hủy</option>
                    <option value="hoan_thanh">Hoàn thành</option>
                </select>
            </div>
            <p class="uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close" type="button">Hủy</button>
                <button class="uk-button uk-button-primary" type="submit">Cập nhật</button>
            </p>
        </form>
    </div>
</div>

<!-- Thêm modal thông báo kết quả gửi SMS -->
<div id="sms-result-modal" class="uk-modal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title">Kết quả gửi SMS</h2>
        <p id="sms-result-message"></p>
        <p class="uk-text-right">
            <button class="uk-button uk-button-default uk-modal-close" type="button">Đóng</button>
        </p>
    </div>
</div>
<!-- Modal xác nhận xóa -->
<div id="delete-modal" class="uk-modal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title">Xác nhận xóa</h2>
        <p>Bạn có chắc chắn muốn xóa lịch hẹn này?</p>
        <form id="delete-form" method="POST" action="index.php?page=lich-hen-list">
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
function openUpdateStatusModal(id) {
    document.getElementById('update-status-id').value = id;

    // Lấy trạng thái hiện tại của lịch hẹn
    const statusElement = document.querySelector(`#lichHenTable tr[data-id='${id}'] .status-text`);
    const currentStatus = statusElement ? statusElement.textContent.trim() : '';

    // Map giá trị văn bản trạng thái sang giá trị value của dropdown
    const statusMapping = {
        'Chờ xác nhận': 'cho_xac_nhan',
        'Đã xác nhận': 'da_xac_nhan',
        'Đã hủy': 'da_huy',
        'Hoàn thành': 'hoan_thanh'
    };

    // Tìm giá trị value tương ứng
    const mappedValue = statusMapping[currentStatus] || '';

    // Thiết lập giá trị cho dropdown
    const statusSelect = document.getElementById('trang_thai');
    statusSelect.value = mappedValue;

    UIkit.modal('#update-status-modal').show();
}


function openDeleteModal(id) {
    document.getElementById('delete-id').value = id;
    UIkit.modal('#delete-modal').show();
}

function sendReminder(phone, email, date, time) {
    // Kiểm tra nếu email không có
    if (!email) {
        // Nếu không có email, hiển thị thông báo lỗi
        Swal.fire({
            title: 'Lỗi!',
            text: 'Khách hàng này không có email.',
            icon: 'error',
            confirmButtonText: 'Đóng'
        });
        return; // Dừng lại nếu không có email
    }

    const message = `Nhắc nhở: Bạn có lịch hẹn vào ngày ${date} lúc ${time}.`;

    // Hiển thị xác nhận gửi nhắc nhở nếu có email
    Swal.fire({
        title: 'Xác nhận gửi nhắc nhở?',
        text: `Bạn có chắc chắn muốn gửi nhắc nhở tới ${email}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Gửi',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            // Hiển thị loading khi đang gửi yêu cầu
            Swal.fire({
                title: 'Đang gửi...',
                text: 'Vui lòng chờ...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Gửi yêu cầu AJAX
            fetch('ajax/send_reminder.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        email: email,
                        message: message
                    })
                })
                .then(response => response.json())
                .then(data => {
                    Swal.close(); // Đóng loading
                    if (data.status === 'success') {
                        Swal.fire(
                            'Thành công!',
                            'Nhắc nhở đã được gửi.',
                            'success'
                        );
                    } else {
                        Swal.fire(
                            'Lỗi!',
                            'Có lỗi xảy ra khi gửi nhắc nhở.',
                            'error'
                        );
                    }
                })
                .catch(error => {
                    Swal.close(); // Đóng loading
                    Swal.fire(
                        'Lỗi!',
                        'Có lỗi xảy ra khi gửi nhắc nhở.',
                        'error'
                    );
                });
        }
    });
}
</script>

<script>
$(document).ready(function() {
    // Khởi tạo DataTables cho bảng "Đối tượng tiêm chủng"
    $('#lichHenTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/vi.json'
        },
        "pageLength": 10,
        "lengthMenu": [5, 10, 25, 50],
        "order": []
    });
});

document.querySelectorAll('[uk-toggle]').forEach(function(element) {
    element.addEventListener('click', function() {
        var targetId = this.getAttribute('uk-toggle').split(':')[1].trim();
        var dropdown = document.querySelector(targetId);
        if (dropdown) {
            dropdown.classList.toggle('uk-active');
        }
    });
});

document.addEventListener('click', function(e) {
    if (!e.target.closest('[uk-toggle]') && !e.target.closest('.uk-dropdown')) {
        document.querySelectorAll('.uk-dropdown').forEach(function(dropdown) {
            dropdown.classList.remove('uk-active');
        });
    }
});
</script>