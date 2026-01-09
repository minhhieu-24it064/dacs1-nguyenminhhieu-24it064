<?php 
session_start(); 
$msg  = $_SESSION['msg'] ?? '';
$type = $_SESSION['msg_type'] ?? 'danger';
unset($_SESSION['msg'], $_SESSION['msg_type']);
?>
<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Đăng Nhập & Đăng Ký - VH Beauty</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
    />
    <link rel="stylesheet" href="index.css" />
    <style>
      body {
        background: linear-gradient(135deg, #fff1f8 0%, #ffeef5 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
      }
      .auth-container {
        max-width: 480px;
        width: 100%;
        background: rgba(255, 255, 255, 0.98);
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(255, 105, 180, 0.25);
      }
      .auth-header {
        text-align: center;
        padding: 2rem 1rem 1rem;
        background: linear-gradient(45deg, #ec3673, #ff69b4);
        color: white;
      }
      .auth-header img {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        border: 5px solid rgba(255, 255, 255, 0.3);
        margin-bottom: 1rem;
      }
      .nav-tabs {
        border: none;
        justify-content: center;
        background: #f8f9fa;
      }
      .nav-tabs .nav-link {
        border: none;
        border-radius: 50px;
        padding: 12px 30px;
        font-weight: 600;
        color: #666;
        margin: 10px 5px;
      }
      .nav-tabs .nav-link.active {
        background: linear-gradient(45deg, #ec3673, #ff69b4);
        color: white;
        box-shadow: 0 5px 15px rgba(236, 54, 115, 0.4);
      }
      .tab-content {
        padding: 2.5rem;
      }
      .btn-auth {
        background: linear-gradient(45deg, #ec3673, #ff1493);
        border: none;
        padding: 13px;
        font-size: 1.1rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.4s;
      }
      .btn-auth:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 25px rgba(236, 54, 115, 0.4);
      }
      .form-control {
        border-radius: 12px;
        padding: 12px 15px;
        border: 1.5px solid #ffe0ec;
      }
      .form-control:focus {
        border-color: #ff69b4;
        box-shadow: 0 0 0 0.2rem rgba(255, 105, 180, 0.25);
      }
      .back-home {
        position: absolute;
        top: 20px;
        left: 20px;
        color: #ec3673;
        font-size: 1.1rem;
        text-decoration: none;
        font-weight: 600;
        z-index: 10;
      }
    </style>
  </head>
  <body>
    <a href="../trangchu.php" class="back-home"
      ><i class="bi bi-arrow-left-circle me-2"></i>Back to Home</a
    >

    <div class="auth-container">
      <!-- Header -->
      <div class="auth-header">
        <img src="../../image/logo.jpg" alt="VH Beauty" />
        <h3>VH Beauty</h3>
        <p class="mb-0">Nơi tôn vinh vẻ đẹp tự nhiên</p>
      </div>

      <!-- Hiển thị thông báo lỗi / thành công -->
<?php if (!empty($msg)): ?>
<div class="px-4 pt-3">
  <div class="alert alert-<?= $type === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
    <strong>
      <i class="bi <?= $type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill' ?> me-2"></i>
      <?= htmlspecialchars($msg) ?>
    </strong>

    <!-- Hiển thị thông tin liên hệ chỉ khi tài khoản bị khóa -->
    <?php if (strpos($msg, 'bị khóa') !== false): ?>
      <hr class="my-2">
      <small class="d-block">
        Vui lòng liên hệ hỗ trợ để được mở khóa:<br>
        <i class="bi bi-envelope"></i> <strong>support@vhbeauty.vn</strong><br>
        <i class="bi bi-telephone"></i> Hotline: <strong>0908 123 456</strong>
      </small>
    <?php endif; ?>

    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
</div>
<?php endif; ?>

      <!-- Tabs Đăng nhập / Đăng ký -->
      <ul class="nav nav-tabs" id="authTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button
            class="nav-link active"
            id="login-tab"
            data-bs-toggle="tab"
            data-bs-target="#login"
            type="button"
          >
            Đăng Nhập
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button
            class="nav-link"
            id="register-tab"
            data-bs-toggle="tab"
            data-bs-target="#register"
            type="button"
          >
            Đăng Ký
          </button>
        </li>
      </ul>

      <div class="tab-content" id="authTabContent">
        <!-- ==================== ĐĂNG NHẬP ==================== -->
        <div class="tab-pane fade show active" id="login">
          <form action="process_login.php" method="POST" class="mt-3">
            <div class="mb-3">
              <label class="form-label">Email hoặc Số điện thoại</label>
              <input
                type="text"
                class="form-control"
                name="username"
                required
                placeholder="email hoặc số điện thoại"
              />
            </div>
            <div class="mb-3">
              <label class="form-label">Mật khẩu</label>
              <input
                type="password"
                class="form-control"
                name="password"
                required
                placeholder="••••••••"
              />
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4">
              <div class="form-check">
                <input type="checkbox" class="form-check-input" id="remember" />
                <label class="form-check-label" for="remember"
                  >Ghi nhớ tôi</label
                >
              </div>
              <a
                href="forgot_password.php"
                class="text-decoration-none"
                style="color: #ec3673; font-size: 0.9rem"
                >Quên mật khẩu?</a
              >
            </div>
            <button type="submit" class="btn btn-auth w-100 text-white">
              Đăng Nhập Ngay
            </button>
          </form>
        </div>

        <!-- ==================== ĐĂNG KÝ ==================== -->
        <div class="tab-pane fade" id="register">
          <form action="process_register.php" method="POST" class="mt-3">
            <div class="mb-3">
              <label class="form-label">Họ và tên</label>
              <input
                type="text"
                class="form-control"
                name="fullname"
                required
                placeholder="Nguyễn Thị Mỹ Linh"
              />
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input
                type="email"
                class="form-control"
                name="email"
                required
                placeholder="example@gmail.com"
              />
            </div>
            <div class="mb-3">
              <label class="form-label">Số điện thoại</label>
              <input
                type="text"
                class="form-control"
                name="phone"
                required
                placeholder="0901234567"
                pattern="[0-9]{10,11}"
              />
            </div>
            <div class="mb-3">
              <label class="form-label">Mật khẩu</label>
              <input
                type="password"
                class="form-control"
                name="password"
                required
                placeholder="Tối thiểu 6 ký tự"
              />
            </div>
            <div class="mb-4">
              <label class="form-label">Nhập lại mật khẩu</label>
              <input
                type="password"
                class="form-control"
                name="repassword"
                required
                placeholder="Nhập lại mật khẩu"
              />
            </div>
            <div class="form-check mb-4">
              <input
                type="checkbox"
                class="form-check-input"
                id="agree"
                required
              />
              <label class="form-check-label" for="agree">
                Tôi đồng ý với
                <a href="#" style="color: #ec3673">điều khoản dịch vụ</a>
              </label>
            </div>
            <button type="submit" class="btn btn-auth w-100 text-white">
              Tạo Tài Khoản Mới
            </button>
          </form>
        </div>
      </div>

      <div class="text-center py-3 text-muted small">
        © 2025 VH Beauty - Designed by Tamhien
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
