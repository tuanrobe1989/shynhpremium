<?php

/**
 * Lavo Coporation Template functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Lavo Coporation-dev-team
 * @since Lavo Coporation Template 1.0
 */

/**
 * Lavo Coporation Template only works in WordPress 7 or later.
 */
define('SHYNH', 'SHYNH');
global $global_services;
define('API_CRM_ROOT', 'https://shynhhouse.cloudpro.vn/api/WebsiteApi.php');
define('API_CRM_ACCESS_KEY', 'T5i0mVyrJP2AsjcN');
define('API_FLAG', TRUE);
global $home_id;
$home_id = get_option('page_on_front');
$theme = wp_get_theme();
define('THEME_VERSION', $theme->Version);
include get_theme_file_path('/inc/common.php');
include get_theme_file_path('/inc/short-code-post-type.php');
include get_theme_file_path('/inc/short-code.php');
include get_theme_file_path('/inc/contact-post-type.php');

add_action('wp_head', 'custom_wp_head');
add_action('admin_head', 'custom_wp_head');
function custom_wp_head()
{
    echo '<link rel="shortcut icon" type="image/png" href="' . get_template_directory_uri() . '/images/favicon.png">';
}
//SET UP INIT
add_filter('widget_text', 'do_shortcode');
add_action('init', 'init_function');
function init_function()
{
    add_theme_support('title-tag');
    register_nav_menu('header-menu', __('Header Menu'));
    //add_image_size( 'header-item-image', 486, 300, true );
}

//SETTINGS THEMES
add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar()
{
    show_admin_bar(false);
}


//ADD SCRIPTS
function add_theme_scripts()
{
    wp_enqueue_style('font-style', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Philosopher:wght@700&display=swap', array(), wp_get_theme()->Version, 'all');
    wp_enqueue_style('font-style-philosopher', 'https://fonts.googleapis.com/css2?family=Philosopher:wght@400;700&display=swap', array(), wp_get_theme()->Version, 'all');
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css', array(), wp_get_theme()->Version, 'all');
    wp_enqueue_style('style', get_template_directory_uri() . '/css/style.min.css', array(), wp_get_theme()->Version, 'all');
    wp_deregister_script('jquery');
    wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js', array(), null, TRUE);
    wp_register_script('script', get_template_directory_uri() . '/js/scripts.min.js', array('jquery'), wp_get_theme()->Version, true);
    $global_params = array(
        'themes_url' => get_template_directory_uri(),
        'ajaxurl' => admin_url( 'admin-ajax.php')
    );
    wp_localize_script('script', 'global_params', $global_params);
    wp_enqueue_script('script');
}

add_action('wp_enqueue_scripts', 'add_theme_scripts');

function wpdocs_theme_slug_widgets_init()
{
    register_sidebar(array(
        'name'          => __('Footer Sidebar', 'lavo'),
        'id'            => 'sidebar-footer',
        'description'   => __('Widgets display in footer', 'lavo'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h6 class="footer__title">',
        'after_title'   => '</h6>',
    ));
    register_sidebar(array(
        'name'          => __('Primary Sidebar', 'lavo'),
        'id'            => 'sidebar-primary',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="common__sidebar__tit">',
        'after_title'   => '</h3>',
    ));
    register_sidebar(array(
        'name'          => __('Video Sidebar', 'lavo'),
        'id'            => 'video-sidbar',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="common__sidebar__tit">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'wpdocs_theme_slug_widgets_init');

function custom_widget_menu($atts)
{
    return wp_nav_menu(
        array(
            'menu_class' => 'footer__menu',
            'menu' => $atts['id'],
            'echo' => false
        )
    );
}

add_shortcode('nextone_menu', 'custom_widget_menu');

class WPDocs_Walker_Nav_Menu extends Walker_Nav_Menu
{

    /**
     * Starts the list before the elements are added.
     *
     * Adds classes to the unordered list sub-menus.
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    function start_lvl(&$output, $depth = 0, $args = array())
    {
        // Depth-dependent classes.
        $indent = ($depth > 0  ? str_repeat("\t", $depth) : ''); // code indent
        $display_depth = ($depth + 1); // because it counts the first submenu as 0
        $classes = array(
            'sub-menu',
            ($display_depth % 2  ? 'menu-odd' : 'menu-even'),
            ($display_depth >= 2 ? 'sub-sub-menu' : ''),
            'menu-depth-' . $display_depth
        );
        $class_names = implode(' ', $classes);

        // Build HTML for output.
        if ($depth == 0) :
            $output .= "\n" . $indent . '<div class="header__menu__subround"><div class="container"><ul class="' . $class_names . '">' . "\n";
        else :
            $output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
        endif;
    }
    function end_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);

        if ($depth == 0) :
            $output .= "$indent</ul></div></div>\n";
        else :
            $output .= "$indent</ul>\n";
        endif;
    }

    /**
     * Start the element output.
     *
     * Adds main/sub-classes to the list items and links.
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Menu item data object.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     * @param int    $id     Current item ID.
     */
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        global $wp_query;
        $indent = ($depth > 0 ? str_repeat("\t", $depth) : ''); // code indent

        // Depth-dependent classes.
        $depth_classes = array(
            ($depth == 0 ? 'main-menu-item' : 'sub-menu-item'),
            ($depth >= 2 ? 'sub-sub-menu-item' : ''),
            ($depth % 2 ? 'menu-item-odd' : 'menu-item-even'),
            'menu-item-depth-' . $depth
        );
        $depth_class_names = esc_attr(implode(' ', $depth_classes));

        // Passed classes.
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $class_names = esc_attr(implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item)));

        // Build HTML.
        $output .= $indent . '<li id="nav-menu-item-' . $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';

        // Link attributes.
        $attributes  = !empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target)     ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn) . '"' : '';
        $attributes .= !empty($item->url)        ? ' href="'   . esc_attr($item->url) . '"' : '';
        $attributes .= ' class="menu-link ' . ($depth > 0 ? 'sub-menu-link' : 'main-menu-link') . '"';

        // Build HTML output and pass through the proper filter.
        $item_output = sprintf(
            '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
            $args->before,
            $attributes,
            $args->link_before,
            apply_filters('the_title', $item->title, $item->ID),
            $args->link_after,
            $args->after
        );
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

function gp_parse_request_trick($query)
{

    // Only noop the main query
    if (!$query->is_main_query())
        return;

    // Only noop our very specific rewrite rule match
    if (2 != count($query->query) || !isset($query->query['page'])) {
        return;
    }

    // 'name' will be set if post permalinks are just post_name, otherwise the page rule will match
    if (!empty($query->query['name'])) {
        $query->set('post_type', array('post', 'page'));
    }
}
add_action('pre_get_posts', 'gp_parse_request_trick');


add_filter('request', 'rudr_change_term_request', 1, 1);

function rudr_change_term_request($query)
{
    if (!$query) return $query;
    $tax_name = 'category'; // specify you taxonomy name here, it can be also 'category' or 'post_tag'

    // Request for child terms differs, we should make an additional check
    if (isset($query['attachment'])) :
        $include_children = true;
        $name = $query['attachment'];
    else :
        $include_children = false;
        $name = $query['name'];
    endif;


    $term = get_term_by('slug', $name, $tax_name); // get the current term to make sure it exists

    if (isset($name) && $term && !is_wp_error($term)) : // check it here

        if ($include_children) {
            unset($query['attachment']);
            $parent = $term->parent;
            while ($parent) {
                $parent_term = get_term($parent, $tax_name);
                $name = $parent_term->slug . '/' . $name;
                $parent = $parent_term->parent;
            }
        } else {
            unset($query['name']);
        }

        switch ($tax_name):
            case 'category': {
                    $query['category_name'] = $name; // for categories
                    break;
                }
            case 'post_tag': {
                    $query['tag'] = $name; // for post tags
                    break;
                }
            default: {
                    $query[$tax_name] = $name; // for another taxonomies
                    break;
                }
        endswitch;

    endif;

    return $query;
}


add_filter('term_link', 'rudr_term_permalink', 10, 3);

function rudr_term_permalink($url, $term, $taxonomy)
{

    $taxonomy_name = 'category'; // your taxonomy name here
    $taxonomy_slug = 'category'; // the taxonomy slug can be different with the taxonomy name (like 'post_tag' and 'tag' )

    // exit the function if taxonomy slug is not in URL
    if (strpos($url, $taxonomy_slug) === FALSE || $taxonomy != $taxonomy_name) return $url;

    $url = str_replace('/' . $taxonomy_slug, '', $url);

    return $url;
}


add_action('template_redirect', 'rudr_old_term_redirect');

function rudr_old_term_redirect()
{

    $taxonomy_name = 'category';
    $taxonomy_slug = 'category';

    // exit the redirect function if taxonomy slug is not in URL
    if (strpos($_SERVER['REQUEST_URI'], $taxonomy_slug) === FALSE)
        return;

    if ((is_category() && $taxonomy_name == 'category') || (is_tag() && $taxonomy_name == 'post_tag') || is_tax($taxonomy_name)) :

        wp_redirect(site_url(str_replace($taxonomy_slug, '', $_SERVER['REQUEST_URI'])), 301);
        exit();

    endif;
}
