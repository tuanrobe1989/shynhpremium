<section class="news-blog">
  <div class="container news-blog__container">
    <h1 class="news-blog__title maintit">BEAUTY BLOG</h1>
    <div class="news-blog__list">
    <?php
    if (have_posts()) : while (have_posts()) : the_post();
    $post_id = get_the_ID();
    ?>
      <div class="news-blog__item">
        <a href="<?php the_permalink();?>" class="news-blog__item__img-link">
        <img src="<?php echo get_the_post_thumbnail_url($post_id,'blog-thumb') ?>" alt="ALT" title="title" class="news-blog__item__img"></a>
        <a href="<?php the_permalink();?>" class="news-blog__item__title-link"><h2 class="news-blog__item__title"><?php the_title() ;?></h2></a>
        <p class="news-blog__item__desc"><?php the_excerpt(); ?></p>
      </div>
    <?php
    endwhile; endif;
    ?>
    </div>
  </div>
</section>