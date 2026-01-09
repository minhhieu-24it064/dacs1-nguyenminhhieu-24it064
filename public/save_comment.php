<?php
$conn = mysqli_connect("localhost", "root", "", "webmypham");
mysqli_set_charset($conn, "utf8mb4");
session_start();
if (!isset($_SESSION['user_id'])) {
    $_SESSION['msg'] = "Bạn cần đăng nhập để bình luận!";
    $_SESSION['msg_type'] = "danger";
    header("Location: auth/log.php");
    exit;
}

$product_id = intval($_POST['product_id'] ?? 0);
$comment    = trim($_POST['comment'] ?? '');
$rating     = intval($_POST['rating'] ?? 0);

if ($product_id <= 0 || empty($comment) || $rating < 1 || $rating > 5) {
    $_SESSION['msg'] = "Bình luận hoặc đánh giá không hợp lệ!";
    $_SESSION['msg_type'] = "danger";
    header("Location: chitietsanpham.php?id=" . $product_id);
    exit;
}

// Lấy tên từ DB
$user_id = $_SESSION['user_id'];
$stmtUser = $conn->prepare("SELECT fullname FROM users WHERE id=? LIMIT 1");
$stmtUser->bind_param("i", $user_id);
$stmtUser->execute();
$resUser = $stmtUser->get_result();
$user = $resUser->fetch_assoc();
$author = $user['fullname'] ?? 'Khách';

// Lưu bình luận + đánh giá
$stmt = $conn->prepare("INSERT INTO comments (product_id, user_id, author, content, rating, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
$stmt->bind_param("iissi", $product_id, $user_id, $author, $comment, $rating);

if ($stmt->execute()) {
    $_SESSION['msg'] = "Bình luận và đánh giá đã được gửi!";
    $_SESSION['msg_type'] = "success";
} else {
    $_SESSION['msg'] = "Có lỗi xảy ra khi lưu!";
    $_SESSION['msg_type'] = "danger";
}

header("Location: chitietsanpham.php?id=" . $product_id);
exit;
?>
