<?php
extract($args);
if($promotions):
?>
<div class="news-news__list promotion">
  <?php 
    foreach($promotions as $post): setup_postdata($post); 
      $gift_id = get_the_id();
      $post_thumbnail_url = get_the_post_thumbnail_url($post_id,'news-thumb');
  ?>
    <div class="news-news__item ">
        <a href="<?php the_permalink();?>" class="news-news__item__img-link">
        <img src="<?php echo imageEncode('/images/no-image-gift.webp'); ?>" data-src="<?php echo $post_thumbnail_url ?>" alt="ALT" title="title" class="news-news__item__img lazy"></a>
        <a href="<?php the_permalink();?>" class="news-news__item__title-link"><h2 class="news-news__item__title"><?php the_title() ;?></h2></a>
    </div>
  <?php endforeach; wp_reset_postdata();?>
</div>
<?php
endif;