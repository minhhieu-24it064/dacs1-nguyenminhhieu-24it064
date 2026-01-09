<?php
session_start();
$conn = mysqli_connect("localhost","root","","webmypham");
mysqli_set_charset($conn,"utf8mb4");

// Autoload PHPMailer (chỉ cần require một lần ở đầu file)
require __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


// Lấy dữ liệu từ form
$email        = $_POST['email'] ?? '';
$code         = $_POST['code'] ?? '';
$new_password = $_POST['new_password'] ?? '';
$re_password  = $_POST['re_password'] ?? '';

/* ========== 1. GỬI MÃ XÁC NHẬN ========== */
if(isset($_POST['send_code'])){
    if($email == ''){
        $_SESSION['msg'] = "Vui lòng nhập email!";
        $_SESSION['msg_type'] = "danger";
        header("Location: forgot_password.php");
        exit;
    }

    // Kiểm tra email có tồn tại
    $safeEmail = mysqli_real_escape_string($conn,$email);
    $sql = "SELECT id FROM users WHERE email='$safeEmail'";
    $rs  = mysqli_query($conn,$sql);
    if(!$rs || mysqli_num_rows($rs) == 0){
        $_SESSION['msg'] = "Email không tồn tại!";
        $_SESSION['msg_type'] = "danger";
        header("Location: forgot_password.php");
        exit;
    }

    // Tạo mã ngẫu nhiên
    $reset_code = rand(100000,999999);

    // Lưu mã vào DB
    mysqli_query($conn,"UPDATE users SET reset_code='$reset_code' WHERE email='$safeEmail'");

    // Gửi mail bằng PHPMailer (dùng tên lớp đầy đủ)
    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'hotamhienqt@gmail.com'; // Gmail của bạn
        $mail->Password = 'ikvrgjmhkezadfuf';        // App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('yourgmail@gmail.com', 'VH Beauty');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Ma xac nhan quen mat khau';
        $mail->Body    = "Mã xác nhận của bạn là: <b>$reset_code</b>";

        $mail->send();
        $_SESSION['msg'] = "Mã xác nhận đã được gửi tới email!";
        $_SESSION['msg_type'] = "success";
    } catch (\PHPMailer\PHPMailer\Exception $e) {
        $_SESSION['msg'] = "Không gửi được email. Lỗi: ".$e->getMessage();
        $_SESSION['msg_type'] = "danger";
    }

    header("Location: forgot_password.php");
    exit;
}

/* ========== 2. ĐỔI MẬT KHẨU ========== */
if(isset($_POST['reset_password'])){
    if($email == '' || $code == '' || $new_password == '' || $re_password == ''){
        $_SESSION['msg'] = "Vui lòng nhập đầy đủ thông tin!";
        $_SESSION['msg_type'] = "danger";
        header("Location: forgot_password.php");
        exit;
    }

    if($new_password != $re_password){
        $_SESSION['msg'] = "Mật khẩu nhập lại không khớp!";
        $_SESSION['msg_type'] = "danger";
        header("Location: forgot_password.php");
        exit;
    }

    $safeEmail = mysqli_real_escape_string($conn,$email);
    $safeCode  = mysqli_real_escape_string($conn,$code);

    // Kiểm tra mã xác nhận
    $sql = "SELECT id FROM users WHERE email='$safeEmail' AND reset_code='$safeCode'";
    $rs  = mysqli_query($conn,$sql);
    if(!$rs || mysqli_num_rows($rs) == 0){
        $_SESSION['msg'] = "Mã xác nhận không đúng!";
        $_SESSION['msg_type'] = "danger";
        header("Location: forgot_password.php");
        exit;
    }

    // Cập nhật mật khẩu mới (hash để bảo mật)
    $hashed = password_hash($new_password, PASSWORD_DEFAULT);
    mysqli_query($conn,"UPDATE users SET password='$hashed', reset_code=NULL WHERE email='$safeEmail'");

    $_SESSION['msg'] = "Đổi mật khẩu thành công! Vui lòng đăng nhập lại.";
    $_SESSION['msg_type'] = "success";
    header("Location: log.php"); // quay về trang login
    exit;
}
