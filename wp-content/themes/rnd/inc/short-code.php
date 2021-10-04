<?php 

$shortcode_type = array(
    0 => 'none',
    1 => 'list_gift',
    2 => 'promotions',
    8 => 'services_block'
);

add_shortcode('promotion-form','promotion_form_func');
function promotion_form_func($args){
    ob_start();
    get_template_part('inc/short-code-view/promotion-form.view');
    return ob_get_clean();
}

add_shortcode('list_gift', 'list_gift_func');
function list_gift_func($args){
    $post_id = $args['id'];
    $post = get_post($post_id);
    if($post):
        ob_start();
        get_template_part('inc/short-code-view/list-gifts.view','',array(
            'list_gifts' => get_field('list_gifts',$post_id)
        ));
        return ob_get_clean();
    endif;
    return;
}

add_shortcode('promotions', 'promotions_func');
function promotions_func($args){
    $post_id = $args['id'];
    $post = get_post($post_id);
    if($post):
        ob_start();
        get_template_part('inc/short-code-view/promotions.view','',array(
            'promotions' => get_field('promotions',$post_id)
        ));
        return ob_get_clean();
    endif;
    return;
}

add_shortcode('our_expert_list', 'our_expert_list_func');
function our_expert_list_func($args){
    $post_id = $args['id'];
    $post = get_post($post_id);
    if($post):
        ob_start();
        get_template_part('inc/short-code-view/our_expert_list.view','',array(
            'postdata' => $post
        ));
        return ob_get_clean();
    endif;
    return;
}

add_shortcode('detail_expert', 'detail_expert_func');
function detail_expert_func($args){
    $post_id = $args['id'];
    $post = get_post($post_id);
    if($post):
        ob_start();
        get_template_part('inc/short-code-view/detail_expert.view','',array(
            'postdata' => $post
        ));
        return ob_get_clean();
    endif;
    return;
}

add_shortcode('logo', 'logo_func');
function logo_func($args){
    $post_id = $args['id'];
    $post = get_post($post_id);
    if($post):
        ob_start();
        get_template_part('inc/short-code-view/logos.view','',array(
            'postdata' => $post
        ));
        return ob_get_clean();
    endif;
    return;
}

add_shortcode('main_slider', 'main_slider_func');
function main_slider_func($args){
    $post_id = $args['id'];
    $post = get_post($post_id);
    if($post):
        ob_start();
        get_template_part('inc/short-code-view/main_slider.view','',array(
            'postdata' => $post
        ));
        return ob_get_clean();
    endif;
    return;
}

add_shortcode('welcome_slider', 'welcome_slider_func');
function welcome_slider_func($args){
    $post_id = $args['id'];
    $post = get_post($post_id);
    if($post):
        ob_start();
        get_template_part('inc/short-code-view/welcome_slider.view','',array(
            'postdata' => $post
        ));
        return ob_get_clean();
    endif;
    return;
}

add_shortcode('enjoy_the_difference', 'enjoy_the_difference_func');
function enjoy_the_difference_func($args){
    $post_id = $args['id'];
    $post = get_post($post_id);
    if($post):
        ob_start();
        get_template_part('inc/short-code-view/enjoy_the_difference.view','',array(
            'postdata' => $post
        ));
        return ob_get_clean();
    endif;
    return;
}

add_shortcode('services_block', 'services_block_func');
function services_block_func($args){
    $post_id = $args['id'];
    $post = get_post($post_id);
    if($post):
        ob_start();
        get_template_part('inc/short-code-view/services_block.view','',array(
            'postdata' => $post,
            'service_block_01' => get_field('service_block_01',$post->ID),
            'service_block_2' => get_field('service_block_2',$post->ID),
            'service_block_image'=> get_field('service_block_image',$post->ID),
        ));
        return ob_get_clean();
    endif;
    return;
}