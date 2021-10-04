<?php
extract($args);
if( have_rows('main_slider',$postdata->ID) ):
?>

<session class="main-slider animate__animated animate__fadeIn">
  <div class="main-slider__wrapper slider__carousel owl-carousel owl-theme">
    <?php
      
      while( have_rows('main_slider',$postdata->ID) ) : the_row();
      $image = get_sub_field('image');
      $url = $image['url'];
      $title = $image['title'];
      $alt = $image['alt'];
      $size = 'large';
      $thumb = $image['sizes'][ $size ];
      $width = ($image['sizes'][ $size . '-width' ] > 1 ? $image['sizes'][ $size . '-width' ] : '1722');
      $height = ($image['sizes'][ $size . '-height' ] > 1 ? $image['sizes'][ $size . '-height' ] : '600');
      $m_image = get_sub_field('m_image');                
      $m_url = $m_image['url'];
      $m_title = $m_image['title'];
      $m_alt = $m_image['alt'];
      $m_size = 'medium';
      $m_thumb = $m_image['sizes'][ $size ];
      $m_width = $m_image['sizes'][ $size . '-width' ];
      $m_height = $m_image['sizes'][ $size . '-height' ];
      $link = get_sub_field('link');
      
    ?>
    <a href="<?php echo $link ?>" class="main-slider__item">
      <picture class="main-slider__item__img-wrapper ">          
          <source media="(min-width:992px)" srcset="<?php echo $url;?>" title="<?php echo $title ?>" alt="<?php echo $alt ?>">
          <img src="<?php echo $m_url;?>" height="600" width="1722" title="<?php echo $title ?>" alt="<?php echo $alt ?>" >
      </picture>      
    </a>
    <?php
      endwhile;
    ?>
  </div>
</session>

<?php 
  endif;
?>