<?php extract($args) ?>
<section id="service_<?php echo $postdata->ID ?>" class="service_block">
    <div class="service_block__flex">
        <?php
        if ($service_block_01) :
        ?>
            <div class="service_block__logos fix_height">
                <?php
                foreach ($service_block_01 as $post) : setup_postdata($post);
                    $icon = get_the_post_thumbnail_url($post, 'full');
                    $title = get_the_title();
                ?>
                    <a href="<?php the_permalink() ?>" class="service_block__logos__item">
                        <figure>
                            <img src="<?php echo imageEncode('/images/no-image.jpg'); ?>" data-src-actived="<?php echo $icon ?>" data-src="<?php echo $icon; ?>" title="<?php echo $title ?>" alt="<?php echo $title ?>" class="service_block__logos__item--img lazy" />
                            <figcaption>
                                <h3 class="service_block__logos__item--tit"><?php echo $title ?></h3>
                            </figcaption>
                        </figure>
                    </a>
                <?php
                endforeach;
                wp_reset_postdata();
                ?>
            </div>
        <?php
        endif;
        ?>
        <?php
        if ($service_block_image) :
        ?>
            <div class="service_block__girl fix_height">
                <img src="<?php echo imageEncode('/images/no-image.jpg'); ?>" data-src="<?php echo $service_block_image['url']; ?>" title="<?php echo $service_block_image['title'] ?>" alt="<?php echo $service_block_image['alt'] ?>" class="service_block__girl--img lazy" />
            </div>
        <?php
        endif;
        ?>
        <?php
        if ($service_block_02) :
        ?>
            <div class="service_block__logos fix_height">
                <?php
                foreach ($service_block_02 as $post) : setup_postdata($post);
                    $icon = get_the_post_thumbnail_url($post, 'full');
                    $title = get_the_title();
                ?>
                    <a href="<?php the_permalink() ?>" class="service_block__logos__item">
                        <figure>
                            <img src="<?php echo imageEncode('/images/no-image.jpg'); ?>" data-src-actived="<?php echo $icon ?>" data-src="<?php echo $icon; ?>" title="<?php echo $title ?>" alt="<?php echo $title ?>" class="service_block__logos__item--img lazy" />
                            <figcaption>
                                <h3 class="service_block__logos__item--tit"><?php echo $title ?></h3>
                            </figcaption>
                        </figure>
                    </a>
                <?php
                endforeach;
                wp_reset_postdata();
                ?>
            </div>
        <?php
        endif;
        ?>
    </div>
</section>