<?php
$conn = mysqli_connect("localhost", "root", "", "webmypham");
mysqli_set_charset($conn, "utf8mb4");

// === XỬ LÝ XÓA BẰNG PHP – NHƯNG KHÔNG DÙNG header() → KHÔNG LỖI ===
if (isset($_GET['remove'])) {
    $id = intval($_GET['remove']);
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
        if (empty($_SESSION['cart'])) {
            unset($_SESSION['cart']);
        }
    }
    // DÙNG JS ĐỂ TẢI LẠI TRANG – TRÁNH HOÀN TOÀN LỖI HEADER
    echo '<script>window.location.href = "cart.php";</script>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Giỏ hàng - VH Beauty</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    .cart-table th {
      background: linear-gradient(45deg, #ec3673, #ff69b4);
      color: white;
      font-weight: 600;
    }
    .product-thumb {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .total-price {
      font-size: 1.8rem;
      font-weight: bold;
      color: #e91e63;
    }
    .btn-buy-now {
      background: linear-gradient(45deg, #ec3673, #c2185b);
      border: none;
      padding: 16px 50px;
      font-size: 1.3rem;
      border-radius: 50px;
      min-width: 220px;
    }
    .btn-buy-now:disabled {
      background: #ccc;
      cursor: not-allowed;
    }
    .form-check-input:checked {
      background-color: #ec3673;
      border-color: #ec3673;
    }
  </style>
</head>
<body>
<?php include "menu.php"; ?>

<div class="container py-5">
  <h2 class="text-center text-danger mb-4 fw-bold">
    <i class="fas fa-shopping-cart me-2"></i> Giỏ hàng của bạn
  </h2>

  
  <?php if (empty($_SESSION['cart'])): ?>
    <div class="text-center py-5">
      <img src="admin/uploads/empty-cart.png" alt="Giỏ trống" class="img-fluid mb-4" style="max-width: 300px;">
      <h4 class="text-muted">Giỏ hàng trống</h4>
      <a href="sanpham.php" class="btn btn-outline-danger btn-lg">Tiếp tục mua sắm</a>
    </div>
  <?php else: ?>
    <form method="post" action="checkout.php" id="cartForm">
      <div class="table-responsive">
        <table class="table table-hover align-middle cart-table">
          <thead>
            <tr>
              <th width="5%">
                <input type="checkbox" class="form-check-input" id="selectAll">
              </th>
              <th width="40%">Sản phẩm</th>
              <th>Đơn giá</th>
              <th>Số lượng</th>
              <th>Thành tiền</th>
              <th>Thao tác</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $total_all = 0;
            foreach ($_SESSION['cart'] as $id => $qty):
              $stmt = $conn->prepare("SELECT id, name, price, image FROM sanpham WHERE id = ?");
              $stmt->bind_param("i", $id);
              $stmt->execute();
              $result = $stmt->get_result();
              if ($row = $result->fetch_assoc()):
                $thanhtien = $row['price'] * $qty;
            ?>
              <tr>
                <td>
                  <input type="checkbox" name="selected[]" value="<?= $id ?>" class="form-check-input item-check" checked>
                </td>
                <td>
                  <div class="d-flex align-items-center gap-3">
                    <?php if (!empty($row['image']) && file_exists("admin/uploads/".$row['image'])): ?>
                      <img src="admin/uploads/<?= $row['image'] ?>" class="product-thumb" alt="<?= htmlspecialchars($row['name']) ?>">
                    <?php else: ?>
                      <img src="admin/uploads/no-image.jpg" class="product-thumb" alt="No image">
                    <?php endif; ?>
                    <strong><?= htmlspecialchars($row['name']) ?></strong>
                  </div>
                </td>
                <td class="text-danger fw-bold"><?= number_format($row['price']) ?>.000₫</td>
                <td class="fw-bold"><?= $qty ?></td>
                <td class="text-danger fw-bold item-total" data-price="<?= $row['price'] * $qty ?>">
                  <?= number_format($thanhtien) ?>  
                </td>
                <td>
                  <a href="cart.php?remove=<?= $id ?>" class="btn btn-sm btn-outline-danger"
                     onclick="return confirm('Xóa sản phẩm này?')">
                    <i class="fas fa-trash"></i>
                  </a>
                </td>
              </tr>
            <?php endif; endforeach; ?>
          </tbody>
        </table>
      </div>

      <!-- Tổng tiền + Nút thanh toán -->
      <div class="card border-0 shadow-lg mt-4">
        <div class="card-body bg-light rounded">
          <div class="row align-items-center">
            <div class="col-12 col-md-6 text-center text-md-start">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="selectAllBottom" checked>
                <label class="form-check-label fw-bold">Chọn tất cả</label>
              </div>
              <h4 class="mt-3 mb-0">
                Tổng tiền: <span id="totalDisplay" class="total-price">0₫</span>
              </h4>
            </div>
            <div class="col-12 col-md-6 text-center text-md-end mt-3 mt-md-0">
              <button type="submit" class="btn btn-buy-now text-white shadow-lg" id="buyButton">
                <i class="fas fa-bolt fa-lg me-2"></i> MUA NGAY
              </button>
            </div>
          </div>
        </div>
      </div>
    </form>
    <div class="text-center mt-4">
      <a href="sanpham.php" class="btn btn-outline-secondary">Tiếp tục mua sắm</a>
    </div>
  <?php endif; ?>
</div>


<script>
// Tự động tính tổng tiền khi tích chọn
function updateTotal() {
  let total = 0;
  document.querySelectorAll('.item-check:checked').forEach(cb => {
    const row = cb.closest('tr');
    const priceText = row.querySelector('.item-total').innerText;
    const price = parseInt(priceText.replace(/[^0-9]/g, '')) * 1000; // vì giá có .000
    total += price;
  });
  document.getElementById('totalDisplay').innerText = 
    total.toLocaleString('vi-VN') + '₫';
}

// Tích tất cả
document.getElementById('selectAll').onchange = function() {
  document.querySelectorAll('.item-check').forEach(cb => cb.checked = this.checked);
  document.getElementById('selectAllBottom').checked = this.checked;
  updateTotal();
};
document.getElementById('selectAllBottom').onchange = function() {
  document.getElementById('selectAll').checked = this.checked;
  document.querySelectorAll('.item-check').forEach(cb => cb.checked = this.checked);
  updateTotal();
};

// Cập nhật khi thay đổi từng ô
document.querySelectorAll('.item-check').forEach(cb => {
  cb.onchange = updateTotal;
});

// Khởi động: tính tổng lần đầu
updateTotal();

// Disable nút nếu không chọn gì
document.getElementById('cartForm').onsubmit = function(e) {
  if (document.querySelectorAll('.item-check:checked').length === 0) {
    alert('Vui lòng chọn ít nhất 1 sản phẩm để thanh toán!');
    e.preventDefault();
  }
};
</script>

<?php include 'footer.php'; ?>

</body>
</html> 