<?php
session_start();
$db = new mysqli("localhost", "root", "", "webmypham");
if ($db->connect_error) die("Kết nối CSDL thất bại");

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    $_SESSION['error'] = "Nhập đầy đủ đi bro!";
    header("Location: admin_login.php");
    exit;
}

$stmt = $db->prepare("SELECT id, fullname FROM users WHERE (email=? OR phone=?) AND role='admin' LIMIT 1");
$stmt->bind_param("ss", $username, $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    $_SESSION['error'] = "Không phải admin hoặc không tồn tại!";
    header("Location: admin_login.php");
    exit;
}

$user = $result->fetch_assoc();



// THÀNH CÔNG
$_SESSION['admin_id'] = $user['id'];
$_SESSION['admin_name'] = $user['fullname'];
unset($_SESSION['error']);

header("Location: dashboard/product.php");
exit;
?>