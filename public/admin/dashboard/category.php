<?php 
require_once '../check_login.php'; 
$conn = mysqli_connect("localhost","root","","webmypham");
mysqli_set_charset($conn,"utf8mb4");
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Quản lý danh mục</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <style>
      body {
        background: #f8f9fa;
      }
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
        margin-left: 220px;
        padding: 20px;
      }
    </style>
  </head>
  <body>
    <div class="sidebar">
      <h3>VH Beauty</h3>
      <a href="product.php">Sản phẩm</a>
      <a href="category.php" class="active">Danh mục</a>
      <a href="orders.php">Đơn hàng</a>
      <a href="user.php">Khách hàng</a>
      <a href="doanhthu.php">Doanh thu</a>
      <hr />
      <a href="../admin_login.php?logout=1" style="color: #ff6b6b">Đăng xuất</a>
    </div>

    <div class="main-content">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>QUẢN LÝ DANH MỤC</h2>
        <a href="themdanhmuc.php" class="btn btn-success">+ Thêm danh mục</a>
      </div>

      <table class="table table-bordered table-hover text-center align-middle">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Tên danh mục</th>
            <th>Số sản phẩm</th>
            <th>Thao tác</th>
          </tr>
        </thead>
        <tbody>
          <?php
        $sql = "SELECT dm.*, COUNT(sp.id) as total_product 
                FROM danhmuc dm 
                LEFT JOIN sanpham sp ON dm.id = sp.category_id 
                GROUP BY dm.id 
                ORDER BY dm.name";
        $rs = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($rs)){
        ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td class="text-start">
              <a
                href="product.php?cat_id=<?= $row['id'] ?>"
                class="text-decoration-none fw-500"
              >
                <?= htmlspecialchars($row['name']) ?>
              </a>
            </td>
            <td><?= $row['total_product'] ?></td>
            <td>
              <a
                href="xoa_danhmuc.php?id=<?= $row['id'] ?>"
                class="btn btn-danger btn-sm"
                onclick="return confirm('Xóa danh mục này? Tất cả sản phẩm thuộc danh mục sẽ bị ảnh hưởng!')"
                >Xóa</a
              >
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </body>
</html>
