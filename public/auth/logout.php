<?php
session_start();
session_unset();   // xóa tất cả biến session
session_destroy(); // hủy session
header("Location: log.php"); // quay về trang chủ sau khi đăng xuất
exit;
?>
