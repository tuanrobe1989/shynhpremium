<?php
global $home_id;
$sevice_posts = get_field('sevice_posts', $home_id);
?>
<aside class="service__aside owl-carousel owl-theme">
    <?php
    $i = 0;
    $actived_cate = 0;
    foreach ($sevice_posts as $post) : setup_postdata($post);
        $i++;
        $active_class = '';
        $icon = get_the_post_thumbnail_url($post,'full');
        $title = get_the_title();
        if (!$title) $title = $child->name;
    ?>
        <a href="<?php the_permalink() ?>" class="service__cate">
            <figure>
                <img src="<?php echo get_bloginfo('template_directory').'/images/no-image.jpg'; ?>" data-src-actived="<?php echo $icon ?>" data-src="<?php echo $icon ?>" title="<?php echo$title ?>" alt="<?php echo$title ?>" class="service_block__logos__item--img lazy <?php echo $active_class ?>" />
                <figcaption>
                    <strong class="h3 service__cate--tit service_block__logos__item--tit"><?php echo $title ?></strong>
                </figcaption>
            </figure>
        </a>
    <?php
    endforeach;wp_reset_postdata();
    ?>
</aside>