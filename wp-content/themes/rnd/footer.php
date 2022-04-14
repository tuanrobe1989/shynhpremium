<footer class="footer animate__animated animate__fadeIn">
    <div class="container">
        <?php
        if (is_active_sidebar('sidebar-footer')) :
            dynamic_sidebar('sidebar-footer');
        endif;
        ?>
    </div>
    <div class="footer__addressWrap">
        <div class="container">
            <ul class="footer__address">
                <li class="footer__address__item">
                    <p><strong class="footer__address__item--tit">Shynh Premium Nguyễn Trãi</strong></p>
                    <p>49 Nguyễn Trãi, Phường Bến Thành, Quận 1</p>
                </li>
                <li class="footer__address__item">
                    <p><strong class="footer__address__item--tit">Shynh Premium 3 Tháng 2</strong></p>
                    <p>326 Đường 3 Tháng 2, Phường 12, Quận 10</p>
                </li>
                <li class="footer__address__item">
                    <p><strong class="footer__address__item--tit">Shynh Premium Trần Quốc Thảo</strong></p>
                    <p>33 Trần Quốc Thảo, Phường 6, Quận 3</p>
                </li>
                <li class="footer__address__item">
                    <p><strong class="footer__address__item--tit">Shynh Premium Đà Nẵng</strong></p>
                    <p>27-29 Lê Đình Lý, Q. Thanh Khê, TP. Đà Nẵng</p>
                </li>
                <li class="footer__address__item">
                    <p><strong class="footer__address__item--tit">Shynh Premium Hà Nội</strong></p>
                    <p>99 Triệu Việt Vương, Quận Hai Bà Trưng, Hà Nội</p>
                </li>
            </ul>
        </div>
    </div>
    <p class="footer__copyright">© 2021 SHYNH PREMIUM.</p>
</footer>
<?php wp_footer(); ?>
</body>

</html>