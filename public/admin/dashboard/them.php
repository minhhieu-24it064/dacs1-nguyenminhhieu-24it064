<?php 
require_once '../check_login.php'; 
$conn = mysqli_connect("localhost","root","","webmypham");
mysqli_set_charset($conn,"utf8mb4");

$message = "";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $name        = trim($_POST['name']);
    $price       = (int)$_POST['price'];
    $quantity    = (int)$_POST['quantity'];
    $category_id = (int)$_POST['category_id'];

    // === XỬ LÝ ẢNH ===
    $anh = "";
    $upload_dir = "../uploads/";

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
        $tenanh = preg_replace('/[^A-Za-z0-9\.\-\_]/', '', $_FILES['image']['name']);
        $anh = time() . "_" . $tenanh;
        $duongdan = $upload_dir . $anh;

        if(!move_uploaded_file($_FILES['image']['tmp_name'], $duongdan)){
            $message = '<div class="alert alert-danger">Upload ảnh thất bại! Kiểm tra quyền thư mục uploads.</div>';
            $anh = "";
        }
    } else {
        $message = '<div class="alert alert-danger">Vui lòng chọn ảnh sản phẩm!</div>';
    }

    if($message == "" && $anh != ""){
        $sql = "INSERT INTO sanpham (name, price, quantity, image, category_id) 
                VALUES ('$name', $price, $quantity, '$anh', $category_id)";
        
        if(mysqli_query($conn, $sql)){
            header("Location: product.php?success=1");
            exit;
        } else {
            $message = '<div class="alert alert-danger">Lỗi CSDL: '.mysqli_error($conn).'</div>';
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Thêm sản phẩm mới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background:#f8f9fa;
            padding:30px;
            font-family:Arial,sans-serif;
        }
        .card {
            max-width:500px;
            margin:auto;
            box-shadow:0 8px 20px rgba(0,0,0,0.15);
        }
        .card-header {
            background:#ec3673;
        }
        .btn-success {
            background:#ec3673;
            border:none;
        }
        .btn-success:hover {
            background:#c2185b;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card mx-auto shadow">
        <div class="card-header text-white text-center">
            <h4 class="mb-0">THÊM SẢN PHẨM MỚI</h4>
        </div>
        <div class="card-body p-4">

            <?= $message ?>

            <form action="" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label fw-bold">Tên sản phẩm</label>
                    <input type="text" name="name" class="form-control" required autofocus>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Giá (VNĐ)</label>
                        <input type="number" name="price" class="form-control" required min="0">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Số lượng</label>
                        <input type="number" name="quantity" class="form-control" required min="0">
                    </div>
                </div>

                <div class="my-3">
                    <label class="form-label fw-bold">Danh mục</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">-- Chọn danh mục --</option>
                        <?php
                        $dm = mysqli_query($conn, "SELECT * FROM danhmuc ORDER BY name");
                        while($row = mysqli_fetch_assoc($dm)){
                            $selected = (isset($_GET['cat_id']) && $_GET['cat_id'] == $row['id']) ? 'selected' : '';
                            echo "<option value='{$row['id']}' $selected>{$row['name']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Ảnh sản phẩm</label>
                    <input type="file" name="image" class="form-control" accept="image/*" required>
                    <small class="text-muted">Định dạng: JPG, PNG, WebP. Tối đa 5MB.</small>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success px-4">Thêm sản phẩm</button>
                    <a href="product.php" class="btn btn-secondary px-4">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
