<?php
global $home_id;
$sevice_posts = get_field('sevice_posts', $home_id);
$categories = get_categories(array(
    'parent'  => 7
));
if ($categories) :
?>
    <h3 class="maintit service--tit"><?php _e('Danh Mục Dịch Vụ', SHYNH) ?></h3>
    <aside class="serviceCategory owl-carousel owl-theme">
        <?php
        $i = 0;
        $actived_cate = 0;
        foreach ($categories as $cate):
            $active_class = '';
            $thumb = get_field('thumb',$cate);
            $title = $cate->name;
            if (!$title) $title = $child->name;
        ?>
            <a href="<?php echo get_term_link($cate->term_id) ?>" class="serviceCategory__item">
                <figure>
                    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="<?php echo $thumb; ?>" width="1200" height="627"  title="<?php echo $title ?>" alt="<?php echo $title ?>" class="serviceCategory__item--img lazy <?php echo $active_class ?>" />
                    <figcaption>
                        <strong class="h4 serviceCategory__item--tit"><?php echo $title ?></strong>
                    </figcaption>
                </figure>
            </a>
        <?php
        endforeach;
        wp_reset_postdata();
        ?>
    </aside>
    <script>
        var actived_cate = <?php echo $actived_cate ?>;
    </script>
<?php
endif;
