<?php
include 'menu.php'; 

if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

// === XỬ LÝ ĐẶT HÀNG – PHIÊN BẢN HOÀN CHỈNH & CHẮC CHẮN TRỪ KHO ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['phone'])) {
    $conn = mysqli_connect("localhost", "root", "", "webmypham");
    mysqli_set_charset($conn, "utf8mb4");

    mysqli_begin_transaction($conn);
    try {
        // 1. Tạo đơn hàng trước (chưa có total_amount)
        $stmt = $conn->prepare("INSERT INTO orders 
            (user_id, customer_phone, customer_address, customer_note, payment_method, status) 
            VALUES (?, ?, ?, ?, ?, 'pending')");
        $stmt->bind_param("issss", $_SESSION['user_id'], $_POST['phone'], $_POST['address'], $_POST['note'], $_POST['payment']);
        $stmt->execute();
        $order_id = $conn->insert_id;

        // Tạo mã đơn hàng đẹp
        $order_code = "VH" . date('Ymd') . str_pad($order_id, 6, '0', STR_PAD_LEFT);
        $stmt = $conn->prepare("UPDATE orders SET order_code = ? WHERE id = ?");
        $stmt->bind_param("si", $order_code, $order_id);
        $stmt->execute();

        $total_amount = 0;

        // Chuẩn bị các câu lệnh
        $stmt_item  = $conn->prepare("INSERT INTO order_items 
            (order_id, product_id, product_name, product_image, price, quantity, subtotal) 
            VALUES (?, ?, ?, ?, ?, ?, ?)");

        // QUAN TRỌNG: Dùng khóa FOR UPDATE để tránh race condition + kiểm tra tồn kho chính xác
        $stmt_check = $conn->prepare("SELECT name, price, image, quantity FROM sanpham WHERE id = ? FOR UPDATE");
        $stmt_update = $conn->prepare("UPDATE sanpham SET quantity = quantity - ?, quantity_sold = quantity_sold + ? WHERE id = ?");

        foreach ($_SESSION['cart'] as $id => $qty) {
            $id = (int)$id;
            $qty = (int)$qty;

            // Lấy sản phẩm + khóa dòng (FOR UPDATE)
            $stmt_check->bind_param("i", $id);
            $stmt_check->execute();
            $res = $stmt_check->get_result();
            if (!$product = $res->fetch_assoc()) {
                throw new Exception("Sản phẩm ID $id không tồn tại!");
            }
            if ($product['quantity'] < $qty) {
                throw new Exception("Sản phẩm '{$product['name']}' chỉ còn {$product['quantity']} sản phẩm (bạn chọn $qty)!");
            }

            $subtotal = $product['price'] * $qty;
            $total_amount += $subtotal;

            // Lưu chi tiết đơn hàng
            $stmt_item->bind_param("iisssii", $order_id, $id, $product['name'], $product['image'], $product['price'], $qty, $subtotal);
            $stmt_item->execute();

            // TRỪ KHO + TĂNG ĐÃ BÁN (chắc chắn thành công vì đã kiểm tra ở trên)
            $stmt_update->bind_param("iii", $qty, $qty, $id);
            $stmt_update->execute();
        }

        // Cập nhật tổng tiền
        $stmt = $conn->prepare("UPDATE orders SET total_amount = ? WHERE id = ?");
        $stmt->bind_param("di", $total_amount, $order_id);
        $stmt->execute();

        mysqli_commit($conn);

        // Xóa giỏ hàng
        unset($_SESSION['cart']);

        echo '<script>
                alert("Đặt hàng thành công! Mã đơn: ' . $order_code . '");
                window.location.href = "orders.php";
              </script>';
        exit;

    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo '<script>alert("Lỗi đặt hàng: ' . addslashes($e->getMessage()) . '");</script>';
    }
}
// Lấy sản phẩm để hiển thị
$selected_items = $_SESSION['cart'] ?? [];
$total_amount = 0;
$products_list = [];
$conn = mysqli_connect("localhost", "root", "", "webmypham");

foreach ($selected_items as $id => $qty) {
    $stmt = $conn->prepare("SELECT name, price, image FROM sanpham WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $total_amount += $row['price'] * $qty;
        $products_list[] = [
            'id' => $id,
            'name' => $row['name'],
            'image' => $row['image'],
            'price' => $row['price'],
            'qty' => $qty,
            'total' => $row['price'] * $qty
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Thanh toán - VH Beauty</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    .checkout-header { background: linear-gradient(45deg, #ec3673, #ff69b4); color: white; padding: 2rem 0; }
    .product-thumb { width: 70px; height: 70px; object-fit: cover; border-radius: 10px; }
    .total-final { font-size: 2rem; font-weight: bold; color: #e91e63; }
    .btn-confirm { background: linear-gradient(45deg, #ec3673, #c2185b); border: none; padding: 15px 50px; font-size: 1.4rem; border-radius: 50px; min-width: 250px; }
    .form-control:focus { border-color: #ec3673; box-shadow: 0 0 0 0.2rem rgba(236,54,115,.25); }
  </style>
</head>
<body>

<div class="checkout-header text-center">
  <h1>Thanh toán đơn hàng</h1>
  <p class="mb-0">Vui lòng kiểm tra thông tin trước khi đặt hàng</p>
</div>

<div class="container my-5">
  <div class="row g-5">
    <!-- Form đặt hàng -->
    <div class="col-lg-8">
      <div class="card border-0 shadow-lg">
        <div class="card-header bg-pink text-white">
          <h5 class="mb-0">Thông tin nhận hàng</h5>
        </div>
        <div class="card-body">
          <!-- SỬA: Thêm id="checkoutForm" -->
          <form method="post" action="checkout.php" id="checkoutForm">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fw-bold">Số điện thoại *</label>
                <input type="text" name="phone" class="form-control form-control-lg" required>
              </div>
              <div class="col-12">
                <label class="form-label fw-bold">Địa chỉ giao hàng *</label>
                <input type="text" name="address" class="form-control form-control-lg" required>
              </div>
              <div class="col-12">
                <label class="form-label fw-bold">Ghi chú</label>
                <textarea name="note" class="form-control" rows="3"></textarea>
              </div>
              <div class="col-12 mt-4">
                <h5 class="fw-bold">Phương thức thanh toán</h5>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="payment" value="cod" id="cod" checked>
                  <label class="form-check-label" for="cod">Thanh toán khi nhận hàng (COD)</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="payment" value="bank" id="bank">
                  <label class="form-check-label" for="bank">Chuyển khoản ngân hàng</label>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Danh sách sản phẩm & Tổng tiền -->
    <div class="col-lg-4">
      <div class="card border-0 shadow-lg sticky-top" style="top: 20px;">
        <div class="card-header bg-pink text-white">
          <h5 class="mb-0">Đơn hàng (<?= count($products_list) ?> sản phẩm)</h5>
        </div>
        <div class="card-body">
          <?php foreach ($products_list as $item): ?>
            <div class="d-flex mb-3 pb-3 border-bottom">
              <img src="admin/uploads/<?= $item['image'] ?: 'no-image.jpg' ?>" class="product-thumb me-3" alt="<?= htmlspecialchars($item['name']) ?>">
              <div class="flex-grow-1">
                <strong><?= htmlspecialchars($item['name']) ?></strong>
                <small class="text-muted d-block">Số lượng: <?= $item['qty'] ?></small>
                <div class="text-danger fw-bold"><?= number_format($item['total']) ?>.000₫</div>
              </div>
            </div>
          <?php endforeach; ?>

          <div class="pt-3 border-top">
            <div class="d-flex justify-content-between mb-2">
              <span>Tạm tính:</span>
              <strong><?= number_format($total_amount) ?>.000₫</strong>
            </div>
            <div class="d-flex justify-content-between mb-2">
              <span>Phí vận chuyển:</span>
              <strong class="text-success">Miễn phí</strong>
            </div>
            <div class="d-flex justify-content-between mt-4">
              <h4 class="fw-bold">Tổng cộng:</h4>
              <h4 class="total-final"><?= number_format($total_amount) ?>.000₫</h4>
            </div>
          </div>

          <!-- SỬA: Nút nằm trong form và có form="checkoutForm" -->
          <button type="submit" form="checkoutForm" class="btn btn-confirm text-white w-100 mt-4 shadow-lg">
            HOÀN TẤT ĐẶT HÀNG
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>