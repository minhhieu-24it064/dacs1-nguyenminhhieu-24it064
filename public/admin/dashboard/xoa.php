<?php
require_once '../check_login.php';
$conn = mysqli_connect("localhost", "root", "", "webmypham");
mysqli_set_charset($conn, "utf8mb4");

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0) {
    // Xóa ảnh cũ
    $sql = "SELECT image FROM sanpham WHERE id = $id";
    $r = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_array($r)) {
        $file = "../uploads/" . $row['image'];
        if (file_exists($file)) unlink($file);
    }
    // Xóa sản phẩm
    mysqli_query($conn, "DELETE FROM sanpham WHERE id = $id");
}
header("Location: product.php");
exit;
?>