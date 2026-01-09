<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Liên Hệ</title>
  </head>
  <body>
    <!-- ==== HEADER ==== -->
    <?php include "menu.php";?>

    <!-- ======= LIÊN HỆ ======= -->

    <!-- Nội dung  -->
    <section class="contact-title">
      <h1>LIÊN HỆ VỚI CHÚNG TÔI</h1>
      <h5>
        Tamhien luôn sẵn sàng lắng nghe và hỗ trợ bạn trong mọi thắc mắc về sản
        phẩm, dịch vụ, hoặc chăm sóc da. Đội ngũ chuyên gia của chúng tôi sẽ
        cung cấp tư vấn cá nhân hóa để giúp bạn tìm ra giải pháp tốt nhất cho
        làn da của mình. Hãy liên hệ ngay hôm nay để trải nghiệm dịch vụ tận tâm
        và chuyên nghiệp từ Tamhien!
      </h5>
    </section>
    <!-- end contact-title -->
    <section class="contact">
      <div class="cnt-wraper">
        <div class="cnt-form">
          <div class="cnt-form-title">Họ và tên</div>
          <input
            type="text"
            placeholder="Nhập họ và tên"
            pattern="[A-Za-z0-9]"
            title=" chỉ sử dụng kí tự A-Z, a-z và 0-9"
            required
          />
          <!-- end part1 -->
          <div class="cnt-form-title">Email</div>
          <input type="email" placeholder="Nhập email" required />
          <!-- end part2 -->
          <div class="cnt-form-title">Số điện thoại</div>
          <input
            type="tel"
            pattern="[0-9]{10}"
            title="Chỉ nhập kí tự từ 0-9"
            required
            placeholder="Nhập số điện thoại"
          />
          <!-- end part3 -->
          <div class="cnt-form-title">Chủ đề</div>
          <select name="" id="" required>
            <option value="" disabled selected>Chọn chủ đề</option>
            <option value="">Tư vấn sản phẩm</option>
            <option value="">Khiếu nại</option>
            <option value="">Khác</option>
          </select>
          <!-- end part4 -->
          <div class="cnt-form-title">Tin nhắn</div>
          <textarea name="" id=""></textarea>
          <!-- end part5 -->
          <button type="submit">Gửi tin nhắn</button>
        </div>
        <!-- end form -->
        <div class="cnt-info">
          <h3>Thông tin liên hệ</h3>
          <ul>
            <li>
              <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
              <span>123 Đường Lê Lợi, TP. Đông Hà, Quảng Trị</span>
            </li>
            <li>
              <i class="fas fa-phone" aria-hidden="true"></i>
              <a href="tel:+84942057102">0942057102</a>
            </li>
            <li>
              <i class="fas fa-envelope" aria-hidden="true"></i>
              <a href="mailto:hienht.24it@vku.udn.vn">tamhien@nav.vn</a>
            </li>
            <li>
              <i class="fas fa-clock" aria-hidden="true"></i>
              <span>Giờ làm việc: 8:00 - 20:00 (Thứ 2 - Chủ nhật)</span>
            </li>
            <li>
              <i class="fas fa-headset" aria-hidden="true"></i>
              <a href="tel:+84942057102">Hotline hỗ trợ: 0942057102</a>
            </li>
            <li>
              <i class="fab fa-facebook" aria-hidden="true"></i>
              <a href="https://www.facebook.com/ne3ih.n" target="_blank"
                >Facebook: Tâm Hiễn</a
              >
            </li>
            <li>
              <i class="fab fa-instagram" aria-hidden="true"></i>
              <a href="https://instagram.com/tne3ih.n" target="_blank"
                >Instagram: Tâm Hiễn</a
              >
            </li>
          </ul>
          <!-- end ul li -->
          <button><a href="sanpham.php">Xem sản phẩm</a></button>
        </div>
        <!-- end cnt-info -->
      </div>
      <!-- end cnt-wraper -->
    </section>
    <!-- end contact -->

    <!-- ======= Map =======  -->
    <section class="map">
      <img
        src="https://cdn-i.vtcnews.vn/resize/ma/upload/2024/03/30/co-2-08343745.jpg"
        alt=""
      />

      <div class="cnt-map">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3834.078938319056!2d108.248804174916!3d16.04397328462533!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31421090292dcaa1%3A0xb64cb90b0b71b9b5!2zTeG7uSBBbiwgTmfFqSBIw6BuaCBTxqFuLCDEkMOgIE7huqFuZywgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1694678815481!5m2!1svi!2s"
          width="500"
          height="490"
          style="border: 0"
          allowfullscreen=""
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"
        >
        </iframe>
      </div>
    </section>
    <!-- end map -->

    <!-- ==== FOOTER ==== -->
 <?php include "footer.php";?>
    <!-- end footer -->
  </body>
</html>
