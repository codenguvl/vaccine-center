<?php
require_once 'controllers/lich_tiem_controller.php';
require_once 'controllers/khachhang_controller.php';
require_once 'controllers/vaccine_controller.php';

$lich_tiem_controller = new LichTiemController($conn);
$khachhang_controller = new KhachHangController($conn);
$vaccine_controller = new VaccineController($conn);

if (isset($_GET['search'])) {
    $search_term = $_GET['search'];
    $khach_hang_list = $khachhang_controller->searchKhachHang($search_term);
} else {
    $khach_hang_list = $khachhang_controller->getAllKhachHang();
}

$vaccine_list = $vaccine_controller->getAllVaccine();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $lich_tiem_controller->addLichTiem(
        $_POST['khachhang_id'],
        $_POST['vaccin_id'],
        $_POST['ngay_tiem'],
        $_POST['lan_tiem'],
        $_POST['trang_thai'],
        $_POST['ghi_chu']
    );

    if ($result) {
        header("Location: index.php?page=lich-tiem-list&message=add_success");
        exit();
    } else {
        $error_message = "Có lỗi xảy ra khi thêm lịch tiêm!";
    }
}
?>


<?php if (isset($error_message)): ?>
<div class="uk-alert-danger" uk-alert>
    <a class="uk-alert-close" uk-close></a>
    <p><?php echo $error_message; ?></p>
</div>
<?php endif; ?>

<form class="uk-form-stacked" action="index.php?page=lich-tiem-add" method="POST">
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
            <input type="hidden" id="khachhang_id" name="khachhang_id" required>
            <div id="selected_khachhang" class="uk-margin-small-top uk-padding-small uk-background-muted"
                style="display: none;">
                <!-- Thông tin khách hàng đã chọn sẽ hiện ở đây -->
            </div>
        </div>
    </div>


    <div class="uk-margin">
        <label class="uk-form-label" for="vaccin_id">Vaccine:</label>
        <div class="uk-form-controls">
            <select class="uk-select" id="vaccin_id" name="vaccin_id" required>
                <option value="">Chọn vaccine</option>
                <?php foreach ($vaccine_list as $vaccine): ?>
                <option value="<?php echo $vaccine['vaccin_id']; ?>">
                    <?php echo htmlspecialchars($vaccine['ten_vaccine']); ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="uk-margin">
        <label class="uk-form-label" for="ngay_tiem">Ngày tiêm:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="ngay_tiem" name="ngay_tiem" type="date" required>
        </div>
    </div>

    <div class="uk-margin">
        <label class="uk-form-label" for="lan_tiem">Lần tiêm:</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="lan_tiem" name="lan_tiem" type="number" min="1" value="1" required>
        </div>
    </div>

    <div class="uk-margin">
        <label class="uk-form-label" for="trang_thai">Trạng thái:</label>
        <div class="uk-form-controls">
            <select class="uk-select" id="trang_thai" name="trang_thai" required>
                <option value="cho_tiem">Chờ tiêm</option>
                <option value="da_tiem">Đã tiêm</option>
                <option value="huy">Hủy</option>
            </select>
        </div>
    </div>

    <div class="uk-margin">
        <label class="uk-form-label" for="ghi_chu">Ghi chú:</label>
        <div class="uk-form-controls">
            <textarea class="uk-textarea" id="ghi_chu" name="ghi_chu" rows="3"></textarea>
        </div>
    </div>

    <div class="uk-margin">
        <button class="uk-button uk-button-primary" type="submit">Thêm lịch tiêm</button>
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
</script>

<script>
CKEDITOR.replace('ghi_chu');
</script>