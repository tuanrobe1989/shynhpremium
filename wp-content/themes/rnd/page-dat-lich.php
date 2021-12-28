<?php get_header() ?>
<section class="appointment">
  <h1 class="appointment__title maintit"><?php the_title(); ?></h1>
  <div class="container appointment__container">
    <form action="" id="contact_calendar" method="post" class="contactForm appointment__register">
      <div class="appointment__register__wrapper">
        <div class="form__input appointment__register__input-wrapper">
          <input type="text" class="contactForm__name contactForm__input appointment__register__input" placeholder="<?php _e('Họ Tên', SHYNH) ?>">
        </div>
        <div class="form__input appointment__register__input-wrapper">
          <input type="text" class="contactForm__phone contactForm__input appointment__register__input" placeholder="<?php _e('Điện Thoại', SHYNH) ?>">
        </div>
        <?php
        if (API_FLAG === TRUE) :
          global $global_services;
          if ($global_services) :
        ?>
            <div class="form__input appointment__register__area-wrapper">
              <select id="contactForm__service" name="contactForm__service" class="appointment__register__input contactForm__service contactForm__input" placeholder="Chọn dịch vụ">
                <option value=""><?php _e('Chọn dịch vụ'); ?></option>
                <?php
                foreach ($global_services as $item) :
                  if ($item['label'] != '') :
                ?>
                    <option value="<?php echo $item['value'] ?>"><?php echo $item['label'] ?></option>
                  <?php
                  else :
                  ?>
                    <option value="<?php echo $item['service_id'] ?>"><?php echo $item['service_name'] ?></option>
                <?Php
                  endif;
                endforeach;
                ?>
              </select>
            </div>
        <?php
          endif;
        endif;
        ?>
        <div class="form__input appointment__register__area-wrapper">
          <textarea name="contactForm__description" id="contactForm__description" cols="30" rows="5" class="contactForm__input appointment__register__input area-input" placeholder="<?php _e('Nội Dung Đặt Lịch', SHYNH) ?>"></textarea>
        </div>
      </div>
      <div class="appointment__register__submit-wrapper">
        <input type="submit" value="<?php _e('Đặt Lịch', SHYNH) ?>" class="contactForm__submit appointment__register__submit">
      </div>
      <p class="appointment__register__time-window">Tất cả các ngày trong tuần: 9:00 sáng tới 20:00 tối</p>
      <input type="hidden" name="nonce" class="nonce" value="<?php echo wp_create_nonce('add_contact_nonce') ?>" />
      <input type="hidden" name="contactForm__category" class="contactForm__category" value="28" />
      <input type="hidden" name="contactForm__title" class="contactForm__title" value="" />
      <input type="hidden" name="contactForm__tag" class="contactForm__tag" value="calendar__form"/>
      <input type="hidden" name="popup__id" class="popup__id" value="common-popup" />
    </form>
    <div class="appointment__image-wrapper">
      <img src="<?php echo imageEncode('/images/appointment1.webp'); ?>" alt="" title="" class="appointment__image1">
      <img src="<?php echo imageEncode('/images/appointment2.webp'); ?>" alt="" title="" class="appointment__image2">
    </div>
  </div>
</section>
<?php get_footer() ?>