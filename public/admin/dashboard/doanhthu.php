<?php 
require_once '../check_login.php';  // Kiểm tra đăng nhập admin (giống product.php)
$conn = mysqli_connect("localhost","root","","webmypham");
mysqli_set_charset($conn,"utf8mb4");

// === LẤY DỮ LIỆU DOANH THU ===
$current_year = date('Y');
$years_result = mysqli_query($conn, "SELECT DISTINCT YEAR(created_at) as year FROM orders WHERE status IN ('completed', 'delivered') ORDER BY year DESC");
$available_years = [];
while ($y = mysqli_fetch_assoc($years_result)) {
    $available_years[] = $y['year'];
}
if (empty($available_years)) $available_years[] = $current_year;

$selected_year = $_GET['year'] ?? $current_year;
if (!in_array($selected_year, $available_years)) $selected_year = $current_year;

$data = array_fill(1, 12, 0);
$total_year = 0;

$sql = "SELECT MONTH(created_at) as month, SUM(total_amount) as revenue 
        FROM orders 
        WHERE YEAR(created_at) = ? 
          AND status IN ('completed', 'delivered')
        GROUP BY MONTH(created_at)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $selected_year);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $data[$row['month']] = (int)$row['revenue'];
    $total_year += (int)$row['revenue'];
}

function format_money($num) {
    return number_format($num, 0, ',', '.') . '₫';
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Doanh Thu Theo Tháng - VH Beauty Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {background:#f8f9fa; margin:0; font-family:Arial,sans-serif;}
        .sidebar {
            background:#343a40; 
            color:white; 
            height:100vh; 
            padding:20px; 
            position:fixed; 
            width:220px; 
            top:0; 
            left:0; 
            overflow-y:auto;
            box-shadow: 3px 0 10px rgba(0,0,0,0.2);
        }
        .sidebar h3 {
            text-align:center; 
            margin-bottom:30px; 
            font-weight:bold; 
            color:#0dcaf0;
        }
        .sidebar a {
            color:white; 
            display:block; 
            padding:12px 15px; 
            text-decoration:none; 
            border-radius:8px; 
            margin:5px 0;
            transition:0.3s;
        }
        .sidebar a:hover, .sidebar a.active {
            background:#495057; 
            font-weight:bold;
            transform:translateX(5px);
        }
        .main-content {
            margin-left:240px; 
            padding:30px;
        }
        .revenue-card { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            color: white; 
            border-radius: 15px; 
        }
        .stat-card { 
            border-radius: 15px; 
            box-shadow: 0 5px 15px rgba(0,0,0,0.1); 
        }
        .chart-container { 
            background: white; 
            border-radius: 15px; 
            padding: 20px; 
            box-shadow: 0 5px 20px rgba(0,0,0,0.1); 
        }
        .year-selector { max-width: 200px; }
    </style>
</head>
<body>

<!-- SIDEBAR ĐẸP NHƯ PRODUCT.PHP -->
<div class="sidebar">
    <h3>VH Beauty</h3>
    <a href="product.php">Sản phẩm</a>
    <a href="category.php">Danh mục</a>
    <a href="orders.php">Đơn hàng</a>
    <a href="user.php">Khách hàng</a>
    <a href="doanhthu.php" class="active">
        Doanh thu
    </a>
    <hr style="border-color:#555; margin:20px 0;">
    <a href="../admin_login.php?logout=1" style="color:#ff6b6b">
        Đăng xuất
    </a>
</div>

<!-- NỘI DUNG CHÍNH -->
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2> Báo Cáo Doanh Thu Năm <?= $selected_year ?></h2>
        <select class="form-select year-selector shadow" onchange="window.location='doanhthu.php?year='+this.value">
            <?php foreach ($available_years as $y): ?>
                <option value="<?= $y ?>" <?= $y == $selected_year ? 'selected' : '' ?>><?= $y ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="row g-4">
        <!-- Tổng doanh thu năm -->
        <div class="col-lg-4">
            <div class="revenue-card p-5 text-center stat-card">
                <h5 class="mb-3 opacity-75">Tổng doanh thu năm <?= $selected_year ?></h5>
                <h1 class="display-4 fw-bold mb-0"><?= format_money($total_year) ?></h1>
                <small>Chỉ tính đơn hoàn thành</small>
            </div>
        </div>

        <!-- Top 3 tháng cao nhất -->
        <div class="col-lg-8">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <h5 class="card-title"> Top 3 tháng doanh thu cao nhất</h5>
                    <?php
                    $top3 = $data;
                    arsort($top3);
                    $top3 = array_slice($top3, 0, 3, true);
                    $months_vn = ['','Tháng 1','Tháng 2','Tháng 3','Tháng 4','Tháng 5','Tháng 6','Tháng 7','Tháng 8','Tháng 9','Tháng 10','Tháng 11','Tháng 12'];
                    $rank = 1;
                    foreach ($top3 as $m => $rev):
                        if ($rev == 0) continue;
                    ?>
                    <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded mb-2">
                        <div class="d-flex align-items-center gap-3">
                            <h1 class="text-warning mb-0">#<?= $rank++ ?></h1>
                            <div>
                                <h5 class="mb-0"><?= $months_vn[$m] ?></h5>
                                <small class="text-muted">Năm <?= $selected_year ?></small>
                            </div>
                        </div>
                        <h4 class="text-success fw-bold mb-0"><?= format_money($rev) ?></h4>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Biểu đồ -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="chart-container">
                <canvas id="revenueChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- Bảng chi tiết -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card stat-card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"> Chi tiết doanh thu 12 tháng năm <?= $selected_year ?></h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Tháng</th>
                                    <th class="text-end">Doanh thu</th>
                                    <th class="text-center">Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for($m=1; $m<=12; $m++): 
                                    $rev = $data[$m];
                                    $is_highest = ($rev > 0 && $rev == max($data));
                                ?>
                                <tr <?= $is_highest ? 'class="table-success fw-bold"' : '' ?>>
                                    <td><strong><?= $months_vn[$m] ?></strong></td>
                                    <td class="text-end <?= $rev > 0 ? 'text-success' : 'text-muted' ?> fw-bold">
                                        <?= $rev > 0 ? format_money($rev) : '0₫' ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($rev == 0): ?>
                                            <span class="badge bg-secondary">Chưa có đơn</span>
                                        <?php elseif($is_highest): ?>
                                            <span class="badge bg-warning text-dark">Cao nhất</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Có doanh thu</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endfor; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const ctx = document.getElementById('revenueChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['T1','T2','T3','T4','T5','T6','T7','T8','T9','T10','T11','T12'],
        datasets: [{
            label: 'Doanh thu',
            data: <?= json_encode(array_values($data)) ?>,
            backgroundColor: 'rgba(102, 126, 234, 0.7)',
            borderColor: '#667eea',
            borderWidth: 2,
            borderRadius: 8,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: ctx => 'Doanh thu: ' + ctx.parsed.y.toLocaleString('vi-VN') + '₫'
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { callback: value => value.toLocaleString('vi-VN') + '₫' }
            }
        }
    }
});
</script>

</body>
</html>