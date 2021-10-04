<?php
function short_code_post_type()
{
 

    $label = array(
        'name' => __('Shortcode',SHYNH), 
        'singular_name' => __('Shortcode',SHYNH)
    );
 
    $args = array(
        'labels' => $label, 
        'description' =>  __('Post type Shortcode',SHYNH),
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'author',
            'thumbnail',
            'comments',
            'trackbacks',
            'revisions',
            'custom-fields',
            'post-format'
        ),
        'show_in_rest' => true,
        'hierarchical' => true, 
        'public' => true, 
        'show_ui' => true, 
        'show_in_menu' => true, 
        'show_in_nav_menus' => true, 
        'show_in_admin_bar' => true, 
        'menu_position' => 5, 
        'menu_icon' => 'dashicons-database-add', 
        'can_export' => true, 
        'has_archive' => false, 
        'exclude_from_search' => false, 
        'publicly_queryable' => true, 
        'rewrite' => array(
            'slug' => '',
            'with_front' => false
        )
 
    );
 
    register_post_type('shortcode', $args); 

}


add_action('init', 'short_code_post_type');