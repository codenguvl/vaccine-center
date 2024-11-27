<?php
require_once 'controllers/lich_hen_controller.php';
require_once 'controllers/khachhang_controller.php';
require_once 'controllers/vaccine_controller.php';
require_once 'controllers/dat_coc_controller.php';

$lich_hen_controller = new LichHenController($conn);
$khachhang_controller = new KhachHangController($conn);
$vaccine_controller = new VaccineController($conn);
$dat_coc_controller = new DatCocController($conn);

$id = isset($_GET['id']) ? $_GET['id'] : null;
$lich_hen = $lich_hen_controller->getLichHenById($id);

if (!$lich_hen) {
    echo "Lịch hẹn không tồn tại.";
    exit;
}

// Handle search
if (isset($_GET['search'])) {
    $search_term = $_GET['search'];
    $khach_hang_list = $khachhang_controller->searchKhachHang($search_term);
} else {
    $khach_hang_list = $khachhang_controller->getAllKhachHang();
}

$vaccine_list = $vaccine_controller->getAllVaccine();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $has_deposit = isset($_POST['has_deposit']) && $_POST['has_deposit'] == 1;
    $dat_coc_id = null;

    // Kiểm tra thời gian hợp lệ
    $gio_bat_dau = $_POST['gio_bat_dau'];
    $gio_ket_thuc = $_POST['gio_ket_thuc'];

    if (strtotime($gio_bat_dau) >= strtotime($gio_ket_thuc)) {
        $error_message = "Giờ kết thúc phải sau giờ bắt đầu!";
    } else {
        if ($has_deposit) {
            if (!empty($lich_hen['dat_coc_id'])) {
                $dat_coc_id = $lich_hen['dat_coc_id'];
                // Update existing deposit
                $dat_coc_controller->updateDatCoc(
                    $dat_coc_id,
                    'dat_coc',
                    $_POST['ghi_chu']
                );
            } else {
                // Create new deposit
                $vaccine = $vaccine_controller->getVaccineById($_POST['vaccine_id']);
                $so_tien_dat_coc = $vaccine['gia_tien'] * 0.2;

                $dat_coc_id = $dat_coc_controller->addDatCoc(
                    $_POST['vaccine_id'],
                    20,
                    $so_tien_dat_coc,
                    date('Y-m-d'),
                    'dat_coc',
                    $_POST['ghi_chu']
                );
            }
        }

        $result = $lich_hen_controller->updateLichHen(
            $id,
            $_POST['khachhang_id'],
            $_POST['ngay_hen'],
            $_POST['gio_bat_dau'],
            $_POST['gio_ket_thuc'],
            $_POST['trang_thai'],
            $_POST['ghi_chu'],
            $dat_coc_id
        );

        if ($result) {
            header("Location: index.php?page=lich-hen-list&message=edit_success");
            exit();
        } else {
            $error_message = "Có lỗi xảy ra khi cập nhật lịch hẹn!";
        }
    }
}


$has_deposit = !empty($lich_hen['dat_coc_id']);
?>


<?php if (isset($error_message)): ?>
<div class="uk-alert-danger" uk-alert>
    <a class="uk-alert-close" uk-close></a>
    <p><?php echo $error_message; ?></p>
</div>
<?php endif; ?>

<form class="uk-form-stacked" action="index.php?page=lich-hen-edit&id=<?php echo $id; ?>" method="POST">
    <div class="uk-margin">
        <label class="uk-form-label" for="khachhang_id">Khách hàng:</label>
        <div class="uk-form-controls">
            <div class="uk-inline uk-width-1-1">
                <input class="uk-input" type="text" id="search_khachhang"
                    placeholder="Tìm kiếm theo số điện thoại hoặc CCCD..." autocomplete="off">
                <div id="search_results" class="uk-dropdown"
                    uk-dropdown="mode: click; pos: bottom-left; boundary: viewport; boundary-align: true; auto-update: false; offset: 0; animation: uk-animation-slide-top-small; duration: 100;">
                    <ul class="uk-nav uk-nav-default" style="max-height: 200px; overflow-y: auto;">
                        <!-- Kết quả tìm kiếm sẽ được thêm vào đây -->
                    </ul>
                </div>
            </div>
            <input type="hidden" id="khachhang_id" name="khachhang_id" required
                value="<?php echo $lich_hen['khachhang_id']; ?>">
            <div id="selected_khachhang" class="uk-margin-small-top uk-padding-small uk-background-muted"
                style="display: <?php echo !empty($lich_hen['khachhang_id']) ? 'block' : 'none'; ?>;">
                <?php if (!empty($lich_hen['khachhang_id'])):
                    $khach_hang = $khachhang_controller->getKhachHangById($lich_hen['khachhang_id']);
                    if ($khach_hang):
                        ?>
                <div class="uk-text-small">
                    <div><strong>Tên:</strong> <?php echo htmlspecialchars($khach_hang['fullname']); ?></div>
                    <div><strong>SĐT:</strong> <?php echo htmlspecialchars($khach_hang['dienthoai']); ?></div>
                    <?php if (!empty($khach_hang['cccd'])): ?>
                    <div><strong>CCCD:</strong> <?php echo htmlspecialchars($khach_hang['cccd']); ?></div>
                    <?php endif; ?>
                </div>
                <?php endif; endif; ?>
            </div>
        </div>
    </div>


    <div class="uk-margin">
        <label class="uk-form-label" for="ngay_hen">Ngày hẹn:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="ngay_hen" name="ngay_hen" type="date"
                value="<?php echo htmlspecialchars($lich_hen['ngay_hen']); ?>" required>
        </div>
    </div>

    <div class="uk-margin">
        <label class="uk-form-label">Thời gian hẹn:</label>
        <div class="uk-form-controls uk-grid-small" uk-grid>
            <div class="uk-width-1-2">
                <label class="uk-form-label" for="gio_bat_dau">Giờ bắt đầu:</label>
                <input class="uk-input" id="gio_bat_dau" name="gio_bat_dau" type="time"
                    value="<?php echo htmlspecialchars($lich_hen['gio_bat_dau'] ?? ''); ?>" required>
            </div>
            <div class="uk-width-1-2">
                <label class="uk-form-label" for="gio_ket_thuc">Giờ kết thúc:</label>
                <input class="uk-input" id="gio_ket_thuc" name="gio_ket_thuc" type="time"
                    value="<?php echo htmlspecialchars($lich_hen['gio_ket_thuc'] ?? ''); ?>" required>
            </div>
        </div>
    </div>


    <div class="uk-margin">
        <label class="uk-form-label" for="trang_thai">Trạng thái:</label>
        <div class="uk-form-controls">
            <select class="uk-select" id="trang_thai" name="trang_thai" required>
                <option value="cho_xac_nhan"
                    <?php echo ($lich_hen['trang_thai'] === 'cho_xac_nhan') ? 'selected' : ''; ?>>Chờ
                    xác nhận
                </option>
                <option value="da_xac_nhan"
                    <?php echo ($lich_hen['trang_thai'] === 'da_xac_nhan') ? 'selected' : ''; ?>>Đã
                    xác nhận
                </option>
                <option value="da_huy" <?php echo ($lich_hen['trang_thai'] === 'da_huy') ? 'selected' : ''; ?>>Đã hủy
                </option>
                <option value="hoan_thanh" <?php echo ($lich_hen['trang_thai'] === 'hoan_thanh') ? 'selected' : ''; ?>>
                    Hoàn thành</option>
            </select>
        </div>
    </div>
    <div class="uk-margin">
        <div class="uk-form-controls">
            <label><input class="uk-checkbox" type="checkbox" name="has_deposit" value="1"
                    <?php echo $has_deposit ? 'checked' : ''; ?> <?php echo $has_deposit ? 'disabled' : ''; ?>
                    onchange="toggleVaccineSelect()"> Đặt cọc vaccine</label>
            <?php if ($has_deposit): ?>
            <div class="uk-text-small uk-text-muted">Đã đặt cọc không thể thay đổi</div>
            <?php endif; ?>
        </div>
    </div>

    <div class="uk-margin" id="vaccine_section" style="display: <?php echo $has_deposit ? 'block' : 'none'; ?>;">
        <label class="uk-form-label" for="vaccine_id">Chọn Vaccine:</label>
        <div class="uk-form-controls">
            <select class="uk-select" id="vaccine_id" name="vaccine_id" onchange="calculateDeposit()"
                <?php echo $has_deposit ? 'disabled' : ''; ?>>
                <option value="">Chọn vaccine</option>
                <?php foreach ($vaccine_list as $vaccine): ?>
                <option value="<?php echo $vaccine['vaccin_id']; ?>" data-price="<?php echo $vaccine['gia_tien']; ?>"
                    <?php echo (isset($lich_hen['vaccine_id']) && $lich_hen['vaccine_id'] == $vaccine['vaccin_id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($vaccine['ten_vaccine'] . ' - ' . number_format($vaccine['gia_tien'], 0, ',', '.') . ' VNĐ'); ?>
                </option>
                <?php endforeach; ?>
            </select>
            <div id="deposit_info" class="uk-margin-small-top">
                <?php if ($has_deposit): ?>
                <div class="uk-text-bold">
                    <div>Giá vaccine: <?php echo number_format($lich_hen['gia_tien'], 0, ',', '.'); ?> VNĐ</div>
                    <div>Số tiền đã đặt cọc (20%):
                        <?php echo number_format($lich_hen['so_tien_dat_coc'], 0, ',', '.'); ?> VNĐ</div>
                </div>
                <?php else: ?>
                <div id="deposit_amount" class="uk-text-bold"></div>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <div class="uk-margin">
        <label class="uk-form-label" for="ghi_chu">Ghi chú:</label>
        <div class="uk-form-controls">
            <textarea class="uk-textarea" id="ghi_chu" name="ghi_chu"
                rows="3"><?php echo isset($lich_hen['ghi_chu']) ? $lich_hen['ghi_chu'] : ''; ?></textarea>
        </div>
    </div>


    <div class="uk-margin">
        <button class="uk-button uk-button-primary" type="submit">Cập nhật lịch hẹn</button>
        <a class="uk-button uk-button-default" href="index.php?page=lich-hen-list">Hủy</a>
    </div>
</form>

<script>
// Thay đổi hàm searchKhachHang
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

function searchKhachHang(search_term) {
    const searchResults = document.getElementById('search_results');
    const resultsList = searchResults.querySelector('ul');

    if (search_term.length < 2) {
        UIkit.dropdown(searchResults).hide();
        return;
    }

    fetch(`ajax/search_khachhang.php?search=${encodeURIComponent(search_term)}`)
        .then(response => response.json())
        .then(data => {
            resultsList.innerHTML = '';
            if (data.length > 0) {
                data.forEach(khachHang => {
                    const li = document.createElement('li');
                    li.innerHTML = `
                        <a href="#" onclick="selectKhachHang('${khachHang.khachhang_id}', '${khachHang.fullname}', '${khachHang.dienthoai}', '${khachHang.cccd}'); return false;">
                            ${khachHang.fullname} - SĐT: ${khachHang.dienthoai} ${khachHang.cccd ? '- CCCD: ' + khachHang.cccd : ''}
                        </a>
                    `;
                    resultsList.appendChild(li);
                });
                UIkit.dropdown(searchResults).show();
            } else {
                resultsList.innerHTML = '<li><a href="#">Không tìm thấy kết quả</a></li>';
                UIkit.dropdown(searchResults).show();
            }
        })
        .catch(error => console.error('Error:', error));
}

function selectKhachHang(id, name, phone, cccd) {
    document.getElementById('khachhang_id').value = id;
    document.getElementById('search_khachhang').value = `${name} - ${phone}`;

    const selectedDiv = document.getElementById('selected_khachhang');
    selectedDiv.style.display = 'block';
    selectedDiv.innerHTML = `
        <div class="uk-text-small">
            <div><strong>Tên:</strong> ${name}</div>
            <div><strong>SĐT:</strong> ${phone}</div>
            ${cccd ? `<div><strong>CCCD:</strong> ${cccd}</div>` : ''}
        </div>
    `;

    UIkit.dropdown('#search_results').hide();
}

const debouncedSearch = debounce(searchKhachHang, 300);

document.getElementById('search_khachhang').addEventListener('input', (e) => {
    debouncedSearch(e.target.value);
});

function toggleVaccineSelect() {
    const vaccineSection = document.getElementById('vaccine_section');
    const vaccineSelect = document.getElementById('vaccine_id');
    const hasDeposit = document.querySelector('input[name="has_deposit"]').checked;

    vaccineSection.style.display = hasDeposit ? 'block' : 'none';
    vaccineSelect.required = hasDeposit;
    if (!hasDeposit) {
        vaccineSelect.value = '';
        document.getElementById('deposit_amount').textContent = '';
    }
}

function calculateDeposit() {
    const vaccineSelect = document.getElementById('vaccine_id');
    const depositDiv = document.getElementById('deposit_amount');

    if (vaccineSelect.value) {
        const selectedOption = vaccineSelect.options[vaccineSelect.selectedIndex];
        const price = parseFloat(selectedOption.dataset.price);
        const depositAmount = price * 0.2; // 20%

        depositDiv.innerHTML = `
            <div>Giá vaccine: ${number_format(price)} VNĐ</div>
            <div>Số tiền đặt cọc (20%): ${number_format(depositAmount)} VNĐ</div>
        `;
    } else {
        depositDiv.textContent = '';
    }
}

function number_format(number) {
    return new Intl.NumberFormat('vi-VN').format(number);
}


document.getElementById('search_khachhang').addEventListener('input', (e) => {
    debouncedSearch(e.target.value);
});

// Calculate initial deposit amount if vaccine is selected
window.addEventListener('load', function() {
    if (document.querySelector('input[name="has_deposit"]').checked) {
        calculateDeposit();
    }
});

document.querySelector('form').addEventListener('submit', function(e) {
    const gioBatDau = document.getElementById('gio_bat_dau').value;
    const gioKetThuc = document.getElementById('gio_ket_thuc').value;

    if (gioBatDau >= gioKetThuc) {
        e.preventDefault();
        UIkit.notification({
            message: 'Giờ kết thúc phải sau giờ bắt đầu!',
            status: 'danger',
            pos: 'top-center',
            timeout: 3000
        });
    }
});

// Thêm sự kiện để tự động điều chỉnh giờ kết thúc
document.getElementById('gio_bat_dau').addEventListener('change', function() {
    const gioBatDau = new Date('2000-01-01 ' + this.value);
    const gioKetThucHienTai = document.getElementById('gio_ket_thuc').value;

    if (!gioKetThucHienTai || gioBatDau >= new Date('2000-01-01 ' + gioKetThucHienTai)) {
        const gioKetThuc = new Date(gioBatDau.getTime() + 30 * 60000); // Thêm 30 phút
        let hours = gioKetThuc.getHours().toString().padStart(2, '0');
        let minutes = gioKetThuc.getMinutes().toString().padStart(2, '0');
        document.getElementById('gio_ket_thuc').value = `${hours}:${minutes}`;
    }
});



window.addEventListener('DOMContentLoaded', function() {
    var trangThai = document.getElementById('trang_thai');
    if (trangThai.value === 'hoan_thanh') {
        trangThai.disabled = true;
    }
});
</script>

<script>
CKEDITOR.replace('ghi_chu');
</script>