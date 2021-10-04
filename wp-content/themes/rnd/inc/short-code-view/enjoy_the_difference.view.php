<?php
extract($args);
if( have_rows('enjoy_the_difference',$postdata->ID) ):
?>

<div id="enjoy-the-difference__slider" class="enjoy-the-difference__slider owl-carousel owl-theme">
  <?php 
    while( have_rows('enjoy_the_difference',$postdata->ID) ) : the_row();
    $image = get_sub_field('image');
    $url = $image['url'];
    $title = $image['title'];
    $alt = $image['alt'];
    $size = 'medium';
    $thumb = $image['sizes'][ $size ];
    $width = ($image['sizes'][ $size . '-width' ] > 1 ? $image['sizes'][ $size . '-width' ] : '492');
    $height = ($image['sizes'][ $size . '-height' ] > 1 ? $image['sizes'][ $size . '-height' ] : '493');   
    
  ?>
  <div class="enjoy-the-difference__item">
    <img src="<?php echo $url;?>" height="<?php echo $height ?>" width="<?php echo $width?>" title="<?php echo $title?>" alt="<?php echo $alt?>" class="enjoy-the-difference__item__img">
  </div>
  <?php 
    endwhile;
  ?>
</div>

<?php 
  endif;
?>