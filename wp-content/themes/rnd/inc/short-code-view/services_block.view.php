<?php extract($args) ?>
<section id="service_<?php echo $postdata->ID ?>" class="service_block">
    <div class="service_block__flex">
        <?php 
            if($service_block_01):
        ?>
        <div class="service_block__logos fix_height">
            <?php 
                foreach($service_block_01 as $category): 
                    $icon = get_field('icon',$category);
                    $icon_actived = get_field('icon_actived',$category);
                    $title = get_field('cover_title',$category);
                    if(!$title) $title = $category->name;
            ?>
            <a href="<?php echo get_category_link($category) ?>" class="service_block__logos__item">
                <figure>
                    <img 
                        src="<?php echo imageEncode('/images/no-image.png'); ?>" 
                        data-src-actived="<?php echo $icon_actived ?>" 
                        data-src="<?php echo $icon; ?>" 
                        title="<?php echo $category->name ?>" 
                        alt="<?php echo $category->name ?>" 
                        class="service_block__logos__item--img lazy" />
                    <figcaption>
                        <h3 class="service_block__logos__item--tit"><?php echo $title ?></h3>
                    </figcaption>
                </figure>
            </a>
            <?php 
                endforeach;
            ?>
        </div>
        <?php 
            endif;
        ?>
        <?php 
            if($service_block_image):
        ?>
            <div class="service_block__girl fix_height">
                <img 
                    src="<?php echo imageEncode('/images/no-image.png'); ?>" 
                    data-src="<?php echo $service_block_image['url']; ?>" 
                    title="<?php echo $service_block_image['title'] ?>" 
                    alt="<?php echo $service_block_image['alt'] ?>" 
                    class="service_block__girl--img lazy" />
            </div>
        <?php 
            endif;
        ?>
        <?php 
            if($service_block_2):
        ?>
        <div class="service_block__logos fix_height">
            <?php 
                foreach($service_block_2 as $category): 
                    $icon = get_field('icon',$category);
                    $icon_actived = get_field('icon_actived',$category);
                    $title = get_field('cover_title',$category);
                    if(!$title) $title = $category->name;
            ?>
            <a href="<?php echo get_category_link($category) ?>" class="service_block__logos__item">
                <figure>
                    <img 
                        src="<?php echo imageEncode('/images/no-image.png'); ?>" 
                        data-src-actived="<?php echo $icon_actived ?>" 
                        data-src="<?php echo $icon; ?>" 
                        title="<?php echo $category->name ?>" 
                        alt="<?php echo $category->name ?>" 
                        class="service_block__logos__item--img lazy" />
                    <figcaption>
                        <h3 class="service_block__logos__item--tit"><?php echo $title ?></h3>
                    </figcaption>
                </figure>
            </a>
            <?php 
                endforeach;
            ?>
        </div>
        <?php 
            endif;
        ?>
    </div>
</section>