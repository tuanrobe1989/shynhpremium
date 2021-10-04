<?php
extract($args);
if( have_rows('welcome_slider',$postdata->ID) ):
?>

<div class="welcome__slider slider__carousel owl-carousel owl-theme">
  <?php
    while( have_rows('welcome_slider',$postdata->ID) ) : the_row();
    $image = get_sub_field('image');
    $url = $image['url'];
    $title = $image['title'];
    $alt = $image['alt'];
    $size = 'medium';
    $thumb = $image['sizes'][ $size ];
    $width = ($image['sizes'][ $size . '-width' ] > 1 ? $image['sizes'][ $size . '-width' ] : '866');
    $height = ($image['sizes'][ $size . '-height' ] > 1 ? $image['sizes'][ $size . '-height' ] : '461');    
    $display_title = get_sub_field('title');
  ?>
  <div class="welcome__item">
    <img src="<?php echo $url;?>" height="<?php echo $height ?>" width="<?php echo $width?>" title="<?php echo $title?>" alt="<?php echo $alt?>" class="welcome__item__img">
    <?php if($display_title): ?><h3 class="welcome__item__desc"><?php echo $display_title; ?></h3> <?php endif; ?>
  </div>
  <?php
  endwhile;
  ?>
</div>

<?php 
  endif;
?>