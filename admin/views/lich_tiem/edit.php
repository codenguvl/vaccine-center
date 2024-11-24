<?php
require_once 'controllers/lich_tiem_controller.php';
require_once 'controllers/khachhang_controller.php';
require_once 'controllers/vaccine_controller.php';

$lich_tiem_controller = new LichTiemController($conn);
$khachhang_controller = new KhachHangController($conn);
$vaccine_controller = new VaccineController($conn);

$id = isset($_GET['id']) ? $_GET['id'] : null;
$lich_tiem = $lich_tiem_controller->getLichTiemById($id);

if (!$lich_tiem) {
    echo "Lịch tiêm không tồn tại.";
    exit;
}

if (isset($_GET['search'])) {
    $search_term = $_GET['search'];
    $khach_hang_list = $khachhang_controller->searchKhachHang($search_term);
} else {
    $khach_hang_list = $khachhang_controller->getAllKhachHang();
}

$vaccine_list = $vaccine_controller->getAllVaccine();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $lich_tiem_controller->updateLichTiem(
        $id,
        $_POST['khachhang_id'],
        $_POST['vaccin_id'],
        $_POST['ngay_tiem'],
        $_POST['lan_tiem'],
        $_POST['trang_thai'],
        $_POST['ghi_chu']
    );

    if ($result) {
        // Nếu cập nhật thành đã tiêm, hiển thị form tạo lịch tiêm tiếp theo
        if ($_POST['trang_thai'] === 'da_tiem' && $_POST['create_next'] === '1') {
            $next_date = $_POST['ngay_tiem_tiep'] ?? '';
            if ($next_date) {
                $lich_tiem_controller->taoLichTiemTiepTheo($id, $next_date);
            }
        }
        header("Location: index.php?page=lich-tiem-list&message=edit_success");
        exit();
    } else {
        $error_message = "Có lỗi xảy ra khi cập nhật lịch tiêm!";
    }
}
?>


<?php if (isset($error_message)): ?>
<div class="uk-alert-danger" uk-alert>
    <a class="uk-alert-close" uk-close></a>
    <p><?php echo $error_message; ?></p>
</div>
<?php endif; ?>

<form class="uk-form-stacked" action="index.php?page=lich-tiem-edit&id=<?php echo $id; ?>" method="POST">
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
                value="<?php echo $lich_tiem['khachhang_id']; ?>">
            <div id="selected_khachhang" class="uk-margin-small-top uk-padding-small uk-background-muted"
                style="display: <?php echo !empty($lich_tiem['khachhang_id']) ? 'block' : 'none'; ?>;">
                <?php if (!empty($lich_tiem['khachhang_id'])):
                    $khach_hang = $khachhang_controller->getKhachHangById($lich_tiem['khachhang_id']);
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
        <label class="uk-form-label" for="vaccin_id">Vaccine:</label>
        <div class="uk-form-controls">
            <select class="uk-select" id="vaccin_id" name="vaccin_id" required>
                <?php foreach ($vaccine_list as $vaccine): ?>
                <option value="<?php echo $vaccine['vaccin_id']; ?>"
                    <?php echo ($vaccine['vaccin_id'] == $lich_tiem['vaccin_id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($vaccine['ten_vaccine']); ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="uk-margin">
        <label class="uk-form-label" for="ngay_tiem">Ngày tiêm:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="ngay_tiem" name="ngay_tiem" type="date"
                value="<?php echo htmlspecialchars($lich_tiem['ngay_tiem']); ?>" required>
        </div>
    </div>

    <div class="uk-margin">
        <label class="uk-form-label" for="lan_tiem">Lần tiêm:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="lan_tiem" name="lan_tiem" type="number" min="1"
                value="<?php echo htmlspecialchars($lich_tiem['lan_tiem']); ?>" required>
        </div>
    </div>

    <div class="uk-margin">
        <label class="uk-form-label" for="trang_thai">Trạng thái:</label>
        <div class="uk-form-controls">
            <select class="uk-select" id="trang_thai" name="trang_thai" required
                onchange="toggleNextVaccination(this.value)">
                <option value="cho_tiem" <?php echo ($lich_tiem['trang_thai'] == 'cho_tiem') ? 'selected' : ''; ?>>
                    Chờ tiêm</option>
                <option value="da_tiem" <?php echo ($lich_tiem['trang_thai'] == 'da_tiem') ? 'selected' : ''; ?>>
                    Đã tiêm</option>
                <option value="huy" <?php echo ($lich_tiem['trang_thai'] == 'huy') ? 'selected' : ''; ?>>
                    Hủy</option>
            </select>
        </div>
    </div>

    <div id="next_vaccination_section" class="uk-margin" style="display: none;">
        <div class="uk-margin">
            <label>
                <input class="uk-checkbox" type="checkbox" name="create_next" value="1"
                    onchange="toggleNextDate(this.checked)"> Tạo lịch tiêm tiếp theo
            </label>
        </div>
        <div id="next_date_section" style="display: none;">
            <label class="uk-form-label" for="ngay_tiem_tiep">Ngày tiêm tiếp theo:</label>
            <div class="uk-form-controls">
                <input class="uk-input" id="ngay_tiem_tiep" name="ngay_tiem_tiep" type="date">
            </div>
        </div>
    </div>

    <div class="uk-margin">
        <label class="uk-form-label" for="ghi_chu">Ghi chú:</label>
        <div class="uk-form-controls">
            <textarea class="uk-textarea" id="ghi_chu" name="ghi_chu"
                rows="3"><?php echo isset($lich_tiem['ghi_chu']) ? htmlspecialchars($lich_tiem['ghi_chu']) : ''; ?></textarea>
        </div>
    </div>


    <div class="uk-margin">
        <button class="uk-button uk-button-primary" type="submit">Cập nhật lịch tiêm</button>
        <a class="uk-button uk-button-default" href="index.php?page=lich-tiem-list">Hủy</a>
    </div>
</form>

<script>
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

// Đóng dropdown khi click ra ngoài
document.addEventListener('click', function(e) {
    if (!e.target.closest('.uk-inline')) {
        UIkit.dropdown('#search_results').hide();
    }
});

function toggleNextVaccination(status) {
    const nextVaccinationSection = document.getElementById('next_vaccination_section');
    nextVaccinationSection.style.display = status === 'da_tiem' ? 'block' : 'none';

    if (status !== 'da_tiem') {
        document.querySelector('input[name="create_next"]').checked = false;
        document.getElementById('next_date_section').style.display = 'none';
    }
}

function toggleNextDate(checked) {
    const nextDateSection = document.getElementById('next_date_section');
    nextDateSection.style.display = checked ? 'block' : 'none';

    if (checked) {
        const currentDate = new Date('<?php echo $lich_tiem['ngay_tiem']; ?>');
        currentDate.setMonth(currentDate.getMonth() + 1); // Mặc định +1 tháng
        const nextDate = currentDate.toISOString().split('T')[0];
        document.getElementById('ngay_tiem_tiep').value = nextDate;
    }
}

// Khởi tạo ban đầu
toggleNextVaccination(document.getElementById('trang_thai').value);
</script>

<script>
CKEDITOR.replace('ghi_chu');
</script>