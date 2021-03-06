<?php
add_theme_support('post-thumbnails');
add_image_size('news-thumb', 356, 246, true);
add_image_size('blog-thumb', 1168, 622, true);

add_filter('upload_mimes', 'my_myme_types', 1, 1);
function my_myme_types($mime_types)
{
    $mime_types['webp'] = 'image/webp';
    return $mime_types;
}

function get_current_term()
{
    if (!is_category() && !is_tag() && !is_tax())
        return false;
    $term_slug = get_query_var('term');
    $taxonomyName = get_query_var('taxonomy');
    return get_term_by('slug', $term_slug, $taxonomyName);
}

function get_top_term($term)
{
    if ($term->parent != 0) :
        $pre_term = get_term($term->parent, 'product-category');
        $term = get_top_term($pre_term);
    endif;
    return $term;
}

function imageEncode($path)
{
    $path  = THEMES_DIR . "/" . $path;
    $image = file_get_contents($path);
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $type  = $finfo->buffer($image);
    return "data:" . $type . ";charset=utf-8;base64," . base64_encode($image);
}

function imageEncodePath($path)
{
    $image = file_get_contents($path);
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $type  = $finfo->buffer($image);
    return "data:" . $type . ";charset=utf-8;base64," . base64_encode($image);
}

function imageEncodeURL($path)
{
    $image = file_get_contents($path);
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $type  = $finfo->buffer($image);
    return "data:" . $type . ";charset=utf-8;base64," . base64_encode($image);
}

add_action('after_setup_theme', 'setup_crm');
function setup_crm()
{
    global $global_services;
    $home_id = get_option('page_on_front');
    if (API_FLAG == TRUE) :
        $global_services = get_field('general_crm_fields', $home_id);
    endif;
}
function objArraySearch($array, $index, $value)
{
    foreach ($array as $arrayInf) {
        if ($arrayInf[$index] == $value) {
            return $arrayInf;
        }
    }
    return null;
}
function meta_or_title_search($q)
{
    if ($title = $q->get('_meta_or_title')) {
        add_filter('get_meta_sql', function ($sql) use ($title) {
            global $wpdb;

            static $nr = 0;
            if (0 != $nr++) return $sql;

            $sql['where'] = sprintf(
                " AND ( (%s) OR (%s) ) ",
                $wpdb->prepare("{$wpdb->posts}.post_title LIKE '%%%s%%'", $title),
                mb_substr($sql['where'], 5, mb_strlen($sql['where']))
            );

            return $sql;
        });
    }
}
add_action('pre_get_posts', 'meta_or_title_search');
function getYouTubeVideoId($pageVideUrl)
{
    $link = $pageVideUrl;
    $video_id = explode("?v=", $link);
    if (!isset($video_id[1])) {
        $video_id = explode("youtu.be/", $link);
    }
    $youtubeID = $video_id[1];
    if (empty($video_id[1])) $video_id = explode("/v/", $link);
    $video_id = explode("&", $video_id[1]);
    $youtubeVideoID = $video_id[0];
    if ($youtubeVideoID) {
        return $youtubeVideoID;
    } else {
        return false;
    }
}

add_filter('the_content', 'add_buttons_store', 1);

function add_buttons_store($content)
{

    if (is_singular('dich-vu') || is_singular('tin-tuc')) :
        ob_start();
?>
        <div class="buttons">
            <button class="buttonpopup button__calendar" data-id="kpopup-calendar"></button>
            <button class="buttonpopup button__order" data-id="kpopup-metting"></button>
        </div>
    <?php
        $content = $content . ob_get_clean();
    endif;

    return $content;
}

function add_post_meta_boxes()
{
    add_meta_box(
        "post_metadata_crm_service_id",
        "CRM Service",
        "field_crm_service_id",
        "dich-vu",
        "side",
        "low"
    );
}
add_action("admin_init", "add_post_meta_boxes");

function get_crm_services($toarray = false, $service_id = '')
{
    $results = 0;
    $args = array(
        'headers' => array(
            'Content-Type' => 'application/json',
            'Access-Key' => API_CRM_ACCESS_KEY
        ),
        'body' => array(
            'RequestAction' => 'GetServiceRegister'
        )
    );
    if ($service_id) :
        $args['body']['service_id'] = $service_id;
    endif;
    $response = wp_remote_post(API_CRM_ROOT, $args);
    if (!is_wp_error($response)) :
        if ($toarray == true) :
            $results = json_decode($response['body'], true);
        else :
            $results = json_decode($response['body']);
        endif;
        if ($service_id) $results = $results[0];
    endif;
    return $results;
}
function save_service_registration($data)
{
    $args = array(
        'headers' => array(
            'Content-Type' => 'application/json',
            'Access-Key' => API_CRM_ACCESS_KEY
        ),
        'body' => array(
            'RequestAction' => 'SaveServiceRegistration',
            'Data' => $data
        )
    );
    $response = wp_remote_post(API_CRM_ROOT, $args);
    return json_decode($response['body'], true);
}

function field_crm_service_id()
{
    global $post;
    $services = get_crm_services();
    if ($services != 0) :
        $meta = get_post_custom($post->ID);
        $service_selected = $meta['_post_crm_service_id'][0];
    ?>
        <select name="_post_crm_service_id">
            <?php
            echo '<option value="">Please chooose...</option>';
            foreach ($services as $service) :
                if ($service->service_name  != '') :
            ?>
                    <option value="<?php echo $service->service_id ?>" <?php if ($service_selected == $service->service_id) echo "selected"; ?>><?php echo $service->service_name ?></option>
            <?php
                endif;
            endforeach;
            ?>
        </select>
        <?php
    endif;
}


function replaceCharsInNumber($num, $chars)
{
    return substr((string) $num, 0, -strlen($chars)) . $chars;
}

function hidden_phone($param)
{
    $total_length = strlen($param) - 4;
    $string = '';
    for ($a = 1; $a <= $total_length; $a++) :
        $string .= 'x';
    endfor;
    return $string . substr($param, -4);
}

function prefix_create_product($request)
{
    $results = '';
    $ladipage_name = '';
    $ladipage_phone = '';
    $ladipage_message = '';
    $ladipage_service_id = '';
    if (isset($request['ladipage_name'])) $ladipage_name = $request['ladipage_name'];
    if (isset($request['ladipage_phone'])) $ladipage_phone = $request['ladipage_phone'];
    if (isset($request['ladipage_service_id'])) $ladipage_service_id = $request['ladipage_service_id'];
    if (isset($request['ladipage_message'])) $ladipage_message = $request['ladipage_message'];
    if ($ladipage_name && $ladipage_phone && $ladipage_service_id) :
        $data = array(
            'firstname' =>  sanitize_text_field($ladipage_name),
            'mobile' => sanitize_text_field($ladipage_phone),
            'service_register_date' => date("Y-m-d"),
            'service_label' => $ladipage_service_id,
            'source' => 'WEBSITE SHYNHHOUSE'
        );
        $results = save_service_registration($data);
    endif;
    return rest_ensure_response($results);
}



function prefix_register_product_routes()
{
    register_rest_route('ladipages/v1', '/contacts', array(
        array(
            'methods'  => WP_REST_Server::CREATABLE,
            'callback' => 'prefix_create_product',
        ),
    ));
}

add_action('rest_api_init', 'prefix_register_product_routes');


add_action('wp_footer', 'add_poupform_single_post_func');
function add_poupform_single_post_func()
{
    global $post;
    if (is_single()) :
        $sevice_popup = get_field('sevice_popup', $post);
        if ($sevice_popup == 2) :
            $service_id = get_field('general_crm_fields', $post);

        ?>
            <div id="service-popup-<?php echo $post->ID ?>" data-action="service-popup-<?php echo $post->ID ?>" class="gform kpopup service__popup">
                <span class="kpopup__bg"></span>
                <div class="container">
                    <div class="kpopup__round contact__round">
                        <span class="kpopup__buttonclose lazy" data-bg="<?php bloginfo('template_directory') ?>/images/icon-close.png"></span>
                        <div class="contact__thanks">
                            <div class="kpopup__content">
                                <strong class="gform--tit"><?php _e('TH??NG TIN ?????T L???CH', SHYNH); ?></strong>
                                <form action="" method="post" class="contactForm" id="contact__popup" name="contact__popup">
                                    <div class="form__input">
                                        <input type="text" name="contactForm__name" id="contactForm__name" class="contactForm__name contactForm__input" placeholder="Vui l??ng h??? t??n">
                                    </div>
                                    <div class="form__input">
                                        <input type="text" name="contactForm__phone" id="contactForm__phone" class="contactForm__phone contactForm__input" placeholder="Vui l??ng nh???p s??? ??i???n tho???i">
                                    </div>
                                    <div class="form__input">
                                        <textarea name="contactForm__description" id="contactForm__description" cols="30" rows="5" class="contactForm__input appointment__register__input area-input" placeholder="N???i Dung ?????t L???ch" spellcheck="false"></textarea>
                                    </div>
                                    <div class="service__popup__submit">
                                        <input type="submit" name="contactForm__submit" id="contactForm__submit" class="button contactForm__submit" value="<?php _e('?????t L???ch', SHYNH) ?>">
                                    </div>
                                    <input type="hidden" name="nonce" class="nonce" value="<?php echo wp_create_nonce('add_contact_nonce') ?>">
                                    <input type="hidden" name="contactForm__category" class="contactForm__category" value="33">
                                    <input type="hidden" name="contactForm__service" class="contactForm__service" value="<?php echo $service_id ?>">
                                    <input type="hidden" name="contactForm__title" class="contactForm__title" value="<?php echo $post->post_title ?>">
                                    <input type="hidden" name="popup__id" class="popup__id" value="service-popup-<?php echo $post->ID ?>">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php
        endif;
    endif;
}

function change_page_menu_classes($menu)
{
    global $post;
    $cate_slug = '';
    $category = [];
    $cat_tmp = function($category){
        $category_parent_id = $category[0]->category_parent;
        if ($category_parent_id != 0) {
            $category_parent = get_term($category_parent_id, 'category');
            $cate_slug = $category_parent->slug;
        } else {
            $cate_slug = $category[0]->slug;
        }
        return $cate_slug;
    };
    if (is_category()) :
        $category = get_the_category();
        $cate_slug = $cat_tmp($category);
    endif;
    if(is_single()):
        $category = get_the_category($post->ID);
        $cate_slug = $cat_tmp($category);
    endif;
    if (is_category('dich-vu') || $cate_slug == 'dich-vu') :
        $menu = str_replace('menu-item-346', 'menu-item-346 current-menu-item', $menu); // add the current_page_parent class to the page you want
    endif;
    return $menu;
}
add_filter('nav_menu_css_class', 'change_page_menu_classes', 10, 2);
