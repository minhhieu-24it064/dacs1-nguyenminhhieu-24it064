<?php
require_once 'menu.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/log.php");
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "webmypham");
mysqli_set_charset($conn, "utf8mb4");

// LẤY ĐƠN HÀNG CỦA USER
$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Giới Thiệu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    .order-item { border: 1px solid #eee; border-radius: 12px; margin-bottom: 20px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
    .order-header { background: linear-gradient(45deg, #ec3673, #ff69b4); color: white; padding: 15px 20px; }
    .product-img { width: 70px; height: 70px; object-fit: cover; border-radius: 10px; }
    .price-new { color: #ee4d2d; font-weight: bold; }
    .status-badge { padding: 8px 20px; border-radius: 50px; font-weight: bold; font-size: 0.95rem; }
    .status-pending { background: #fff3cd; color: #856404; }
    .status-confirmed { background: #d1ecf1; color: #0c5460; }
    .status-shipping { background: #fff0e6; color: #d4380d; }
    .status-delivered { background: #e6f4ea; color: #28a745; }
    .status-cancelled { background: #f8d7da; color: #721c24; }
  </style>
</head>
<body>

<div class="container py-4">
  <h2 class="text-center text-danger mb-5 fw-bold fs-3">Lịch sử đơn hàng của bạn</h2>

  <?php if ($result->num_rows == 0): ?>
    <div class="text-center py-5">
      <img src="admin/uploads/empty-order.png" alt="Chưa có đơn hàng" class="img-fluid mb-4" style="max-width: 280px;">
      <h5 class="text-muted">Bạn chưa có đơn hàng nào</h5>
      <a href="sanpham.php" class="btn btn-danger btn-lg px-5 mt-3 rounded-pill">Mua sắm ngay</a>
    </div>
  <?php else: ?>
    <?php while ($order = $result->fetch_assoc()): 
      // ĐÃ SỬA: HIỂN THỊ ĐÚNG TẤT CẢ TRẠNG THÁI
      $status_info = [
        'pending'    => ['Chưa xác nhận', 'status-pending'],
        'confirmed'  => ['Đã xác nhận', 'status-confirmed'],
        'shipping'   => ['Đang giao hàng', 'status-shipping'],
        'delivered'  => ['Đã giao hàng', 'status-delivered'],
        'cancelled'  => ['Đã hủy', 'status-cancelled']
      ][$order['status']] ?? ['Chưa xác nhận', 'status-pending'];
    ?>
      <div class="order-item">
        <div class="order-header d-flex justify-content-between align-items-center">
          <div>
            <strong>VH Beauty</strong>
            <span class="ms-3 text-white small">Mã đơn: <?= $order['order_code'] ?></span>
          </div>
          <span class="status-badge <?= $status_info[1] ?>">
            <?= $status_info[0] ?>
          </span>
        </div>

        <div class="p-4">
          <?php
          $stmt2 = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");
          $stmt2->bind_param("i", $order['id']);
          $stmt2->execute();
          $items = $stmt2->get_result();
          while ($item = $items->fetch_assoc()):
          ?>
            <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
              <img src="admin/uploads/<?= $item['product_image'] ?: 'no-image.jpg' ?>" class="product-img me-3" alt="">
              <div class="flex-grow-1">
                <strong><?= htmlspecialchars($item['product_name']) ?></strong>
                <div class="text-muted small">Phân loại: Standard</div>
                <div class="quantity d-inline-block mt-1">x<?= $item['quantity'] ?></div>
              </div>
              <div class="text-end">
                <div class="price-new"><?= number_format($item['price']) ?>.000đ</div>
              </div>
            </div>
          <?php endwhile; ?>

          <div class="text-end mt-4 pt-3 border-top">
            <strong class="fs-5">Thành tiền:</strong>
            <span class="text-danger fs-4 fw-bold"><?= number_format($order['total_amount']) ?>.000đ</span>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
</body>
</html>