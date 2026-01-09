
  <?php
require_once '../check_login.php';

$conn = mysqli_connect("localhost","root","","webmypham");
mysqli_set_charset($conn,"utf8mb4");

$id = intval($_GET['id'] ?? 0);

if ($id <= 0) {
    $_SESSION['thongbao'] = "ID khách hàng không hợp lệ!";
    header("Location: user.php");
    exit;
}

// Kiểm tra xem có tồn tại và KHÔNG PHẢI admin không
$check = mysqli_query($conn, "SELECT id FROM users WHERE id = $id AND role != 'admin' LIMIT 1");

if (mysqli_num_rows($check) == 0) {
    $_SESSION['thongbao'] = "Không thể xóa: Đây là tài khoản quản trị hoặc không tồn tại!";
    header("Location: user.php");
    exit;
}

// XÓA THẬT - chỉ 1 dòng này là đủ (không cần xóa avatar)
$result = mysqli_query($conn, "DELETE FROM users WHERE id = $id");

if ($result) {
    $_SESSION['thongbao'] = "Đã xóa khách hàng thành công!";
} else {
    $_SESSION['thongbao'] = "Xóa thất bại, vui lòng thử lại!";
}

header("Location: user.php");
exit;  
