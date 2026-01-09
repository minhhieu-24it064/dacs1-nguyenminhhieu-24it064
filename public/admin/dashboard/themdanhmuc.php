<?php 
require_once '../check_login.php'; 
$conn = mysqli_connect("localhost","root","","webmypham");
mysqli_set_charset($conn,"utf8mb4");

$message = "";
$new_id = null;

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $name = trim($_POST['name']);

    if(empty($name)){
        $message = '<div class="alert alert-danger text-center">Vui lòng nhập tên danh mục!</div>';
    } else {
        // Kiểm tra trùng tên (không phân biệt hoa thường)
        $check = mysqli_query($conn, "SELECT id FROM danhmuc WHERE LOWER(name) = LOWER('" . mysqli_real_escape_string($conn, $name) . "')");
        if(mysqli_num_rows($check) > 0){
            $message = '<div class="alert alert-warning text-center">Danh mục "<strong>'.$name.'</strong>" đã tồn tại!</div>';
        } else {
            $sql = "INSERT INTO danhmuc (name) VALUES ('" . mysqli_real_escape_string($conn, $name) . "')";
            if(mysqli_query($conn, $sql)){
                $new_id = mysqli_insert_id($conn);
                $message = '<div class="alert alert-success text-center">
                                Thêm thành công danh mục "<strong>'.$name.'</strong>"<br>
                                <strong>ID: '.$new_id.'</strong>
                            </div>';
                header("Refresh: 2; url=category.php?cat_id=$new_id");
                echo '<div class="text-center mt-3">
                        <small class="text-muted">Đang chuyển đến trang thêm sản phẩm...</small>
                      </div>';
            } else {
                $message = '<div class="alert alert-danger text-center">Lỗi: '.mysqli_error($conn).'</div>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>Thêm danh mục mới</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    body {
      background: #f8f9fa;
      padding: 30px;
    }
    .card {
      max-width: 380px;
    }
    .card-header {
      background: #ec3673;
    }
    .btn-success {
      background: #ec3673;
      border: none;
    }
    .btn-success:hover {
      background: #c2185b;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="card mx-auto shadow">
      <div class="card-header text-white text-center">
        <h4 class="mb-0">THÊM DANH MỤC MỚI</h4>
      </div>
      <div class="card-body">
        <?= $message ?>

        <?php if(!$new_id || !empty($message)): ?>
        <form action="" method="POST">
          <div class="mb-3">
            <label class="form-label fw-bold">Tên danh mục</label>
            <input type="text" name="name" class="form-control" 
                   placeholder="Ví dụ: Son môi, Kem dưỡng, Nước tẩy trang..." required autofocus />
          </div>

          <div class="text-center">
            <button type="submit" class="btn btn-success px-4">Thêm ngay</button>
            <a href="category.php" class="btn btn-secondary px-4">Quay lại</a>
          </div>
        </form>
        <?php else: ?>
        <div class="text-center py-4">
          <i class="fas fa-check-circle text-success" style="font-size: 3rem"></i>
          <h5 class="mt-3 text-success">Thêm danh mục thành công!</h5>
          <p>Đang chuyển đến trang thêm sản phẩm...</p>
          <a href="them.php?cat_id=<?= $new_id ?>" class="btn btn-primary mt-3">
            Tiếp tục thêm sản phẩm với danh mục này
          </a>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
</body>
</html>
