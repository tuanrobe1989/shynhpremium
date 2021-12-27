<?php global $global_services; ?>
<div class="footer__promo">
    <div class="footer__promo__around">
        <p class="footer__promo--tit"><strong><?php _e('đăng ký nhận khuyến mãi', SHYNH) ?></strong></p>
        <form action="" method="post" class="contactForm" id="contact_footer" name="footer__form">
            <div class="form__input">
                <input type="text" name="form_email" id="contactForm__name" class="contactForm__name contactForm__input" placeholder="<?php _e('Vui lòng họ tên', SHYNH) ?>" />
                <label for="contactForm__name">
                    <i class="fa-solid fa-user fa-fw"></i>
                </label>
            </div>
            <div class="form__input">
                <input type="text" name="form_phone" id="contactForm__phone" class="contactForm__phone contactForm__input" placeholder="<?php _e('Vui lòng nhập số điện thoại', SHYNH) ?>" />
                <label for="contactForm__phone">
                    <i class="fa-solid fa-phone fa-fw"></i>
                </label>
            </div>
            <input type="submit" name="contactForm__submit" id="contactForm__submit" class="button contactForm__submit" value="<?php _e('Đăng ký','shynh') ?>"/>
            <input type="hidden" name="nonce" class="nonce" value="<?php echo wp_create_nonce('add_contact_nonce') ?>" />
            <input type="hidden" name="contactForm__category" class="contactForm__category" value="25" />
            <input type="hidden" name="contactForm__service" class="contactForm__service" value="17" />
            <input type="hidden" name="contactForm__title" class="contactForm__title" value="Dịch Vụ Soi Da 0 Đồng" />
            <input type="hidden" name="contactForm__tag" class="contactForm__tag" value="footer__form"/>
            <input type="hidden" name="popup__id" class="popup__id" value="common-popup"/>
        </form>
    </div>
</div>