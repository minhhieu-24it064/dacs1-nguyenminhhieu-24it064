<?php
require_once '../check_login.php';
$conn = mysqli_connect("localhost","root","","webmypham");

$id = $_GET['id'] ?? 0;
$id = intval($id);

// Lấy trạng thái hiện tại
$status = mysqli_fetch_array(mysqli_query($conn, "SELECT active FROM users WHERE id = $id"))['active'] ?? 1;

// Đảo ngược trạng thái: 1 → 0, 0 → 1
$new_status = ($status == 1) ? 0 : 1;

mysqli_query($conn, "UPDATE users SET active = $new_status WHERE id = $id");

$_SESSION['thongbao'] = "Đã " . ($new_status == 1 ? "mở khóa" : "khóa") . " tài khoản thành công!";
header("Location: user.php");
exit;