<?php
$term = get_queried_object();
?>
<section id="service" class="service">
    <div class="container">
        <h2 class="maintit service--tit"><?php single_cat_title() ?><?php _e('Dịch Vụ Nổi Bật','SHYNH') ?></h2>
        <?php get_template_part('inc/views/services/aside.view'); ?>
        <?php get_template_part('inc/views/services/aside2.view', '', array(
            'term' => $term
        )); ?>
        <?php if (have_posts()) :  ?>
            <h1 class="maintit service--tit"><?php single_cat_title() ?></h1>
            <div class="service__list">
                <?php
                while (have_posts()) : the_post();
                    $post_id = get_the_id();
                    $title = get_the_title();
                    $thumb = get_the_post_thumbnail_url($post_id, 'large');
                ?>
                    <div class="service__list__item">
                        <a href="<?php the_permalink() ?>" class="service__list__item--thumb">
                            <figure>
                                <img src="<?php echo get_bloginfo('template_directory') . '/images/no-image.jpg'; ?>" data-src="<?php echo $thumb ?>" title="<?php echo $title ?>" alt="<?php echo $title ?>" class="lazy" />
                            </figure>
                        </a>
                        <div class="service__list__item--content">
                            <a href="<?php the_permalink() ?>">
                                <h2 class="service__list__item--tit"><?php the_title() ?></h2>
                            </a>
                            <a href="<?php the_permalink() ?>" class="button-more"><?php _e('xem thêm', SHYNH) ?></a>
                        </div>
                    </div>
                <?php endwhile;
                wp_reset_query(); ?>
            </div>
        <?php endif; ?>
    </div>
</section>