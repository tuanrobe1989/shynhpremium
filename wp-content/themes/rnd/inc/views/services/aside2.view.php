<?php
global $home_id;
$sevice_posts = get_field('sevice_posts', $home_id);
?>
<aside class="serviceCategory owl-carousel owl-theme">
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
        <a href="<?php the_permalink() ?>" class="serviceCategory__item">
            <figure>
                <img src="<?php echo get_bloginfo('template_directory').'/images/no-image.jpg'; ?>" data-src="<?php echo $icon ?>" title="<?php echo$title ?>" alt="<?php echo$title ?>" class="serviceCategory__item--img lazy <?php echo $active_class ?>" />
                <figcaption>
                    <strong class="h4 serviceCategory__item--tit"><?php echo $title ?></strong>
                </figcaption>
            </figure>
        </a>
    <?php
    endforeach;wp_reset_postdata();
    ?>
</aside>
<script>
    var actived_cate = <?php echo $actived_cate ?>;
</script>