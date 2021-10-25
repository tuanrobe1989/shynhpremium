<?php global $global_services; ?>
<div class="footer__promo">
    <div class="footer__promo__around">
        <p class="footer__promo--tit"><strong><?php _e('đăng ký nhận khuyến mãi', SHYNH) ?></strong></p>
        <form action="" method="post" class="contactForm">
            <div class="form__input">
                <input type="text" name="form_email" id="contactForm__name" class="contactForm__name" placeholder="<?php _e('Vui lòng họ tên', SHYNH) ?>" />
                <label for="contactForm__name">
                    <i class="fa-solid fa-user fa-fw"></i>
                </label>
            </div>
            <div class="form__input">
                <input type="text" name="form_phone" id="contactForm__phone" class="contactForm__phone" placeholder="<?php _e('Vui lòng nhập số điện thoại', SHYNH) ?>" />
                <label for="contactForm__phone">
                    <i class="fa-solid fa-phone fa-fw"></i>
                </label>
            </div>
            <?php
            if (API_FLAG === TRUE) :
            ?>
                <div class="form__input">
                    <select id="contactForm__service" name="contactForm__service" class="contactForm__service" placeholder="Chọn dịch vụ">
                        <option value=""><?php _e('Chọn dịch vụ'); ?></option>
                        <?php
                        if ($global_services) :
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
                        endif;
                        ?>
                    </select>
                    <label for="contactForm__phone">
                    <i class="fa-solid fa-circle-check fa-fw"></i>
                </label>
                </div>
            <?php
            endif;
            ?>
            <input type="submit" name="contactForm__submit" id="contactForm__submit" class="button contactForm__submit" value="<?php _e('Đăng ký','shynh') ?>"/>
        </form>
    </div>
</div>