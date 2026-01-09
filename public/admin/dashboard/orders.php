<?php
require_once '../check_login.php'; // File kiểm tra đăng nhập admin (giống product.php)

$conn = mysqli_connect("localhost", "root", "", "webmypham");
mysqli_set_charset($conn, "utf8mb4");

// XỬ LÝ CẬP NHẬT TRẠNG THÁI
if (isset($_POST['update_status'])) {
    $order_id = intval($_POST['order_id']);
    $new_status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $order_id);
    $stmt->execute();

}

// LẤY TẤT CẢ ĐƠN HÀNG
$result = mysqli_query($conn, "SELECT o.*, u.fullname FROM orders o 
                               LEFT JOIN users u ON o.user_id = u.id 
                               ORDER BY o.created_at DESC");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Quản lý đơn hàng - Admin VH Beauty</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
  body {
  background: #f8f9fa;
  margin: 0;
  font-family: Arial, sans-serif;
}
.sidebar {
  background: #343a40;
  color: white;
  height: 100vh;
  padding: 20px;
  position: fixed;
  width: 220px;
  top: 0;
  left: 0;
  overflow-y: auto;
  box-shadow: 3px 0 10px rgba(0, 0, 0, 0.2);
}
.sidebar h3 {
  text-align: center;
  margin-bottom: 30px;
  font-weight: bold;
  color: #0dcaf0;
}
.sidebar a {
  color: white;
  display: block;
  padding: 12px 15px;
  text-decoration: none;
  border-radius: 8px;
  margin: 5px 0;
  transition: 0.3s;
}
.sidebar a:hover,
.sidebar a.active {
  background: #495057;
  font-weight: bold;
  transform: translateX(5px);
}
.main-content {
  margin-left: 240px;
  padding: 30px;
}
.order-card {
  border: none;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 8px 25px rgba(236, 54, 115, 0.15);
  margin-bottom: 25px;
}

.status-pending {
  background: #fff3cd;
  color: #856404;
}
.status-confirmed {
  background: #d1ecf1;
  color: #0c5460;
}
.status-shipping {
  background: #d4edda;
  color: #155724;
}
.status-delivered {
  background: #e6f4ea;
  color: #28a745;
}
.status-cancelled {
  background: #f8d7da;
  color: #721c24;
}
.product-thumb {
  width: 60px;
  height: 60px;
  object-fit: cover;
  border-radius: 10px;
}

    </style>
</head>
<body>

<!-- SIDEBAR GIỐNG PRODUCT.PHP -->
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

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Quản lý đơn hàng</h2>
        <span class="badge bg-danger fs-5">Tổng: <?= mysqli_num_rows($result) ?> đơn</span>
    </div>

    <?php if (mysqli_num_rows($result) == 0): ?>
        <div class="text-center py-5">
            <h4 class="text-muted">Chưa có đơn hàng nào</h4>
        </div>
    <?php else: ?>
        <?php while ($order = mysqli_fetch_assoc($result)): 
            $status_text = [
                'pending' => ['Chưa xác nhận', 'status-pending'],
                'confirmed' => ['Đã xác nhận', 'status-confirmed'],
                'shipping' => ['Đang giao', 'status-shipping'],
                'delivered' => ['Đã giao', 'status-delivered'],
                'cancelled' => ['Đã hủy', 'status-cancelled']
            ][$order['status']] ?? ['Chưa xác nhận', 'status-pending'];
        ?>
            <div class="card order-card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(45deg, #ec3673, #ff69b4); color: white;">
                    <div>
                        <strong>Mã đơn: <?= $order['order_code'] ?></strong>
                        <span class="ms-3">| <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></span>
                        <span class="ms-3">| Khách: <?= htmlspecialchars($order['fullname'] ?? 'Khách lẻ') ?></span>
                    </div>
                    <span class="badge <?= $status_text[1] ?> fs-6 px-4 py-2">
                        <?= $status_text[0] ?>
                    </span>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>SĐT:</strong> <?= $order['customer_phone'] ?></p>
                            <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($order['customer_address']) ?></p>
                            <?php if ($order['customer_note']): ?>
                                <p><strong>Ghi chú:</strong> <?= htmlspecialchars($order['customer_note']) ?></p>
                            <?php endif; ?>
                            <p><strong>Thanh toán:</strong> <?= $order['payment_method'] == 'cod' ? 'COD' : 'Chuyển khoản' ?></p>
                        </div>
                        <div class="col-md-6">
                            <?php
                            $items_stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");
                            $items_stmt->bind_param("i", $order['id']);
                            $items_stmt->execute();
                            $items = $items_stmt->get_result();
                            while ($item = $items->fetch_assoc()):
                            ?>
                                <div class="d-flex align-items-center mb-2">
                                  <img src="../../admin/uploads/<?= $item['product_image'] ?: 'no-image.jpg' ?>" class="product-thumb me-3" alt="">
                                    <div>
                                        <strong><?= htmlspecialchars($item['product_name']) ?></strong><br>
                                        <small>x<?= $item['quantity'] ?> × <?= number_format($item['price']) ?>.000đ</small>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Tổng tiền: 
                            <span class="text-danger fw-bold fs-4"><?= number_format($order['total_amount']) ?>.000đ</span>
                        </h5>

                        <!-- FORM ĐỔI TRẠNG THÁI -->
                        
<form method="post" class="d-inline">
    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
    <input type="hidden" name="update_status" value="1"> <!-- BẮT BUỘC PHẢI CÓ DÒNG NÀY -->

    <select name="status" class="form-select d-inline-block w-auto me-2" onchange="this.form.submit()">
        <option value="pending" <?= $order['status']=='pending' ? 'selected' : '' ?>>Chưa xác nhận</option>
        <option value="confirmed" <?= $order['status']=='confirmed' ? 'selected' : '' ?>>Đã xác nhận</option>
        <option value="shipping" <?= $order['status']=='shipping' ? 'selected' : '' ?>>Đang giao</option>
        <option value="delivered" <?= $order['status']=='delivered' ? 'selected' : '' ?>>Đã giao</option>
        <option value="cancelled" <?= $order['status']=='cancelled' ? 'selected' : '' ?>>Hủy đơn</option>
    </select>

</form>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</div>

</body>
</html>