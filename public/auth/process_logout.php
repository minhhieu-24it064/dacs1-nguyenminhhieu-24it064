<?php
session_start();
session_unset();
session_destroy();

$_SESSION['msg'] = "Bạn đã đăng xuất thành công!";
$_SESSION['msg_type'] = "success";

header("Location: ../public/index.php");
exit;
?>