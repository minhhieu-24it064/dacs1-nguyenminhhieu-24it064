<?php
require_once '../check_login.php';
$conn = mysqli_connect("localhost","root","","webmypham");
mysqli_set_charset($conn,"utf8mb4");

$idsp = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if($idsp <= 0) { header("Location: product.php"); exit; }

// LẤY DỮ LIỆU SẢN PHẨM + DANH MỤC
$sql = "SELECT sp.*, dm.name AS cat_name 
        FROM sanpham sp 
        LEFT JOIN danhmuc dm ON sp.category_id = dm.id 
        WHERE sp.id = $idsp";
$ketqua = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($ketqua);

if(!$row) { header("Location: product.php"); exit; }

// KHI NHẤN NÚT CẬP NHẬT
if(isset($_POST['update'])){
    $name        = trim($_POST['name']);
    $price       = (int)$_POST['price'];
    $quantity    = (int)$_POST['quantity'];
    $category_id = (int)$_POST['category_id'];
    $anh_moi     = $row['image']; // giữ ảnh cũ mặc định

    // Xử lý ảnh mới (nếu có)
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
        // Xóa ảnh cũ nếu tồn tại
        if($row['image'] && file_exists("../uploads/".$row['image'])){
            unlink("../uploads/".$row['image']);
        }
        // Upload ảnh mới
        $tenanh = $_FILES['image']['name'];
        $anh_moi = time() . "_" . $tenanh;
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/".$anh_moi);
    }

    // Cập nhật toàn bộ thông tin (bao gồm category_id)
    $sql = "UPDATE sanpham SET 
            name = '$name',
            price = $price,
            quantity = $quantity,
            image = '$anh_moi',
            category_id = $category_id
            WHERE id = $idsp";

    if(mysqli_query($conn, $sql)){
        header("Location: product.php?success=1");
        exit;
    } else {
        $error = "Lỗi cập nhật: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sửa sản phẩm - VH Beauty</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{background:#f8f9fa; padding:50px}
        .card{max-width:600px; margin:auto; box-shadow:0 10px 30px rgba(0,0,0,0.1);}
        .current-img{max-width:150px; border-radius:10px; margin:10px 0;}
    </style>
</head>
<body>
<div class="container">
    <div class="card mx-auto">
        <div class="card-header bg-warning text-dark text-center">
            <h3>SỬA SẢN PHẨM</h3>
        </div>
        <div class="card-body">

            <?php if(isset($error)): ?>
                <div class="alert alert-danger text-center"><?= $error ?></div>
            <?php endif; ?>

            <form action="" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label fw-bold">Tên sản phẩm</label>
                    <input type="text" name="name" class="form-control form-control-lg" 
                           value="<?= htmlspecialchars($row['name']) ?>" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Giá (VNĐ)</label>
                        <input type="number" name="price" class="form-control" 
                               value="<?= $row['price'] ?>" required min="0">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Số lượng</label>
                        <input type="number" name="quantity" class="form-control" 
                               value="<?= $row['quantity'] ?>" required min="0">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Danh mục</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">-- Chọn danh mục --</option>
                        <?php
                        $dm_query = mysqli_query($conn, "SELECT * FROM danhmuc ORDER BY name");
                        while($dm = mysqli_fetch_assoc($dm_query)){
                            $selected = ($dm['id'] == $row['category_id']) ? 'selected' : '';
                            echo '<option value="'.$dm['id'].'" '.$selected.'>'.$dm['name'].'</option>';
                        }
                        ?>
                    </select>
                    <small class="text-muted">Hiện tại: <strong><?= htmlspecialchars($row['cat_name'] ?? 'Chưa có danh mục') ?></strong></small>
                </div>

                <div class="mb-4 text-center">
                    <label class="form-label fw-bold d-block">Ảnh hiện tại</label>
                    <?php if($row['image']): ?>
                        <img src="../uploads/<?= $row['image'] ?>" class="current-img" alt="Ảnh sản phẩm">
                    <?php else: ?>
                        <p class="text-muted">Chưa có ảnh</p>
                    <?php endif; ?>
                    <small class="text-muted d-block mt-2">Chọn ảnh mới để thay đổi</small>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Chọn ảnh mới (không chọn = giữ ảnh cũ)</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>

                <div class="text-center">
                    <button type="submit" name="update" class="btn btn-warning btn-lg px-5">
                        CẬP NHẬT SẢN PHẨM
                    </button>
                    <a href="product.php" class="btn btn-secondary btn-lg px-5">
                        Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>