<?php
require_once '../check_login.php';
$conn = mysqli_connect("localhost","root","","webmypham");
mysqli_set_charset($conn,"utf8mb4");

$id = intval($_GET['id'] ?? 0);

// LẤY THÔNG TIN KHÁCH HÀNG + LOẠI BỎ ADMIN
$sql = "SELECT * FROM users WHERE id = $id";
$ketqua = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($ketqua);

if (!$row) {
    die('<div style="text-align:center; margin-top:100px; font-size:20px; color:red;">
            Khách hàng không tồn tại hoặc đây là tài khoản quản trị viên!
         </div>');
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Chi tiết khách hàng #<?= $row['id'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background:#f8f9fa; margin:0; padding:0; }
        
        /* Sidebar giống hệt product.php */
        .sidebar {
            background:#343a40;
            color:white;
            height:100vh;
            padding:20px;
            position:fixed;
            width:200px;
            top:0; left:0;
        }
        .sidebar h3 { text-align:center; margin-bottom:30px; font-weight:bold; }
        .sidebar a {
            color:white;
            display:block;
            padding:12px 15px;
            text-decoration:none;
            border-radius:6px;
            margin-bottom:5px;
        }
        .sidebar a:hover, .sidebar a.active { background:#495057; }

        /* Nội dung chính */
        .main-content {
            margin-left:220px;
            padding:40px;
        }
        .card {
            background:white;
            border-radius:12px;
            box-shadow:0 5px 15px rgba(0,0,0,0.1);
            max-width:900px;
        }
        .card h2 {
            color:#333;
            border-bottom:4px solid #e91e63;
            padding-bottom:12px;
            display:inline-block;
        }
        .table th {
            background:#f8d7da;
            font-weight:600;
            width:220px;
        }
    </style>
</head>
<body>

<!-- MENU DỌC CỐ ĐỊNH - GIỐNG HỆT PRODUCT.PHP -->
<div class="sidebar">
    <h3>VH Beauty</h3>
    <a href="product.php">Sản phẩm</a>
    <a href="order.php">Đơn hàng</a>
    <a href="user.php" class="active">Khách hàng</a>
    <hr style="border-color:#555;">
    <a href="../admin_login.php?logout=1" style="color:#ff6b6b">Đăng xuất</a>
</div>

<!-- NỘI DUNG CHÍNH -->
<div class="main-content">
    <div class="card p-4">
        <h2>THÔNG TIN KHÁCH HÀNG</h2>
        <br>

        <table class="table table-bordered table-hover">
            <tr>
                <th>ID</th>
                <td><strong>#<?= $row['id'] ?></strong></td>
            </tr>
            <tr>
                <th>Họ và tên</th>
                <td><?= htmlspecialchars($row['name'] ?? $row['fullname'] ?? 'Chưa cập nhật') ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?= htmlspecialchars($row['email']) ?></td>
            </tr>
            <tr>
                <th>Số điện thoại</th>
                <td><?= htmlspecialchars($row['phone'] ?? 'Chưa cung cấp') ?></td>
            </tr>
            <tr>
                <th>Địa chỉ</th>
                <td><?= htmlspecialchars($row['address'] ?? 'Chưa cập nhật') ?></td>
            </tr>
            <tr>
                <th>Ngày đăng ký</th>
                <td><?= date('d/m/Y H:i:s', strtotime($row['created_at'] ?? $row['ngaytao'] ?? $row['date'])) ?></td>
            </tr>
            <tr>
                <th>Trạng thái tài khoản</th>
                <td>
                    <?php if(($row['active'] ?? 1) == 1): ?>
                        <span class="badge bg-success fs-6">Hoạt động</span>
                    <?php else: ?>
                        <span class="badge bg-danger fs-6">Bị khóa</span>
                    <?php endif; ?>
                </td>
            </tr>
        </table>

        <div class="mt-4">
            <a href="user.php" class="btn btn-secondary btn-lg">Quay lại danh sách</a>
        </div>
    </div>
</div>

</body>
</html>