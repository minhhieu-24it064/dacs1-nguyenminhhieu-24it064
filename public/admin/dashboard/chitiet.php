<?php
require_once '../check_login.php'; 
$conn = mysqli_connect("localhost","root","","webmypham");
mysqli_set_charset($conn,"utf8mb4");

$id = (int)($_GET['id'] ?? 0);
$sql = "SELECT sp.*, dm.name AS cat_name 
        FROM sanpham sp 
        LEFT JOIN danhmuc dm ON sp.category_id = dm.id 
        WHERE sp.id = $id";
$rs = mysqli_query($conn, $sql);
$product = mysqli_fetch_assoc($rs);
?>
<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="UTF-8" />
    <title>Chi tiết sản phẩm - VH Beauty</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <style>
      body {
        background: linear-gradient(135deg, #fff1f8 0%, #ffeef5 100%);
        font-family: Arial, sans-serif;
      }
      .container {
        max-width: 800px;
        margin-top: 40px;
      }
      .product-img {
        max-width: 300px;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
      }
      .card {
        border-radius: 16px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
      }
      .price {
        font-size: 1.5rem;
        color: #e91e63;
        font-weight: bold;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="card p-4">
        <?php if($product): ?>
        <div class="row">
          <div class="col-md-5 text-center">
            <?php if($product['image'] && file_exists("../uploads/".$product['image'])): ?>
            <img
              src="../uploads/<?= $product['image'] ?>"
              class="product-img"
              alt="<?= htmlspecialchars($product['name']) ?>"
            />
            <?php else: ?>
            <img
              src="../image/no-image.jpg"
              class="product-img"
              alt="No image"
            />
            <?php endif; ?>
          </div>
          <div class="col-md-7">
            <h3 class="fw-bold mb-3">
              <?= htmlspecialchars($product['name']) ?>
            </h3>
            <p>
              <strong>Danh mục:</strong>
              <?= $product['cat_name'] ?: 'Chưa có danh mục' ?>
            </p>
            <p class="price"><?= number_format($product['price']) ?>.000₫</p>
            <p>
              <strong>Số lượng trong kho:</strong>
              <?= $product['quantity'] ?>
            </p>
            <p>
              <strong>Đã bán:</strong>
              <?= $product['quantity_sold'] ?? 0 ?>
            </p>
            <div class="mt-4">
              <a href="sua.php?id=<?= $product['id'] ?>" class="btn btn-warning"
                >Sửa</a
              >
              <a href="product.php" class="btn btn-secondary"
                >Quay lại danh sách</a
              >
            </div>
          </div>
        </div>
        <?php else: ?>
        <div class="alert alert-danger text-center">
          Không tìm thấy sản phẩm!
        </div>
        <div class="text-center">
          <a href="product.php" class="btn btn-secondary">Quay lại danh sách</a>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </body>
</html>
