<?php get_header(); ?>
<?php
$term = get_queried_object();
$design = get_field('design', $term);
switch ($design):
  case 1:
    get_template_part('inc/views/news-design.view');
    break;
  case 2:
    get_template_part('inc/views/blog-design.view');
    break;
  case 4:
    get_template_part('inc/views/services/services.view');
    break;
endswitch;
?>
<?php get_footer(); ?>