<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <!-- Bootstrap css -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
      crossorigin="anonymous"
    />
    <!-- link icon giỏ hàng -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
    />
    <!-- link icon mũi tên ngang -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <!-- My-styles -->
    <link rel="stylesheet" href="assets/CSS/index.css" />
  </head>
  <body>
    <!-- ==== HEADER ==== -->
    <header class="sticky-header">
      <!-- Navbar chính -->
      <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
          <!-- Logo -->
          <a class="navbar-brand" href="sanpham.php">
            <img
              src="../image/logo.jpg"
              alt="Logo Mỹ Phẩm VH"
              width="50"
              height="50"
              class="rounded-circle"
            />
            <span class="brand-text">VH Beauty</span>
          </a>

          <!-- Toggler cho mobile -->
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarContent"
            aria-controls="navbarContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>

          <!-- Collapse menu + search -->
          <div class="collapse navbar-collapse" id="navbarContent">
            <!-- Menu nav -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a
                  class="nav-link active"
                  aria-current="page"
                  href="trangchu.php"
                  >Trang Chủ</a
                >
              </li>
              <li class="nav-item">
                <a class="nav-link" href="gioithieu.php">Giới Thiệu</a>
              </li>
              <li class="nav-item custom-dropdown">
                <a
                  class="nav-link dropdown-toggle"
                  href="sanpham.php"
                  role="button"
                  >Sản Phẩm</a
                >
                <ul class="dropdown-menu">
                  <li>
                    <a class="dropdown-item" href="sanpham.php?category=1"
                      >Sữa rửa mặt</a
                    >
                  </li>
                  <li>
                    <a class="dropdown-item" href="sanpham.php?category=2"
                      >Kem chống nắng</a
                    >
                  </li>
                  <li>
                    <a class="dropdown-item" href="sanpham.php?category=3"
                      >Nước tẩy trang</a
                    >
                  </li>
                  <li><hr class="dropdown-divider" /></li>
                  <li>
                    <a class="dropdown-item" href="sanpham.php?category=4"
                      >Son môi</a
                    >
                  </li>
                </ul>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="lienhe.php">Liên Hệ</a>
              </li>
            </ul>

            <!-- Search bar -->
            <form
              class="d-flex me-3"
              role="search"
              method="get"
              action="sanpham.php"
            >
              <input
                class="form-control me-2"
                type="search"
                name="q"
                placeholder="Tìm kiếm sản phẩm..."
                aria-label="Search"
                required
              />
              <button class="btn btn-outline-light" type="submit">
                <i class="bi bi-search"></i>
              </button>
            </form>
          </div>
        </div>
      </nav>

      <!-- Sub-header: Slogan + User actions -->
      <div class="sub-header">
        <div class="container-fluid">
          <div class="row align-items-center">
            <div class="col-md-6">
              <h6 class="slogan mb-0">
                VH – Elevating Natural Beauty. Giao hàng miễn phí từ 500k!
              </h6>
            </div>
            <div class="col-md-6 text-end">
              <ul class="user-actions list-unstyled mb-0">
                <li class="d-inline-block me-3 custom-dropdown">
                  <a class="user-link dropdown-toggle" href="#" role="button">
                    <?php if(isset($_SESSION['user_id'])): ?>
                    <?php echo htmlspecialchars($_SESSION['fullname']); ?>
                    <?php else: ?>
                    Tài Khoản
                    <?php endif; ?>
                  </a>
                  <ul class="dropdown-menu">
                    <?php if(isset($_SESSION['user_id'])): ?>
                      <li>
                      <a class="dropdown-item" href="orders.php"
                        >Đơn Hàng Của Tôi</a
                      > 
                      <li>
                      <a class="dropdown-item" href="auth/logout.php"
                        >Đăng Xuất</a
                      >
                    </li>
                    </li>
                    <?php else: ?>
                    <li>
                      <a class="dropdown-item" href="auth/log.php">Đăng Nhập</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="auth/process_register.php"
                        >Đăng Ký</a
                      >
                    </li>
                    <?php endif; ?>
                    <li><hr class="dropdown-divider" /></li>
                  
                  </ul>
                </li>
                <li class="d-inline-block">
                  <a
                    href="cart.php"
                    class="cart-link position-relative text-decoration-none"
                  >
                    <i class="bi bi-bag-heart fs-4"></i>

                    <?php
    // Tính số lượng sản phẩm trong giỏ (đếm số key = số mặt hàng khác nhau)
    $cart_count = 0;

    // Dù đã đăng nhập hay chưa, giỏ hàng đều dùng session nên luôn lấy được
    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        $cart_count = count($_SESSION['cart']);   // Đếm số sản phẩm khác nhau
    }

    // Luôn hiển thị badge (kể cả số 0) để khách thấy rõ
    ?>
                    <span
                      class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle"
                      style="font-size: 0.75rem"
                    >
                      <?= $cart_count ?>
                      <span class="visually-hidden"
                        >sản phẩm trong giỏ hàng</span
                      >
                    </span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </header>
  </body>
</html>
