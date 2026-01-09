<?php 
require_once '../check_login.php'; 
$conn = mysqli_connect("localhost","root","","webmypham");
mysqli_set_charset($conn,"utf8mb4");

// Lấy tham số tìm kiếm và lọc danh mục
$search = $_GET['search'] ?? '';
$cat_id = $_GET['cat_id'] ?? 0;

$sql = "SELECT sp.*, dm.name AS cat_name 
        FROM sanpham sp 
        LEFT JOIN danhmuc dm ON sp.category_id = dm.id 
        WHERE 1=1";

if($search != '') {
    $search_esc = mysqli_real_escape_string($conn, $search);
    $sql .= " AND sp.name LIKE '%$search_esc%'";
}
if($cat_id > 0) {
    $sql .= " AND sp.category_id = " . (int)$cat_id;
}

$sql .= " ORDER BY sp.id DESC";
$rs = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Danh sách sản phẩm - VH Beauty</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .product-img {
            width:80px; 
            height:80px; 
            object-fit:cover; 
            border-radius:10px; 
            box-shadow:0 3px 10px rgba(0,0,0,0.2);
        }
        .badge-no-cat {background:#6c757d;
        }
        .btn-them{
            background: #ec3673;
            color: #ffff; 
        }
    </style>
</head>
<body>

<!-- SIDEBAR ĐẦY ĐỦ VÀ ĐẸP LUNG LINH -->
<div class="sidebar">
    <h3>VH Beauty</h3>
    <a href="product.php" class="active">Sản phẩm</a>
    <a href="category.php">Danh mục</a>
    <a href="orders.php">Đơn hàng</a>
    <a href="user.php">Khách hàng</a>
    <a href="doanhthu.php">Doanh thu</a>
    <hr style="border-color:#555; margin:20px 0;">
    <a href="../admin_login.php?logout=1" style="color:#ff6b6b">
        Đăng xuất
    </a>
</div>

<!-- NỘI DUNG CHÍNH -->
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>DANH SÁCH SẢN PHẨM</h2>
        <a href="them.php" class="btn btn-them btn-lg shadow">
            + Thêm sản phẩm
        </a>
    </div>

    <!-- TÌM KIẾM + LỌC DANH MỤC -->
    <form class="row g-3 mb-4" method="GET">
        <div class="col-md-5">
            <input type="text" name="search" class="form-control form-control-lg" 
                   placeholder="Tìm tên sản phẩm..." 
                   value="<?= htmlspecialchars($search) ?>">
        </div>
        <div class="col-md-4">
            <select name="cat_id" class="form-select form-select-lg">
                <option value="">Tất cả danh mục</option>
                <?php
                $cats = mysqli_query($conn, "SELECT * FROM danhmuc ORDER BY name");
                while($c = mysqli_fetch_assoc($cats)){
                    $selected = ($c['id'] == $cat_id) ? 'selected' : '';
                    echo "<option value='{$c['id']}' $selected>{$c['name']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary btn-lg w-100">Lọc</button>
        </div>
    </form>

    <!-- BẢNG SẢN PHẨM -->
    <div class="card shadow">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">ID</th>
                            <th>Ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Danh mục</th>
                            <th>Giá</th>
                            <th>Kho</th>
                            <th>Đã bán</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while($row = mysqli_fetch_assoc($rs)): ?>
                        <tr>
                            <td class="text-center fw-bold"><?= $row['id'] ?></td>
                            <td>
                                <?php if($row['image'] && file_exists("../uploads/".$row['image'])): ?>
                                    <img src="../uploads/<?= $row['image'] ?>?v=<?= time() ?>" 
                                         class="product-img" alt="<?= htmlspecialchars($row['name']) ?>">
                                <?php else: ?>
                                    <img src="../image/no-image.jpg" class="product-img" alt="No image">
                                <?php endif; ?>
                            </td>
                            <td class="text-start fw-500"><?= htmlspecialchars($row['name']) ?></td>
                            <td>
                                <span class="badge <?= $row['cat_name'] ? 'bg-info' : 'badge-no-cat' ?>">
                                    <?= $row['cat_name'] ?: 'Chưa có danh mục' ?>
                                </span>
                            </td>
                            <td class="fw-bold text-danger"><?= number_format($row['price']) ?>.000₫</td>
                            <td><?= $row['quantity'] ?></td>
                            <td><?= $row['quantity_sold'] ?? 0 ?></td>
                            <td>
                                <a href="chitiet.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm">Xem</a>
                                <a href="sua.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                                <a href="xoa.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                                   onclick="return confirm('Xóa sản phẩm này vĩnh viễn?')">Xóa</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    <?php if(mysqli_num_rows($rs) == 0): ?>
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                Không tìm thấy sản phẩm nào.
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>
</html>