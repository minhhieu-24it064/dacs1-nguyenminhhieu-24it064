<?php
$conn = mysqli_connect("localhost", "root", "", "webmypham");
mysqli_set_charset($conn, "utf8mb4");
// Lấy từ khóa tìm kiếm và category id
$q = trim($_GET['q'] ?? '');
$category_id = intval($_GET['category'] ?? 0);

// Phân trang
$limit = 12;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

// Truy vấn sản phẩm
if (!empty($q)) {
    $stmt = $conn->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM sanpham WHERE name LIKE ? ORDER BY id DESC LIMIT ?,?");
    $searchTerm = "%".$q."%";
    $stmt->bind_param("sii", $searchTerm, $offset, $limit);
} elseif ($category_id > 0) {
    $stmt = $conn->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM sanpham WHERE category_id=? ORDER BY id DESC LIMIT ?,?");
    $stmt->bind_param("iii", $category_id, $offset, $limit);
} else {
    $stmt = $conn->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM sanpham ORDER BY id DESC LIMIT ?,?");
    $stmt->bind_param("ii", $offset, $limit);
}
$stmt->execute();
$result = $stmt->get_result();

// Tổng số sản phẩm
$totalResult = $conn->query("SELECT FOUND_ROWS() as total")->fetch_assoc();
$total_products = $totalResult['total'];
$total_pages = ceil($total_products / $limit);

// Danh mục
$categories = $conn->query("SELECT * FROM danhmuc ORDER BY name ASC");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Sản phẩm - VH Beauty</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="assets/CSS/index.css">
  
  <style>
    .category-list { list-style: none; padding: 0; margin: 0; }
    .category-list li { margin-bottom: 10px; }
    .category-list a {
      display: block; padding: 8px 12px; background: #fa5d94ff; color: #fff;
      border-radius: 6px; text-decoration: none;
    }
    .category-list a:hover, .category-list a.active { background: #c2185b; }
    .btn-back {
      display: block; padding: 8px 12px; background-color: #f8bbd0; color: #880e4f;
      border-radius: 6px; text-decoration: none; margin-bottom: 12px;
    }
    .btn-back:hover { background-color: #ec407a; color: #fff; }
  </style>
</head>
<body>

<?php include 'menu.php'; ?>

<div class="container py-5">
  <div class="row">
    <!-- Sidebar trái -->
    <div class="col-md-3">
      <h5 class="mb-3">Danh mục sản phẩm</h5>
      <ul class="category-list">
        <?php while($cat = $categories->fetch_assoc()): ?>
          <li>
            <a href="sanpham.php?category=<?= $cat['id'] ?>" 
               class="<?= ($category_id==$cat['id']?'active':'') ?>">
              <?= htmlspecialchars($cat['name']) ?>
            </a>
          </li>
        <?php endwhile; ?> 

        <?php if($category_id > 0): ?>
          <a href="sanpham.php" class="btn-back">Quay lại tất cả sản phẩm</a>
        <?php endif; ?>
      </ul>
    </div>

    <!-- Sản phẩm -->
    <div class="col-md-9">
      <?php if(empty($q) && $category_id == 0): ?>
        <section class="all-title" style="text-align:center; margin-bottom:40px;">
          <h2>SẢN PHẨM NỔI BẬT</h2>
        </section>
      <?php endif; ?>

      <?php if(!empty($q)): ?>
        <h4 class="mb-4">Kết quả tìm kiếm cho: "<?= htmlspecialchars($q) ?>"</h4>
      <?php elseif($category_id > 0): ?>
        <?php
          $cat_name = $conn->query("SELECT name FROM danhmuc WHERE id=$category_id")->fetch_assoc()['name'] ?? '';
        ?>
        <h4 class="mb-4">Danh mục: <?= htmlspecialchars($cat_name) ?></h4>
      <?php endif; ?>

      <section class="product">
        <?php if ($result->num_rows == 0): ?>
          <div class="text-center py-5">
            <h3 class="text-muted">Không tìm thấy sản phẩm nào</h3>
          </div>
        <?php else: while ($p = $result->fetch_assoc()): ?>
          <div class="container-product">
            <a href="chitietsanpham.php?id=<?= $p['id'] ?>" class="text-decoration-none">
              <?php if(!empty($p['image']) && file_exists(__DIR__."/admin/uploads/".$p['image'])): ?>
                <img src="admin/uploads/<?= $p['image'] ?>" alt="<?= htmlspecialchars($p['name']) ?>">
              <?php else: ?>
                <img src="admin/uploads/no-image.jpg" alt="No image">
              <?php endif; ?>
              <h5><?= htmlspecialchars($p['name']) ?></h5>
              <p><?= number_format($p['price']) ?>.000₫</p>
            </a>
          </div>
        <?php endwhile; endif; ?>
      </section>

      <!-- PHÂN TRANG ĐÃ SỬA ĐÚNG -->
      <?php if ($total_pages > 1): ?>
        <nav class="mt-5">
          <ul class="pagination justify-content-center">
            <?php for($i = 1; $i <= $total_pages; $i++): ?>
              <li class="page-item <?= ($i == $page ? 'active' : '') ?>">
                <a class="page-link" 
                   href="sanpham.php?page=<?= $i ?><?= !empty($q) ? '&q=' . urlencode($q) : '' ?><?= $category_id > 0 ? '&category=' . $category_id : '' ?>">
                  <?= $i ?>
                </a>
              </li>
            <?php endfor; ?>
          </ul>
        </nav>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>