<?php 
require_once '../check_login.php'; 
$conn = mysqli_connect("localhost","root","","webmypham");
mysqli_set_charset($conn,"utf8mb4");

// Tìm kiếm + phân trang
$search = isset($_GET['q']) ? trim($_GET['q']) : '';
$page   = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$limit  = 20;
$offset = ($page - 1) * $limit;

$sql_count = "SELECT COUNT(*) as total FROM users WHERE 1=1";
$sql       = "SELECT * FROM users WHERE 1=1";

if($search !== ''){
    $search_esc = mysqli_real_escape_string($conn, $search);
    // ĐỔI fullname THÀNH TÊN CỘT THỰC TẾ CỦA BẠN (thường là fullname hoặc ho_ten)
    $sql       .= " AND (fullname LIKE '%$search_esc%' OR email LIKE '%$search_esc%' OR phone LIKE '%$search_esc%')";
    $sql_count .= " AND (fullname LIKE '%$search_esc%' OR email LIKE '%$search_esc%' OR phone LIKE '%$search_esc%')";
}

$sql       .= " ORDER BY id DESC LIMIT $limit OFFSET $offset";
$result_count = mysqli_query($conn, $sql_count);
$total_rows   = mysqli_fetch_assoc($result_count)['total'];
$total_pages  = ceil($total_rows / $limit);

$rs = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="utf-8" />
    <title>Danh sách khách hàng - VH Beauty</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <style>
      body {
        background: #f8f9fa;
        margin: 0;
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
        padding: 30px;
      }
    </style>
  </head>
  <body>
    <div class="sidebar">
      <h3 class="text-center text-white mb-4">VH Beauty</h3>
      <a href="product.php">Sản phẩm</a>
      <a href="category.php">Danh mục</a>
      <a href="orders.php">Đơn hàng</a>
      <a href="user.php" class="active">Khách hàng</a>
      <a href="doanhthu.php">Doanh thu</a>
      <hr />
      <a href="../admin_login.php?logout=1" style="color: #ff6b6b">Đăng xuất</a>
    </div>

    <div class="main-content">
      <?php if(isset($_SESSION['thongbao'])): ?>
  <div class="alert alert-info alert-dismissible fade show" role="alert">
    <strong><?= htmlspecialchars($_SESSION['thongbao']) ?></strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <?php unset($_SESSION['thongbao']); // Xóa để không hiện lại khi refresh ?>
  <?php endif; ?>
      <h2 class="mb-4">DANH SÁCH KHÁCH HÀNG</h2>

      <form method="GET" class="mb-4">
        <div class="input-group" style="max-width: 550px">
          <input
            type="text"
            name="q"
            class="form-control form-control-lg"
            placeholder="Tìm tên, email, số điện thoại..."
            value="<?=htmlspecialchars($search)?>"
          />
          <button class="btn btn-primary btn-lg">Tìm</button>
          <?php if($search): ?><a
            href="user.php"
            class="btn btn-outline-secondary btn-lg"
            >Xóa lọc</a
          ><?php endif; ?>
        </div>
      </form>

      <div class="table-responsive">
        <table class="table table-hover align-middle table-bordered">
          <thead class="table-dark">
            <tr>
                <th>ID</th>
              <th>Họ tên</th>
              <th>Email</th>
              <th>Số điện thoại</th>
              <th>Ngày đăng ký</th>
              <th>Trạng thái</th>
              <th>Thao tác</th>
            </tr>
          </thead>
          <tbody>
            <?php while($row = mysqli_fetch_assoc($rs)): 
                $active = ($row['active'] ?? 1) == 1;
            ?>
                <tr>
                    <td class="text-center fw-bold"><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['fullname'] ?? $row['name'] ?? $row['ho_ten'] ?? 'Chưa có tên') ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= $row['phone'] ?? '<small class="text-muted">Chưa có</small>' ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($row['created_at'] ?? $row['ngaytao'] ?? 'now')) ?></td>
                    <td>
                        <span class="badge <?= $active ? 'bg-success' : 'bg-danger' ?>">
                            <?= $active ? 'Hoạt động' : 'Bị khóa' ?>
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="view_user.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm">Xem</a>
                        <a href="delete_user.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                           onclick="return confirm('Xóa vĩnh viễn khách này?')">Xóa</a>
                           <a href="user_orders.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm" title="Xem đơn hàng">
                          <i class="fas fa-shopping-bag"></i> Đơn hàng
                           </a><a href="lock_user.php?id=<?= $row['id'] ?>" 
                           class="btn <?= $active?'btn-warning':'btn-success' ?> btn-sm">
                            <?= $active?'Khóa':'Mở' ?>
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
            <?php if(mysqli_num_rows($rs)==0): ?>
            <tr>
              <td colspan="7" class="text-center py-4 text-muted">
                Không có dữ liệu
              </td>
            </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- Phân trang (nếu cần) -->
      <?php if($total_pages >
      1): ?>
      <nav class="mt-4">
        <ul class="pagination justify-content-center">
          <?php for($i=1;$i<=$total_pages;$i++): ?>
          <li class="page-item <?=($i==$page?'active':'')?>">
            <a class="page-link" href="?q=<?=urlencode($search)?>&page=<?=$i?>"
              ><?=$i?></a
            >
          </li>
          <?php endfor; ?>
        </ul>
      </nav>
      <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
