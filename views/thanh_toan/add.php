<?php
require_once 'controllers/thanh_toan_controller.php';
require_once 'controllers/lich_hen_controller.php';
require_once 'controllers/dat_coc_controller.php';
require_once 'controllers/khachhang_controller.php';
require_once 'controllers/vaccine_controller.php';

$thanh_toan_controller = new ThanhToanController($conn);
$lich_hen_controller = new LichHenController($conn);
$dat_coc_controller = new DatCocController($conn);
$khachhang_controller = new KhachHangController($conn);
$vaccine_controller = new VaccineController($conn);

// Lấy ID lịch hẹn từ URL nếu có
$lich_hen_id = isset($_GET['lich_hen_id']) ? $_GET['lich_hen_id'] : null;
$is_direct_payment = !$lich_hen_id;

// Xử lý tìm kiếm khách hàng cho thanh toán trực tiếp
if ($is_direct_payment) {
    if (isset($_GET['search'])) {
        $search_term = $_GET['search'];
        $khach_hang_list = $khachhang_controller->searchKhachHang($search_term);
    } else {
        $khach_hang_list = $khachhang_controller->getAllKhachHang();
    }
    $vaccine_list = $vaccine_controller->getAllVaccine();
} else {
    // Xử lý thanh toán từ lịch hẹn
    $lich_hen = $lich_hen_controller->getLichHenById($lich_hen_id);

    // Kiểm tra xem đã có thanh toán chưa
    $existing_payment = $thanh_toan_controller->getThanhToanByLichHen($lich_hen_id);
    if ($existing_payment) {
        header("Location: index.php?page=thanh-toan-edit&id=" . $existing_payment['thanh_toan_id']);
        exit();
    }

    if (!$lich_hen || empty($lich_hen['dat_coc_id'])) {
        $_SESSION['error_message'] = "Không tìm thấy thông tin lịch hẹn hoặc chưa đặt cọc.";
        header("Location: index.php?page=lich-hen-list");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if ($is_direct_payment) {
            // Kiểm tra xem có tiêm ngay không
            $tiem_ngay = isset($_POST['tiem_ngay']) && $_POST['tiem_ngay'] == 1;

            // Validate dữ liệu
            if (!$tiem_ngay && (empty($_POST['ngay_hen']) || empty($_POST['gio_hen']))) {
                throw new Exception("Vui lòng nhập đầy đủ ngày giờ hẹn");
            }

            // Xử lý thanh toán trực tiếp
            $result = $thanh_toan_controller->addThanhToanAndLichTiem(
                $_POST['khachhang_id'],
                $_POST['vaccine_id'],
                $_POST['so_tien'],
                $tiem_ngay ? null : $_POST['ngay_hen'],
                $tiem_ngay ? null : $_POST['gio_hen'],
                $_POST['ghi_chu'] ?? '',
                $tiem_ngay
            );
        } else {
            $result = $thanh_toan_controller->addThanhToan(
                $lich_hen_id,
                $lich_hen['dat_coc_id']
            );

            if ($result) {
                // Cập nhật trạng thái lịch hẹn thành hoàn thành
                $lich_hen_controller->updateLichHen(
                    $lich_hen_id,
                    $lich_hen['khachhang_id'],
                    $lich_hen['ngay_hen'],
                    $lich_hen['gio_hen'],
                    'hoan_thanh',
                    $lich_hen['ghi_chu'],
                    $lich_hen['dat_coc_id']
                );
            }
        }

        if ($result) {
            $_SESSION['success_message'] = "Tạo thanh toán thành công!";
            header("Location: index.php?page=thanh-toan-list");
            exit();
        }
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}

?>


<?php if (isset($error_message)): ?>
    <div class="uk-alert-danger" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <p><?php echo $error_message; ?></p>
    </div>
<?php endif; ?>

<?php if ($is_direct_payment): ?>
    <!-- Form thanh toán trực tiếp -->
    <form class="uk-form-stacked" action="index.php?page=thanh-toan-add" method="POST">
        <input type="hidden" name="payment_type" value="direct">

        <div class="uk-margin">
            <label class="uk-form-label" for="khachhang_id">Khách hàng:</label>
            <div class="uk-form-controls">
                <div class="uk-inline uk-width-1-1">
                    <input class="uk-input" type="text" id="search_khachhang"
                        placeholder="Tìm kiếm theo số điện thoại hoặc CCCD...">
                </div>
                <select class="uk-select uk-margin-small-top" id="khachhang_id" name="khachhang_id" required>
                    <option value="">Chọn khách hàng</option>
                    <?php foreach ($khach_hang_list as $khach_hang): ?>
                        <option value="<?php echo $khach_hang['khachhang_id']; ?>">
                            <?php echo htmlspecialchars($khach_hang['fullname'] . ' - SĐT: ' . $khach_hang['dienthoai'] . ' - CCCD: ' . $khach_hang['cccd']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="vaccine_id">Vaccine:</label>
            <div class="uk-form-controls">
                <select class="uk-select" id="vaccine_id" name="vaccine_id" required onchange="updatePrice()">
                    <option value="">Chọn vaccine</option>
                    <?php foreach ($vaccine_list as $vaccine): ?>
                        <option value="<?php echo $vaccine['vaccin_id']; ?>" data-price="<?php echo $vaccine['gia_tien']; ?>">
                            <?php echo htmlspecialchars($vaccine['ten_vaccine'] . ' - ' . number_format($vaccine['gia_tien'], 0, ',', '.') . ' VNĐ'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="so_tien">Số tiền thanh toán:</label>
            <div class="uk-form-controls">
                <input class="uk-input" type="number" id="so_tien" name="so_tien" required readonly>
            </div>
        </div>

        <div class="uk-margin">
            <label>
                <input class="uk-checkbox" type="checkbox" name="tiem_ngay" value="1" checked
                    onchange="toggleScheduleFields(this.checked)"> Tiêm ngay hôm nay
            </label>
        </div>

        <div id="schedule_fields" style="display: none;">
            <div class="uk-margin">
                <label class="uk-form-label" for="ngay_hen">Ngày hẹn:</label>
                <div class="uk-form-controls">
                    <input class="uk-input" type="date" id="ngay_hen" name="ngay_hen"
                        min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="gio_hen">Giờ hẹn:</label>
                <div class="uk-form-controls">
                    <input class="uk-input" type="time" id="gio_hen" name="gio_hen">
                </div>
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="ghi_chu">Ghi chú:</label>
            <div class="uk-form-controls">
                <textarea class="uk-textarea" id="ghi_chu" name="ghi_chu" rows="3"></textarea>
            </div>
        </div>

    <?php else: ?>
        <!-- Form thanh toán từ lịch hẹn -->
        <div class="uk-card uk-card-default uk-card-body uk-margin">
            <h3 class="uk-card-title">Thông tin thanh toán</h3>
            <dl class="uk-description-list">
                <dt>Khách hàng:</dt>
                <dd><?php echo htmlspecialchars($lich_hen['fullname']); ?></dd>

                <dt>Vaccine:</dt>
                <dd><?php echo htmlspecialchars($lich_hen['ten_vaccine']); ?></dd>

                <dt>Ngày hẹn:</dt>
                <dd><?php echo date('d/m/Y', strtotime($lich_hen['ngay_hen'])); ?></dd>

                <dt>Giờ hẹn:</dt>
                <dd><?php echo date('H:i', strtotime($lich_hen['gio_hen'])); ?></dd>

                <dt>Giá vaccine:</dt>
                <dd><?php echo number_format($lich_hen['gia_tien'], 0, ',', '.'); ?> VNĐ</dd>

                <dt>Số tiền đã đặt cọc:</dt>
                <dd><?php echo number_format($lich_hen['so_tien_dat_coc'], 0, ',', '.'); ?> VNĐ</dd>

                <dt>Số tiền cần thanh toán:</dt>
                <dd class="uk-text-bold uk-text-danger">
                    <?php echo number_format($lich_hen['gia_tien'] - $lich_hen['so_tien_dat_coc'], 0, ',', '.'); ?> VNĐ
                </dd>
            </dl>
        </div>

        <form class="uk-form-stacked" action="index.php?page=thanh-toan-add&lich_hen_id=<?php echo $lich_hen_id; ?>"
            method="POST">
            <input type="hidden" name="confirm_payment" value="1">
        <?php endif; ?>

        <div class="uk-margin uk-text-center">
            <button class="uk-button uk-button-primary" type="submit">
                <?php echo $is_direct_payment ? 'Tạo thanh toán và lịch tiêm' : 'Xác nhận thanh toán'; ?>
            </button>
            <a class="uk-button uk-button-default"
                href="<?php echo $is_direct_payment ? 'index.php?page=thanh-toan-list' : 'index.php?page=lich-hen-list'; ?>">Hủy</a>
        </div>
    </form>

    <script>
        function searchKhachHang(search_term) {
            if (search_term.length >= 2) {
                fetch(`index.php?page=thanh-toan-add&search=${search_term}`)
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newSelect = doc.querySelector('#khachhang_id');
                        const currentSelect = document.querySelector('#khachhang_id');
                        if (newSelect && currentSelect) {
                            currentSelect.innerHTML = newSelect.innerHTML;
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        }

        function updatePrice() {
            const vaccineSelect = document.getElementById('vaccine_id');
            const priceInput = document.getElementById('so_tien');

            if (vaccineSelect.value) {
                const selectedOption = vaccineSelect.options[vaccineSelect.selectedIndex];
                const price = parseFloat(selectedOption.dataset.price);
                priceInput.value = price;
            } else {
                priceInput.value = '';
            }
        }

        function toggleScheduleFields(tiem_ngay) {
            const scheduleFields = document.getElementById('schedule_fields');
            const ngayHenInput = document.getElementById('ngay_hen');
            const gioHenInput = document.getElementById('gio_hen');

            scheduleFields.style.display = tiem_ngay ? 'none' : 'block';

            if (tiem_ngay) {
                ngayHenInput?.removeAttribute('required');
                gioHenInput?.removeAttribute('required');
            } else {
                ngayHenInput?.setAttribute('required', 'required');
                gioHenInput?.setAttribute('required', 'required');
            }
        }

        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        const debouncedSearch = debounce(searchKhachHang, 300);

        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search_khachhang');
            if (searchInput) {
                searchInput.addEventListener('input', (e) => {
                    debouncedSearch(e.target.value);
                });
            }

            if (document.getElementById('vaccine_id')) {
                updatePrice();
            }

            const tiemNgayCheckbox = document.querySelector('input[name="tiem_ngay"]');
            if (tiemNgayCheckbox) {
                toggleScheduleFields(tiemNgayCheckbox.checked);
            }
        });
    </script>