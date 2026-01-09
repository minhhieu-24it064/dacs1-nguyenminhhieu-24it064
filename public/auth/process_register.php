<?php
session_start();
$db = new mysqli("localhost", "root", "", "webmypham");
$db->set_charset("utf8mb4");

$fullname = trim($_POST['fullname'] ?? '');
$email    = trim($_POST['email'] ?? '');
$phone    = trim($_POST['phone'] ?? '');
$pass     = $_POST['password'] ?? '';
$repass   = $_POST['repassword'] ?? '';

if ($pass !== $repass) {
    $_SESSION['msg'] = "Mật khẩu nhập lại không khớp!";
} elseif (strlen($pass) < 6) {
    $_SESSION['msg'] = "Mật khẩu phải từ 6 ký tự trở lên!";
} else {
    // Kiểm tra trùng email hoặc phone
    $check = $db->prepare("SELECT id FROM users WHERE email=? OR phone=?");
    $check->bind_param("ss", $email, $phone);
    $check->execute();
    if ($check->get_result()->num_rows > 0) {
        $_SESSION['msg'] = "Email hoặc số điện thoại đã được sử dụng!";
    } else {
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO users (fullname, email, phone, password, role) VALUES (?, ?, ?, ?, 'user')");
        $stmt->bind_param("ssss", $fullname, $email, $phone, $hash);
        $stmt->execute();

        $_SESSION['msg'] = "Đăng ký thành công! Chào mừng bạn đến với VH Beauty";
        $_SESSION['msg_type'] = "success";
    }
}

header("Location: log.php");
exit;
?>