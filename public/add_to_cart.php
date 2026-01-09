<?php
session_start();

// Kết nối CSDL (tùy chọn, nếu muốn kiểm tra tồn kho sau này)
$conn = mysqli_connect("localhost", "root", "", "webmypham");
mysqli_set_charset($conn, "utf8mb4");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: sanpham.php");
    exit;
}

// Lấy dữ liệu từ form
$product_id = intval($_POST['product_id'] ?? 0);
$quantity   = max(1, intval($_POST['quantity'] ?? 1));
$action     = $_POST['action'] ?? '';        // 'add' hoặc 'buy_now'
$redirect   = $_POST['redirect'] ?? '';      // 'cart' nếu có

if ($product_id <= 0) {
    header("Location: sanpham.php");
    exit;
}

// === THÊM SẢN PHẨM VÀO GIỎ HÀNG ===
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Nếu đã có trong giỏ → cộng dồn số lượng
if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id] += $quantity;
} else {
    $_SESSION['cart'][$product_id] = $quantity;
}

// === XỬ LÝ CHUYỂN HƯỚNG ===
if ($action === 'buy_now' || $redirect === 'cart') {
    // Mua ngay → chuyển thẳng sang giỏ hàng
    header("Location: sanpham.php");
    exit;
} else {
    // Thêm vào giỏ → quay lại trang trước đó (rất mượt)
    $referer = $_SERVER['HTTP_REFERER'] ?? 'sanpham.php';
    // Thêm thông báo thành công (tùy chọn)
    $_SESSION['success_message'] = "Đã thêm sản phẩm vào giỏ hàng!";
    header("Location: $referer");
    exit;
}
?>