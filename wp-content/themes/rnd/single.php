<?php get_header(); ?>
<section class="blog">
  <div class="container blog__container">
    <h1 class="blog__title  h2 maintit"><?php the_title() ?></h1>
    <?php 
      if ( function_exists('yoast_breadcrumb') ):
          yoast_breadcrumb( '<p id="breadcrumbs">','</p>');
      endif;
    ?>
    <div class="blog__content">
    <?php the_content(); ?>
    </div>
  </div>
</section>
<?php get_footer(); ?>

