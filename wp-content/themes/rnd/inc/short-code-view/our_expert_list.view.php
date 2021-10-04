<?php
extract($args);
if( have_rows('our_experts',$postdata->ID) ):
?>

<section class="our-experts">
    <div  class="our-experts__container ">
        <div id="our-experts_carousel" class="our-experts__list owl-carousel owl-theme">
            <?php
                while( have_rows('our_experts',$postdata->ID) ) : the_row();
                $image = get_sub_field('image');                
                $url = $image['url'];
                $title = $image['title'];
                $alt = $image['alt'];
                $size = 'medium';
                $thumb = $image['sizes'][ $size ];
                $width = $image['sizes'][ $size . '-width' ];
                $height = $image['sizes'][ $size . '-height' ];
                $name = get_sub_field('name');
                $position = get_sub_field('position');
            ?>
            <div class="our-experts__item">
                <div class="our-experts__item__img-wrapper"></div>
                <img src="<?php echo $url;?>" title="<?php echo $title ?>" alt="<?php echo $alt ?>" width="<?php echo $width ?>" height="<?php echo $height ?>" class="our-experts__item__img">
                <span class="our-experts__item__name"><?php echo $name ?></span>
                <span class="our-experts__item__position"><?php echo $position ?></span>
            </div>
            <?php
                endwhile;
            ?>                 
        </div>
    </div>
</section>

<?php 
  endif;
?>