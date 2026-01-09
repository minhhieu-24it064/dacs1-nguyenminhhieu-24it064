<?php
$conn = mysqli_connect("localhost", "root", "", "webmypham");
mysqli_set_charset($conn, "utf8mb4");


$id = intval($_GET['id'] ?? 0);
$result = mysqli_query($conn, "SELECT * FROM sanpham WHERE id=$id LIMIT 1");
$product = mysqli_fetch_assoc($result);

if (!$product) {
    echo "<h2 class='text-center text-danger'>Sản phẩm không tồn tại!</h2>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($product['name']) ?> - VH Beauty</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'menu.php'; ?>

<div class="container py-5">
    <button onclick="history.back()" class="btn btn-secondary mt-3">
  ⬅ Quay lại
</button>

  <div class="row">
    <!-- Hình ảnh -->
    <div class="col-md-4">
      <?php if(!empty($product['image']) && file_exists(__DIR__."/admin/uploads/".$product['image'])): ?>
        <img src="admin/uploads/<?= $product['image'] ?>" class="img-fluid rounded shadow" alt="<?= htmlspecialchars($product['name']) ?>">
      <?php else: ?>
        <img src="admin/uploads/no-image.jpg" class="img-fluid rounded shadow" alt="No image">
      <?php endif; ?>
    </div>

    <!-- Thông tin -->
    <div class="col-md-6">
      <h2 class="fw-bold mb-3"><?= htmlspecialchars($product['name']) ?></h2>
      <p class="fs-4 text-danger mb-4"><?= number_format($product['price']) ?>.000₫</p>

      <!-- Dòng cam kết mua sắm - đẹp lung linh -->
<div class="commitment-bar bg-light border-top border-bottom py-3 my-4">
  <div class="container">
    <div class="row align-items-center text-center text-md-start">
      <div class="col-12 col-md-3 mb-3 mb-md-0">
        <h5 class="mb-0 fw-bold text-danger">
          <i class="fas fa-shield-alt me-2"></i> An tâm mua sắm cùng VH Beauty
        </h5>
      </div>
      <div class="col-12 col-md-9">
        <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-4 text-secondary fs-15">
          <span><i class="fas fa-undo text-success me-2"></i>Trả hàng miễn phí 15 ngày</span>
          <span><i class="fas fa-check-circle text-success me-2"></i>Chính hãng 100%</span>
          <span><i class="fas fa-truck text-success me-2"></i>Miễn phí vận chuyển</span>
          <span><i class="fas fa-handshake text-success me-2"></i>Bảo hiểm bảo vệ người tiêu dùng</span>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ===== SỐ LƯỢNG + NÚT MUA - PHIÊN BẢN SIÊU NHỎ GỌN, ĐẸP ===== -->
<div class="mt-5">

  <?php 
  $stock = ($product['quantity'] ?? 0) - ($product['quantity_sold'] ?? 0);
  $stock = $stock < 0 ? 0 : $stock;
  ?>

  <!-- Số lượng còn lại (dòng nhỏ gọn) -->
  <div class="mb-3 text-muted small">
    <i class="fas fa-cubes"></i>
    Còn lại: <strong class="text-danger"><?= $stock ?></strong> sản phẩm
    <?= $stock <= 0 ? '<span class="text-danger ms-2 fw-bold">• Hết hàng</span>' : '' ?>
  </div>

  <!-- Form chọn số lượng + 2 nút (siêu nhỏ gọn) -->
  <form method="post" action="add_to_cart.php">
    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

    <div class="d-flex align-items-center gap-3 flex-wrap">

      <!-- Ô số lượng nhỏ xinh -->
      <div class="d-flex align-items-center">
        <label class="me-2 fw-bold text-dark">SL:</label>
        <input type="number" name="quantity" value="1" min="1" max="<?= $stock ?>" 
               class="form-control text-center" 
               style="width: 80px; height: 42px;" 
               <?= $stock <= 0 ? 'disabled' : '' ?> required>
      </div>

      <!-- Nút Thêm vào giỏ (nhỏ nhưng đẹp) -->
      <button type="submit" name="action" value="add" 
              class="btn btn-outline-warning btn-sm px-4" 
              style="min-width: 140px;"
              <?= $stock <= 0 ? 'disabled' : '' ?>>
        <i class="fas fa-cart-plus"></i> Thêm giỏ
      </button>

      <!-- Nút Mua ngay (nổi bật) -->
      <button type="submit" name="action" value="buy_now" 
              class="btn btn-danger btn-sm px-4 fw-bold" 
              style="min-width: 140px;"
              <?= $stock <= 0 ? 'disabled' : '' ?>>
        <i class="fas fa-bolt"></i> Mua ngay
      </button>

      <input type="hidden" name="redirect" value="cart">
    </div>
  </form>

  <!-- Thông báo hết hàng (nếu có) -->
  <?php if($stock <= 0): ?>
    <div class="text-danger small mt-2">
      <i class="fas fa-times-circle"></i> Hiện tại sản phẩm đã hết hàng
    </div>
  <?php endif; ?>

</div>

  <!-- Thông báo hết hàng -->
  <?php if($stock <= 0): ?>
    <div class="alert alert-warning mt-4 text-center">
      <i class="fas fa-exclamation-triangle me-2"></i>
      Sản phẩm đã hết hàng. Vui lòng quay lại sau!
    </div>
  <?php endif; ?>

</div>

  <!-- Bình luận -->
  <div class="mt-5">
    <h4>Bình luận sản phẩm</h4>
    

    <?php if(isset($_SESSION['user_id'])): ?>
      <form method="post" action="save_comment.php" class="mb-4">
        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

        <!-- Đánh giá sao -->
        <div class="mb-3">
          <label class="form-label">Đánh giá sản phẩm:</label><br>
          <?php for($i=1; $i<=5; $i++): ?>
            <input type="radio" id="star<?= $i ?>" name="rating" value="<?= $i ?>" required>
            <label for="star<?= $i ?>">⭐</label>
          <?php endfor; ?>
        </div>

        <!-- Nội dung bình luận -->
        <div class="mb-3">
          <textarea name="comment" class="form-control" rows="3" placeholder="Viết bình luận..." required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Gửi bình luận</button>
      </form>
    <?php else: ?>
      <p class="text-muted">Bạn cần <a href="auth/log.php">đăng nhập</a> để bình luận và đánh giá.</p>
    <?php endif; ?>

    <!-- Danh sách bình luận -->
    <?php
    $comments = mysqli_query($conn, "SELECT * FROM comments WHERE product_id=$id ORDER BY created_at DESC");
    if (mysqli_num_rows($comments) > 0):
      while ($c = mysqli_fetch_assoc($comments)):
    ?>
      <div class="border rounded p-3 mb-2">
        <strong><?= htmlspecialchars($c['author']) ?>:</strong>
        <p class="mb-1"><?= htmlspecialchars($c['content']) ?></p>
        <p>
          <?php for($i=1; $i<=5; $i++): ?>
            <?= $i <= $c['rating'] ? "⭐" : "☆" ?>
          <?php endfor; ?>
        </p>
        <small class="text-muted"><?= $c['created_at'] ?></small>
      </div>
    <?php endwhile; else: ?>
      <p class="text-muted">Chưa có bình luận nào.</p>
    <?php endif; ?>
  </div>
</div>


<?php include 'footer.php'; ?>
</body>
</html>
