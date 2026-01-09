<?php
session_start();

if (!isset($_SESSION['user_id']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['phone'])) {
    header("Location: checkout.php");
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "webmypham");
mysqli_set_charset($conn, "utf8mb4");

mysqli_begin_transaction($conn);
try {
    // Tạo mã đơn hàng
    $today_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM orders WHERE DATE(created_at) = CURDATE()"))['c'];
    $order_code = "VH" . date('Ymd') . str_pad($today_count + 1, 6, '0', STR_PAD_LEFT);

    // Tính tổng tiền
    $total_amount = 0;
    foreach ($_SESSION['cart'] as $id => $qty) {
        $stmt = $conn->prepare("SELECT price FROM sanpham WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $total_amount += $row['price'] * $qty;
        }
    }

    // Lưu đơn hàng chính
    $stmt = $conn->prepare("INSERT INTO orders (order_code, user_id, customer_phone, customer_address, customer_note, payment_method, total_amount, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')");
    $stmt->bind_param("sissssd", $order_code, $_SESSION['user_id'], $_POST['phone'], $_POST['address'], $_POST['note'], $_POST['payment'], $total_amount);
    $stmt->execute();
    $order_id = $conn->insert_id;

    // Lưu chi tiết sản phẩm
    $stmt_item = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, product_image, price, quantity, subtotal) VALUES (?, ?, ?, ?, ?, ?, ?)");
    foreach ($_SESSION['cart'] as $id => $qty) {
        $stmt_p = $conn->prepare("SELECT name, price, image FROM sanpham WHERE id = ?");
        $stmt_p->bind_param("i", $id);
        $stmt_p->execute();
        $res = $stmt_p->get_result();
        if ($p = $res->fetch_assoc()) {
            $subtotal = $p['price'] * $qty;
            $stmt_item->bind_param("iisssii", $order_id, $id, $p['name'], $p['image'], $p['price'], $qty, $subtotal);
            $stmt_item->execute();
        }
    }

    mysqli_commit($conn);

    // XÓA GIỎ HÀNG
    unset($_SESSION['cart']);

    // CHUYỂN TRANG AN TOÀN – KHÔNG LỖI HEADER!
    header("Location: orders.php?order=$order_code");
    exit;

} catch (Exception $e) {
    mysqli_rollback($conn);
    header("Location: checkout.php?error=1");
    exit;
}