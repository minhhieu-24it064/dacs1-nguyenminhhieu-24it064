<?php session_start(); ?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    body {
      background: linear-gradient(135deg, #fff1f8 0%, #ffeef5 100%);  
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', Arial, sans-serif;
    }

          .login-card {
        max-width: 480px;
        width: 100%;
        background: rgba(255, 255, 255, 0.98);
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(255, 105, 180, 0.25);
      }
      .login-header {
        text-align: center;
        padding: 2rem 1rem 1rem;
        background: linear-gradient(45deg, #ec3673, #ff69b4);
        color: white;
      }
      .login-header img {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        border: 5px solid rgba(255, 255, 255, 0.3);
        margin-bottom: 1rem;
      }
      .form-control {
        border-radius: 12px;
        padding: 12px 15px;
        border: 1.5px solid #ffe0ec;
      }
    .btn-login {
        background: linear-gradient(45deg, #ec3673, #ff1493);
        color: #ffff;
        border: none;
        padding: 13px;
        font-size: 1.1rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.4s;
      }
      .btn-login:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 25px rgba(236, 54, 115, 0.4);
         color: #ffff;
      }
    @keyframes fadeIn {
      from {opacity:0; transform: translateY(-20px);}
      to {opacity:1; transform: translateY(0);}
    }
  </style>
</head>
<body>
  <div class="login-card">
    <div class="login-header">
      <!-- Logo thương hiệu -->
      <img src="uploads/logo.jpg" alt="Logo">
      <h4 class="mb-0">ADMIN LOGIN</h4>
    </div>
    <div class="card-body p-4">
      <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger text-center">
          <?=htmlspecialchars($_SESSION['error'])?>
        </div>
        <?php unset($_SESSION['error']); ?>
      <?php endif; ?>

      <form action="process_admin_login.php" method="POST">
        <div class="mb-3">
          <input type="text" name="username" class="form-control" placeholder="Email hoặc SĐT" required>
        </div>
        <div class="mb-3">
          <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required>
        </div>
        <button type="submit" class="btn btn-login w-100">ĐĂNG NHẬP</button>
      </form>
    </div>
  </div>
</body>
</html>
