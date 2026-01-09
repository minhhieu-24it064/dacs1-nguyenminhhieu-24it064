<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Trang Chủ</title>
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
    <?php include "menu.php";?>

    <!-- ==== HERO ==== -->
    <section class="hero">
      <video autoplay muted loop playsinline>
        <source src="../image/video.mp4" type="video/mp4" />
      </video>
      <div class="hero-content">
        <h2>Khám phá vẻ đẹp, lan tỏa sự tự tin.</h2>
        <h2>Cam kết chất lượng uy tín, an toàn cho làn da bạn.</h2>
        <button type="submit"><a href="sanpham.php">Mua ngay</a></button>
      </div>
    </section>

    <!-- ==== CAM KẾT ==== -->

    <section class="commit">
      <div class="box-commit hai-commit">
        <img src="../../image/thanhtoan.jpg" alt="" />
        <h3>Thanh toán</h3>
        <p>Khách hàng có thể lựa chọn 1 hoặc nhiều phương thức thanh toán</p>
      </div>
      <div class="box-commit mot-commit">
        <img src="../../image/chinhhang.jpg" alt="" />
        <h3>Cam kết chính hãng</h3>
        <p>
          Chúng tôi cam kết hàng chính hãng và đảm bảo về chất lượng hàng sản
          phẩm
        </p>
      </div>
      <div class="box-commit hai-commit">
        <img src="../../image/shipper.webp" alt="" />
        <h3>Siêu tốc 2h</h3>
        <p>Dịch vụ giao hàng nhanh 2h trong nội thành Quảng Trị</p>
      </div>
    </section>

    <!-- ==== SẢN PHẨM NỔI BẬT ==== -->
    <section class="all-title">
      <h2>SẢN PHẨM NỔI BẬT</h2>
    </section>

    <!-- ==== SẢN PHẨM ====  -->
    <section class="product">
      <div class="container-product">
        <img src="../../image/img1.webp" alt="" />
        <h5>
          Nước tẩy trang <br />
          L'oreal
        </h5>
        <p>179.000₫</p>
      </div>
      <div class="container-product">
        <img src="../../image/img2.jpeg" alt="" />
        <h5>
          Tẩy tế bào chết <br />
          Cocoon
        </h5>
        <p>89.000đ</p>
      </div>
      <div class="container-product">
        <img src="../../image/img3.jpg" alt="" />
        <h5>
          Nước tẩy trang <br />
          Hada labo
        </h5>
        <p>127.000đ</p>
      </div>
      <div class="container-product">
        <img src="../../image/img4.webp" alt="" />
        <h5>
          Sữa rửa mặt <br />
          Cerave
        </h5>
        <p>179.000đ</p>
      </div>
      <div class="container-product">
        <img src="../../image/img5.jpg" alt="" />
        <h5>Kem chống nắng Anessa</h5>
        <p>399.000đ</p>
      </div>
      <div class="container-product">
        <img src="../../image/img6.webp" alt="" />
        <h5>Kem chống nắng D'alba</h5>
        <p>179.000đ</p>
      </div>
      <div class="container-product">
        <img src="../../image/img7.jpg" alt="" />
        <h5>
          Son kem lì <br />
          Romand
        </h5>
        <p>179.000đ</p>
      </div>
      <div class="container-product">
        <img src="../../image/img7.jpg" alt="" />
        <h5>
          Son kem lì <br />
          Romand
        </h5>
        <p>179.000đ</p>
      </div>
      <div class="container-product">
        <img src="../../image/img7.jpg" alt="" />
        <h5>
          Son kem lì <br />
          Romand
        </h5>
        <p>179.000đ</p>
      </div>
      <div class="container-product">
        <img src="../../image/img7.jpg" alt="" />
        <h5>
          Son kem lì <br />
          Romand
        </h5>
        <p>179.000đ</p>
      </div>
    </section>

    <!-- ==== ƯU ĐÃI ==== -->
    <section class="deal">
      <div class="deal-title">Ưu đãi</div>
      <div class="line"></div>
    </section>

    <!-- ==== SẢN PHẨM ƯU ĐÃI ==== -->
    <section class="dealhot">
      <div class="container-dealhot">
        <img src="../../image/img8.webp" alt="" />
        <div class="dealhot-content">
          <h4>Son Colorkey</h4>
          <p>R300</p>
          <div class="price">
            <span class="pr">268.000₫</span>
            <s>349.000₫</s>
          </div>
          <!-- end price -->
          <div class="countdown">
            <div class="time-block">
              <span class="hours">0</span>
              <p>giờ</p>
            </div>
            <div class="time-block">
              <span class="minutes">0</span>
              <p>phút</p>
            </div>
            <div class="time-block">
              <span class="seconds">0</span>
              <p>giây</p>
            </div>
          </div>
          <!-- end countdown -->
        </div>
      </div>
      <div class="container-dealhot">
        <img src="../../image/img9.jpg" alt="" />
        <div class="dealhot-content">
          <h4>Sữa rửa mặt Ngọc Sâm</h4>
          <p>R300</p>
          <div class="price">
            <span class="pr">249.000đ</span>
            <s>300.000đ</s>
          </div>
          <!-- end price -->
          <div class="countdown">
            <div class="time-block">
              <span class="hours">0</span>
              <p>giờ</p>
            </div>
            <div class="time-block">
              <span class="minutes">0</span>
              <p>phút</p>
            </div>
            <div class="time-block">
              <span class="seconds">0</span>
              <p>giây</p>
            </div>
          </div>
          <!-- end countdown -->
        </div>
        <!-- end dealhot-content -->
      </div>
    </section>

    <!-- ==== IMAGE ==== -->
    <section class="image">
      <div class="wraper-image">
        <div class="container-image">
          <img src="../../image/img10.jpg" alt="" />
        </div>
        <!-- end container-image -->
        <div class="container-image">
          <img src="../../image/img12.webp" alt="" />
          <div class="image-content">
            <h3>
              <span style="color: rgb(223, 224, 224)">Natural</span> <br />
              <span style="font-weight: bold">Facial Oils</span>
            </h3>
            <h5>A Skincare Essential for a Balanced</h5>
            <div class="image-btn">
              <p><a href="sanpham.php">Mua ngay</a></p>
              <i class="fas fa-circle-right"></i>
            </div>
          </div>
        </div>
        <!-- end container-image -->
        <div class="container-image">
          <img src="../../image/img11.jpg" alt="" />
        </div>
        <!-- end container-image -->
      </div>
    </section>

    <!-- ==== BRAND ==== -->
    <section class="brand">
      <div class="brand-wrapper">
        <div class="brand-container">
          <img
            src="https://inchi.vn/data/cms_upload/files/blog/logo-my-pham/109.jpg"
            alt=""
          />
        </div>
        <!-- end brand-container -->
        <div class="brand-container">
          <img
            src="https://images.seeklogo.com/logo-png/35/1/cerave-logo-png_seeklogo-352149.png"
            alt=""
          />
        </div>
        <!-- end brand-container -->
        <div class="brand-container">
          <img src="../image/img13.webp" alt="" />
        </div>
        <!-- end brand-container -->
        <div class="brand-container">
          <img
            src="https://lh6.googleusercontent.com/proxy/S2QpQothAUbEFHuhPGHnKrsGDbF5i9J5cqGQ_2UeRyZohpYKWIl0ZWngMI5pp4Haxb-M-hTr9nfCkV6S6VMDi11PV_RUJ59JL-gqz9mvuvcHOKCSe29ta7y6nQ"
            alt=""
          />
        </div>
        <!-- end brand-container -->
        <div class="brand-container">
          <img
            src="https://images.soco.id/1facc650-edd6-4ec9-bf67-3d942dd6069f-10320516743-1609231824191.png"
            alt=""
          />
        </div>
        <!-- end brand-container -->
        <div class="brand-container">
          <img
            src="https://cdn.shopify.com/s/files/1/0817/1461/0473/files/Colorkey.png?v=1721201396"
            alt=""
          />
        </div>
        <!-- end brand-container -->
      </div>
      <!-- end brand-wraper -->
    </section>
    <!-- end brand-->

    <!-- ==== BLOG LÀM ĐẸP ==== -->
    <section class="blog-section">
      <div class="container-blog">
        <!-- Blog 1: Kem chống nắng -->
        <a
          href="https://hasaki.vn/cam-nang/top-kem-chong-nang-tot-nhat-2022-khong-nen-bo-lo-1823.html"
          class="blog-card"
          target="_blank"
        >
          <div class="blog-img">
            <img
              src="https://www.graceskinclinic.com/wp-content/uploads/2018/04/chon-kem-chong-nang.jpg"
              alt="Top kem chống nắng tốt nhất"
            />
          </div>
          <div class="blog-content">
            <span class="blog-date">Cập nhật 2025</span>
            <h4>
              Top kem chống nắng tốt nhất 2025 – Đừng bỏ lỡ để bảo vệ làn da!
            </h4>
            <p>
              Review chi tiết các dòng kem chống nắng hot hit: Anessa, La
              Roche-Posay, Biore... phù hợp mọi loại da, chống tia UV hiệu quả.
            </p>
            <span class="read-more">Đọc thêm →</span>
          </div>
        </a>

        <!-- Blog 2: Routine skincare tối giản -->
        <a
          href="https://fancyderma.com/skincare-101-5-buoc-cham-soc-da-co-ban-cho-nguoi-moi/"
          class="blog-card"
          target="_blank"
        >
          <div class="blog-img">
            <img
              src="https://i.ytimg.com/vi/G5cVIGBchwo/maxresdefault.jpg"
              alt="Skincare routine tối giản"
            />
          </div>
          <div class="blog-content">
            <span class="blog-date">Cập nhật 2025</span>
            <h4>
              5 bước skincare cơ bản tối giản cho người mới bắt đầu – Da đẹp mà
              không phức tạp!
            </h4>
            <p>
              Chỉ với tẩy trang - rửa mặt - toner - dưỡng ẩm - chống nắng, làn
              da vẫn khỏe mạnh, căng bóng cho người bận rộn.
            </p>
            <span class="read-more">Đọc thêm →</span>
          </div>
        </a>

        <!-- Blog 3: Chọn son theo tông da -->
        <a
          href="https://hasaki.vn/cam-nang/cach-chon-mau-son-phu-hop-voi-tone-da-cuc-don-gian-3368.html"
          class="blog-card"
          target="_blank"
        >
          <div class="blog-img">
            <img
              src="https://burst.shopifycdn.com/photos/testing-lipstick-shades-on-arm.jpg"
              alt="Chọn son theo undertone"
            />
          </div>
          <div class="blog-content">
            <span class="blog-date">Cập nhật mới</span>
            <h4>
              Cách chọn màu son phù hợp với tone da – Tone nóng, lạnh hay trung
              tính?
            </h4>
            <p>
              Hướng dẫn chi tiết chọn son cam, đỏ, nude... theo undertone để lên
              màu chuẩn đẹp, không bị xỉn da.
            </p>
            <span class="read-more">Đọc thêm →</span>
          </div>
        </a>
      </div>
    </section>

    <?php include "footer.php";?>

    <!-- Bootstrap js -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
      crossorigin="anonymous"
    ></script>
    <!-- my-style -->
    <script src="assets/js/main.js"></script>
  </body>
</html>
