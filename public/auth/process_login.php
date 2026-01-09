<?php
session_start();
$db = new mysqli("localhost", "root", "", "webmypham");
if ($db->connect_error) {
    die("Lỗi kết nối CSDL");
}
$db->set_charset("utf8mb4");

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    $_SESSION['msg'] = "Vui lòng nhập đầy đủ thông tin!";
    $_SESSION['msg_type'] = "danger";
    header("Location: log.php");
    exit;
}

// Tìm user theo email hoặc phone, chỉ lấy role = 'user'
$stmt = $stmt = $db->prepare("
    SELECT id, fullname, password, active 
    FROM users 
    WHERE (email = ? OR phone = ?) 
      AND role = 'user' 
    LIMIT 1
");
$stmt->bind_param("ss", $username, $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['msg'] = "Tài khoản không tồn tại hoặc bạn không phải khách hàng!";
    $_SESSION['msg_type'] = "danger";
    header("Location: log.php");
    exit;
}

$user = $result->fetch_assoc();

// Kiểm tra tài khoản có bị khóa không
if ($user['active'] == 0) {
    $_SESSION['msg'] = "Tài khoản của bạn đã bị khóa! Vui lòng liên hệ hỗ trợ.";
    $_SESSION['msg_type'] = "danger";
    header("Location: log.php");
    exit;
}

// Kiểm tra mật khẩu
if (!password_verify($password, $user['password'])) {
    $_SESSION['msg'] = "Mật khẩu không đúng!";
    $_SESSION['msg_type'] = "danger";
    header("Location: log.php");
    exit;
}

// ĐĂNG NHẬP THÀNH CÔNG
$_SESSION['user_id']  = $user['id'];
$_SESSION['fullname'] = $user['fullname'];
$_SESSION['role']     = 'user';

$_SESSION['msg']      = "Chào mừng " . htmlspecialchars($user['fullname']) . " quay lại!";
$_SESSION['msg_type'] = "success";

header("Location: ../../public/trangchu.php");
exit;
?>