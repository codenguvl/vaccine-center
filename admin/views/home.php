<style>
.background {
    width: 100%;
    object-fit: cover;
}
</style>

<?php
require_once 'controllers/vaccine_controller.php';
require_once 'controllers/khachhang_controller.php';
require_once 'controllers/lich_hen_controller.php';
require_once 'controllers/lich_tiem_controller.php';
require_once 'controllers/phan_ung_sau_tiem_controller.php';

$vaccine_controller = new VaccineController($conn);
$khachhang_controller = new KhachHangController($conn);
$lich_hen_controller = new LichHenController($conn);
$lich_tiem_controller = new LichTiemController($conn);
$phan_ung_controller = new PhanUngSauTiemController($conn);

$total_vaccines = count($vaccine_controller->getAllVaccine());
$total_customers = count($khachhang_controller->getAllKhachHang());
$all_appointments = $lich_hen_controller->getAllLichHen();
$all_vaccinations = $lich_tiem_controller->getAllLichTiem();

$appointment_stats = [
    'cho_xac_nhan' => 0,
    'da_xac_nhan' => 0,
    'da_huy' => 0,
    'hoan_thanh' => 0
];
foreach ($all_appointments as $appointment) {
    if (isset($appointment['trang_thai'])) {
        $appointment_stats[$appointment['trang_thai']]++;
    }
}

$vaccination_stats = [
    'cho_tiem' => 0,
    'da_tiem' => 0,
    'huy' => 0
];
foreach ($all_vaccinations as $vaccination) {
    if (isset($vaccination['trang_thai'])) {
        $vaccination_stats[$vaccination['trang_thai']]++;
    }
}


$reaction_stats = $phan_ung_controller->getThongKePhanUng();
?>

<div class="uk-container uk-container-large">
    <div class="uk-grid-small uk-child-width-1-2@m uk-margin-medium-top" uk-grid>
        <!-- Ảnh chiếm 50% -->
        <div>
            <img src="images/background.png" alt="Data flow" class="background" style="width: 100%; height: auto;">
        </div>

        <!-- 2 biểu đồ chiếm 50%, một cái trên và một cái dưới -->
        <div>
            <div class="uk-grid-small uk-child-width-1-1" uk-grid>
                <div>
                    <div class="uk-card uk-card-default uk-card-body uk-card-hover">
                        <h3 class="uk-card-title">Thống kê lịch hẹn</h3>
                        <canvas id="appointmentChart" style="max-width: 250px; margin: 0 auto;"></canvas>
                    </div>
                </div>
                <div>
                    <div class="uk-card uk-card-default uk-card-body uk-card-hover">
                        <h3 class="uk-card-title">Thống kê tiêm chủng</h3>
                        <canvas id="vaccinationChart" style="max-width: 250px; margin: 0 auto;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const appointmentCtx = document.getElementById('appointmentChart').getContext('2d');
new Chart(appointmentCtx, {
    type: 'pie',
    data: {
        labels: ['Chờ xác nhận', 'Đã xác nhận', 'Đã hủy', 'Hoàn thành'],
        datasets: [{
            data: [
                <?php echo $appointment_stats['cho_xac_nhan']; ?>,
                <?php echo $appointment_stats['da_xac_nhan']; ?>,
                <?php echo $appointment_stats['da_huy']; ?>,
                <?php echo $appointment_stats['hoan_thanh']; ?>
            ],
            backgroundColor: [
                '#ffd700',
                '#32d296',
                '#f0506e',
                '#1e87f0'
            ]
        }]
    }
});

const vaccinationCtx = document.getElementById('vaccinationChart').getContext('2d');
new Chart(vaccinationCtx, {
    type: 'doughnut',
    data: {
        labels: ['Chờ tiêm', 'Đã tiêm', 'Hủy'],
        datasets: [{
            data: [
                <?php echo $vaccination_stats['cho_tiem']; ?>,
                <?php echo $vaccination_stats['da_tiem']; ?>,
                <?php echo $vaccination_stats['huy']; ?>
            ],
            backgroundColor: [
                '#ffd700',
                '#32d296',
                '#f0506e'
            ]
        }]
    }
});
</script>