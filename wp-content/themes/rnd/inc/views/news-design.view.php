<section class="news-news">
  <div class="container news-news__container">
    <h1 class="news-news__title maintit"><?php _e('Tin Tức','shynh') ?></h1>
    <div class="news-news__list">
    <?php
    if (have_posts()) : while (have_posts()) : the_post();
    $post_id = get_the_ID();
    ?>
      <div class="news-news__item">
        <a href="<?php the_permalink();?>" class="news-news__item__img-link">
        <img src="<?php echo get_the_post_thumbnail_url($post_id,'news-thumb') ?>" alt="ALT" title="title" class="news-news__item__img"></a>
        <a href="<?php the_permalink();?>" class="news-news__item__title-link"><strong class="news-news__item__title h2"><?php the_title() ;?></strong></a>
      </div>
    <?php
    endwhile; endif;
    ?>
    </div>
  </div>
</section>