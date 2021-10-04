<footer class="footer animate__animated animate__fadeIn">
    <div class="container">
        <?php 
            if(is_active_sidebar( 'sidebar-footer' ) ):
                dynamic_sidebar('sidebar-footer');
            endif;
        ?>
    </div>
    <p class="footer__copyright">© 2021 SHYNH PREMIUM.</p>
</footer>
<?php wp_footer(); ?>
<div id="footer-popup" class="kpopup">
            <span class="kpopup__bg"></span>
            <div class="container">
                <div class="kpopup__round contact__round">
                    <span class="kpopup__buttonclose lazy" data-bg="<?php bloginfo('template_directory') ?>/images/icon-close.png"></span>
                    <div class="contact__thanks">
                        <div class="kpopup__title"><?php _e('Cám ơn bạn đăng ký,', 'shynh') ?></div>
                        <p class="kpopup__thanks"><?php _e('Shynh House sẽ liên hệ hỗ trợ bạn ngay!', 'shynh') ?></p>
                    </div>
                </div>
            </div>
        </div>
</body>
</html>