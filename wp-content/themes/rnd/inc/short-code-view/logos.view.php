<?php
extract($args);
if( have_rows('logos',$postdata->ID) ):
?>
<section class="logos">
  <div class="container logos__container">
    <div class="logos__table">
        <?php 
          while( have_rows('logos',$postdata->ID) ) : the_row();
            $image = get_sub_field('image');
            $link = get_sub_field('link');
            $url = $image['url'];
            $title = $image['title'];
            $alt = $image['alt'];
            $size = 'medium';
            $thumb = $image['sizes'][ $size ];
            $width = $image['sizes'][ $size . '-width' ];
            $height = $image['sizes'][ $size . '-height' ];

        ?>
          <a href="<?php echo $link ?>" class="logos__item" target="_new">
            <img src="<?php echo $url;?>" title="<?php echo $title ?>" alt="<?php echo $alt ?>" class="logos__item__img" width="<?php echo $width ?>" height="<?php echo $height ?>">
          </a>
        <?php 
          endwhile;      
        ?>
    </div>
  </div>
</section>
<?php 
  endif;
?>



