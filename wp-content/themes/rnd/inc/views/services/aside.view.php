<?php
$childrens = get_terms($args['term']->taxonomy, array(
    'parent'    => 7,
    'hide_empty' => false
));
?>
<aside class="service__aside owl-carousel owl-theme">
    <?php
    $i = 0;
    $actived_cate = 0;
    foreach ($childrens as $child) : $i++;
        $active_class = '';
        if ($term->term_id == $child->term_id) :
            $icon_actived = get_field('icon', $child);
            $icon = get_field('icon_actived', $child);
            $active_class = 'actived';
            $actived_cate = $i;
        else :
            $icon = get_field('icon', $child);
            $icon_actived = get_field('icon_actived', $child);
        endif;
        $title = get_field('cover_title', $child);
        if (!$title) $title = $child->name;
    ?>
        <a href="<?php echo get_category_link($child) ?>" class="service__cate">
            <figure>
                <img src="<?php echo imageEncode('/images/no-image.png'); ?>" data-src-actived="<?php echo $icon_actived ?>" data-src="<?php echo $icon ?>" title="<?php echo $child->name ?>" alt="<?php echo $child->name ?>" class="service_block__logos__item--img lazy <?php echo $active_class ?>" />
                <figcaption>
                    <h3 class="service__cate--tit service_block__logos__item--tit"><?php echo $title ?></h3>
                </figcaption>
            </figure>
        </a>
    <?php
    endforeach;
    ?>
</aside>
<script>
    var actived_cate = <?php echo $actived_cate ?>;
</script>