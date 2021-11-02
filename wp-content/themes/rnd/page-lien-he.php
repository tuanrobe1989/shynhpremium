<?php get_header() ?>

<section class="contact">
  <div class="container contact__container">
    <h1 class="maintit"><?php the_title(); ?></h1>
    <iframe class="contact__map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d62706.52488045035!2d106.63068421596762!3d10.799223153563014!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752fef0abe3d7d%3A0x5a8dfb5891860c1d!2zU2h5bmggUHJlbWl1bSBUcuG6p24gUXXhu5FjIFRo4bqjbw!5e0!3m2!1svi!2s!4v1622381090435!5m2!1svi!2s" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    <div class="contact__info">
      <div class="contact__info__detail">
        <div class="contact__info__detail-block">
          <h2 class="h3">Hệ thống <br>Shynh Premium:</h2>
        </div>
        <div class="contact__info__detail-block">
          <h3 class="contact__info__detail-title">Shynh Premium Trần Quốc Thảo</h3>
          <p class="contact__info__detail-info map-icon">33 Trần Quốc Thảo, P. 6, Q. 3, TP. HCM</p>
          <p class="contact__info__detail-info cellphone-icon">089 649 1919</p>
        </div>
        <div class="contact__info__detail-block">
          <h3 class="contact__info__detail-title">Shynh Premium Nguyễn Trãi</h3>
          <p class="contact__info__detail-info map-icon">49 Nguyễn Trãi, P. Bến Thành, Q. 1, TP. HCM</p>
          <p class="contact__info__detail-info cellphone-icon">089 945 1919</p>
        </div>
        <div class="contact__info__detail-block">
          <h3 class="contact__info__detail-title">Shynh Premium 3 Tháng 2</h3>
          <p class="contact__info__detail-info map-icon">326 - Đường 3 Tháng 2, P. 12, Q. 10, TP. HCM</p>
          <p class="contact__info__detail-info cellphone-icon">089 946 1919</p>
        </div>
        <div class="contact__info__detail-block">
          <h3 class="contact__info__detail-title">Shynh Premium Đà Nẵng</h3>
          <p class="contact__info__detail-info map-icon">27-29 Lê Đình Lý, Q. Thanh Khê, TP. Đà Nẵng</p>
          <p class="contact__info__detail-info cellphone-icon">093 819 2729</p>
        </div>
        <div class="contact__info__detail-block">
          <h3 class="contact__info__detail-title">Shynh Premium Hà Nội</h3>
          <p class="contact__info__detail-info map-icon">99 Triệu Việt Vương, Q. Hai Bà Trưng, Hà Nội</p>
          <p class="contact__info__detail-info cellphone-icon">089 947 1919</p>
        </div>
        <div class="contact__info__detail-block">
          <h3 class="contact__info__detail-title">Hotline</h3>
          <p class="contact__info__detail-info cellphone-icon">1900989800</p>
        </div>
      </div>
      <form action="" id="contact__popup" name="contact__popup" data-action="common-popup" class="contactForm contact__info__register" method="POST">
        <div class="contact__info__register__area-wrapper">
          <h2 class="h3">Nhận Thông Tin Khuyến Mãi & <br>Góp Ý Dịch Vụ</h2>
        </div>
        <div class="form__input contact__info__register__area-wrapper">
          <input type="text" name="contactForm__name" id="contactForm__name" class="contact__info__register__input contactForm__input contactForm__name" placeholder="<?php _e('Họ và Tên', SHYNH) ?>">
        </div>
        <div class="form__input contact__info__register__area-wrapper">
          <input type="text" name="contactForm__phone" id="contactForm__phone" class="contact__info__register__input contactForm__input contactForm__phone" placeholder="<?php _e('Số điện thoại', SHYNH) ?>">
        </div>
        <div class="form__input contact__info__register__area-wrapper">
          <input type="text" name="contactForm__email" id="contactForm__email" class="contact__info__register__input contactForm__input  contactForm__email" placeholder="<?php _e('E-mail', SHYNH) ?>">
        </div>
        <div class="form__input contact__info__register__area-wrapper">
          <textarea name="message" id="txtarea" cols="30" rows="5" class="contact__info__register__input contactForm__input area-input" placeholder="<?php _e('Nội dung', SHYNH) ?>"></textarea>
        </div>
        <div class="form__input contact__info__register__area-wrapper">
          <input type="submit" value="<?php _e('ĐĂNG KÝ', SHYNH) ?>" name="contactForm__submit" class="contact__info__register__submit contactForm__submit">
        </div>
        <input type="hidden" name="nonce" class="nonce" value="<?php echo wp_create_nonce('add_contact_nonce') ?>" />
        <input type="hidden" name="contactForm__category" class="contactForm__category" value="27" />
        <input type="hidden" name="popup__id" class="popup__id" value="contact__popup" />
      </form>
    </div>
  </div>
</section>

<?php get_footer() ?>