<div class="footer__promo">
    <div class="footer__promo__around">
        <p class="footer__promo--tit"><strong><?php _e('đăng ký nhận khuyến mãi', SHYNH) ?></strong></p>
        <form action="" method="post">
            <div class="form__input">
                <input type="text" name="form_email" id="footer__promo--email" placeholder="<?php _e('Vui lòng nhập email', SHYNH) ?>" />
                <label for="footer__promo--email">
                    <img src="<?php bloginfo('template_directory') ?>/images/icon-mail.png" alt="email" widht="40" height="40" />
                </label>
            </div>
            <div class="form__input">
                <input type="text" name="form_phone" id="footer__promo--phone" placeholder="<?php _e('Vui lòng nhập số điện thoại', SHYNH) ?>" />
                <label for="footer__promo--email">
                    <img src="<?php bloginfo('template_directory') ?>/images/icon-phone.png" alt="email" widht="40" height="40" />
                </label>
            </div>
            <?php
            if (API_FLAG === TRUE) :
            ?>
                <select id="footer_contact_service" name="footer_contact_service" class="footer__contact__input" placeholder="Chọn dịch vụ">
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
            <?php
            endif;
            ?>
        </form>
    </div>
</div>