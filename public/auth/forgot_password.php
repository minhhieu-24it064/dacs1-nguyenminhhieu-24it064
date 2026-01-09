<?php
session_start();
$msg  = $_SESSION['msg'] ?? '';
$type = $_SESSION['msg_type'] ?? 'danger';
unset($_SESSION['msg'], $_SESSION['msg_type']);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Quên mật khẩu - VH Beauty</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"/>
  <style>
    body {
      background: linear-gradient(135deg, #fff1f8 0%, #ffeef5 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      font-family: 'Segoe UI', Arial, sans-serif;
    }
    .reset-container {
      max-width: 480px;
      width: 100%;
      background: #fff;
      border-radius: 24px;
      box-shadow: 0 20px 50px rgba(236, 54, 115, 0.25);
      overflow: hidden;
    }
    .reset-header {
      text-align: center;
      padding: 2rem 1rem 1rem;
      background: linear-gradient(45deg, #ec3673, #ff69b4);
      color: white;
    }
    .reset-header img {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      border: 4px solid rgba(255,255,255,0.3);
      margin-bottom: 1rem;
    }
    .form-control {
      border-radius: 12px;
      padding: 12px 15px;
      border: 1.5px solid #ffe0ec;
    }
    .form-control:focus {
      border-color: #ff69b4;
      box-shadow: 0 0 0 0.2rem rgba(255,105,180,0.25);
    }
    .btn-reset {
      background: linear-gradient(45deg, #ec3673, #ff1493);
      border: none;
      padding: 13px;
      font-size: 1.1rem;
      border-radius: 50px;
      font-weight: 600;
      color: #fff;
      transition: all 0.4s;
    }
    .btn-reset:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 25px rgba(236,54,115,0.4);
    }
  </style>
</head>
<body>
  <div class="reset-container">
    <div class="reset-header">
      <img src="../../image/logo.jpg" alt="VH Beauty"/>
      <h3>VH Beauty</h3>
      <p class="mb-0">Khôi phục mật khẩu</p>
    </div>

    <?php if (!empty($msg)): ?>
    <div class="px-4 pt-3">
      <div class="alert alert-<?= $type === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
        <i class="bi <?= $type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill' ?> me-2"></i>
        <?= htmlspecialchars($msg) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    </div>
    <?php endif; ?>

    <div class="p-4">
      <form action="process_reset.php" method="POST">
        <!-- Bước 1: Nhập email -->
        <div class="mb-3">
          <label class="form-label">Email đã đăng ký</label>
          <input type="email" name="email" class="form-control" required placeholder="example@gmail.com">
        </div>

        <!-- Bước 2: Nhập mã xác nhận + nút gửi mã -->
        <div class="mb-3">
          <label class="form-label">Mã xác nhận</label>
          <div class="input-group">
            <input type="text" name="code" class="form-control" placeholder="Nhập mã đã gửi về email">
            <button type="submit" name="send_code" value="1" class="btn btn-outline-danger">Gửi mã</button>
          </div>
        </div>

        <!-- Bước 3: Đặt lại mật khẩu -->
        <div class="mb-3">
          <label class="form-label">Mật khẩu mới</label>
          <input type="password" name="new_password" class="form-control" placeholder="••••••••">
        </div>
        <div class="mb-4">
          <label class="form-label">Nhập lại mật khẩu mới</label>
          <input type="password" name="re_password" class="form-control" placeholder="••••••••">
        </div>

        <button type="submit" name="reset_password" value="1" class="btn btn-reset w-100">Xác nhận & Đổi mật khẩu</button>
      </form>
    </div>

    <div class="text-center py-3 text-muted small">
      © 2025 VH Beauty - Designed by Tamhien
    </div>
  </div>
</body>
</html>
