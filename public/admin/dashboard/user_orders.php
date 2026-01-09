<?php
require_once '../check_login.php';
if (!isset($_GET['id'])) die("Lỗi: Không có khách hàng!");

$user_id = intval($_GET['id']);
$conn = mysqli_connect("localhost", "root", "", "webmypham");

// Lấy thông tin khách
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT fullname, email, phone FROM users WHERE id = $user_id"));

// Lấy tất cả ĐƠN HÀNG của khách
$order_query = mysqli_query($conn, "SELECT * FROM orders WHERE user_id = $user_id ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Đơn hàng của <?= htmlspecialchars($user['fullname'] ?? 'Khách') ?> - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { background:#f8f9fa; margin:0; font-family:Arial,sans-serif; }
        .sidebar { background:#343a40; color:white; height:100vh; padding:20px; position:fixed; width:220px; top:0; left:0; overflow-y:auto; box-shadow:3px 0 10px rgba(0,0,0,0.2); }
        .sidebar h3 { text-align:center; margin-bottom:30px; font-weight:bold; color:#0dcaf0; }
        .sidebar a { color:white; display:block; padding:12px 15px; text-decoration:none; border-radius:8px; margin:5px 0; transition:0.3s; }
        .sidebar a:hover, .sidebar a.active { background:#495057; font-weight:bold; transform:translateX(5px); }
        .main-content { margin-left:240px; padding:30px; }
        .back-btn { margin-bottom:20px; }
        .order-card { border:none; border-radius:16px; box-shadow:0 8px 25px rgba(236,54,115,0.15); margin-bottom:25px; }
        .order-header { background:linear-gradient(45deg,#ec3673,#ff69b4); color:white; padding:15px 20px; border-radius:16px 16px 0 0; }
        .product-item { display:flex; align-items:center; padding:12px 0; border-bottom:1px solid #eee; }
        .product-img { width:70px; height:70px; object-fit:cover; border-radius:12px; margin-right:15px; }
        .status-badge { padding:8px 20px; border-radius:50px; font-weight:bold; }
        .status-pending { background:#fff3cd; color:#856404; }
        .status-confirmed { background:#d1ecf1; color:#0c5460; }
        .status-shipping { background:#fff0e6; color:#d4380d; }
        .status-delivered { background:#e6f4ea; color:#28a745; }
        .status-cancelled { background:#f8d7da; color:#721c24; }
    </style>
</head>
<body>

<div class="sidebar">
    <h3>VH Beauty</h3>
    <a href="product.php">Sản phẩm</a>
    <a href="category.php">Danh mục</a>
    <a href="orders.php">Đơn hàng</a>
    <a href="user.php" class="active">Khách hàng</a>
    <hr style="border-color:#555;">
    <a href="../auth/logout.php" style="color:#ff6b6b">Đăng xuất</a>
</div>

<div class="main-content">
    <a href="user.php" class="btn btn-secondary back-btn">Quay lại danh sách khách</a>

    <div class="card order-card p-4 mb-4">
        <h4>Thông tin khách hàng</h4>
        <p><strong>Họ tên:</strong> <?= htmlspecialchars($user['fullname'] ?? 'Chưa có') ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        <p><strong>SĐT:</strong> <?= $user['phone'] ?? 'Chưa có' ?></p>
    </div>

    <?php if (mysqli_num_rows($order_query) == 0): ?>
        <div class="text-center py-5">
            <h5 class="text-muted">Khách này chưa có đơn hàng nào</h5>
        </div>
    <?php else: ?>
        <?php while ($order = mysqli_fetch_assoc($order_query)): ?>
            <div class="card order-card">
                <div class="order-header d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Mã đơn: <?= $order['order_code'] ?></strong>
                        <span class="ms-3">| <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></span>
                    </div>
                    <span class="status-badge <?= 
                        $order['status']=='pending' ? 'status-pending' :
                        ($order['status']=='confirmed' ? 'status-confirmed' :
                        ($order['status']=='shipping' ? 'status-shipping' :
                        ($order['status']=='delivered' ? 'status-delivered' : 'status-cancelled')))
                    ?>">
                        <?= 
                        $order['status']=='pending' ? 'Chưa xác nhận' :
                        ($order['status']=='confirmed' ? 'Đã xác nhận' :
                        ($order['status']=='shipping' ? 'Đang giao' :
                        ($order['status']=='delivered' ? 'Đã giao' : 'Đã hủy')))
                        ?>
                    </span>
                </div>

                <div class="card-body">
                    <?php
                    // LẤY CHI TIẾT SẢN PHẨM CỦA TỪNG ĐƠN HÀNG
                    $items_stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");
                    $items_stmt->bind_param("i", $order['id']);
                    $items_stmt->execute();
                    $items_result = $items_stmt->get_result();
                    while ($item = $items_result->fetch_assoc()):
                    ?>
                        <div class="product-item">
                            <img src="../admin/uploads/<?= $item['product_image'] ?: 'no-image.jpg' ?>" class="product-img" alt="">
                            <div class="flex-grow-1">
                                <strong><?= htmlspecialchars($item['product_name']) ?></strong><br>
                                <small class="text-muted">Phân loại: Standard</small>
                            </div>
                            <div class="text-end">
                                <div>x<?= $item['quantity'] ?></div>
                                <div class="text-danger fw-bold"><?= number_format($item['price']) ?>.000đ</div>
                            </div>
                        </div>
                    <?php endwhile; ?>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Tổng tiền:</h5>
                        <h4 class="text-danger fw-bold"><?= number_format($order['total_amount']) ?>.000đ</h4>
                    </div>


                </div>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</div>

</body>
</html>