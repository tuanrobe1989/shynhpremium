<?php
function contact_post_type()
{


    $label = array(
        'name' => __('Tổng Hợp Liên Hệ', 'shynh'),
        'singular_name' => __('Bài Viết', 'shynh')
    );

    $args = array(
        'labels' => $label,
        'description' =>  __('Post type Tổng Hợp Liên Hệ', 'shynh'),
        'supports' => array(
            'title',
            // 'editor',
            // 'excerpt',
            // 'author',
            // 'thumbnail',
            // 'comments',
            // 'trackbacks',
            // 'revisions',
            // 'custom-fields'
        ),
        'hierarchical' => false,
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-universal-access',
        'can_export' => true,
        'has_archive' => false,
        'exclude_from_search' => true,
        'publicly_queryable' => true,

    );

    register_post_type('contact', $args);


    $taxonomylabels = array(
        'name' => _x('Loại liên hệ', 'shynh'),
        'singular_name' => _x('Loại liên hệ', 'shynh'),
        'search_items' => __('Tìm Loại liên hệ', 'shynh'),
        'all_items' => __('Tất cả Loại liên hệ', 'shynh'),
        'edit_item' => __('Sửa Loại liên hệ', 'shynh'),
        'add_new_item' => __('Thêm loại mới', 'shynh'),
        'menu_name' => __('Loại liên hệ', 'shynh'),
    );
    $args = array(
        'labels' => $taxonomylabels,
        'show_ui'           => true,
        'hierarchical'      => true,
        'show_in_rest' => true,
        'update_count_callback' => '_update_generic_term_count'
    );
    register_taxonomy('contact-category', 'contact', $args);
}

add_action('init', 'contact_post_type');


add_filter('manage_contact_posts_columns', 'add_contact_columns');
function add_contact_columns($columns)
{
    $columns['name'] = __('Họ Tên', 'shynh');
    $columns['email'] = __('Email', 'shynh');
    $columns['phone'] = __('Số Điện Thoại', 'shynh');
    $columns['crm_service_id'] = __('Service Id', 'shynh');
    $columns['contact_title'] = __('Form Title', 'shynh');
    $columns['ftag'] = __('Tag', 'shynh');
    return $columns;
}

add_action('manage_contact_posts_custom_column', 'value_contact_columns', 10, 2);
function value_contact_columns($column, $post_id)
{
    if ('name' === $column) {
        echo ucwords(get_post_meta($post_id, 'name', true));
    }
    if ('phone' === $column) {
        echo ucwords(get_post_meta($post_id, 'phone', true));
    }
    if ('crm_service_id' === $column) {
        echo ucwords(get_post_meta($post_id, 'crm_service_id', true));
    }
    if ('contact_title' === $column) {
        echo ucwords(get_post_meta($post_id, 'contact_title', true));
    }
    if ('ftag' === $column) {
        echo ucwords(get_post_meta($post_id, 'ftag', true));
    }
}

add_filter('manage_edit-contact_sortable_columns', 'contact_sortable_columns');
function contact_sortable_columns($columns)
{
    $columns['name'] = 'name';
    $columns['phone'] = 'phone';
    $columns['email'] = 'email';
    $columns['crm_service_id'] = 'crm_service_id';
    $columns['contact_title'] = 'contact_title';
    $columns['ftag'] = 'ftag';
    return $columns;
}

add_action('pre_get_posts', 'contact_orderby');
function contact_orderby($query)
{
    if (!is_admin() || !$query->is_main_query()) :
        return;
    endif;
    if ('name' === $query->get('orderby')) :
        $query->set('orderby', 'meta_value');
        $query->set('meta_key', 'name');
    endif;
    if ('email' === $query->get('orderby')) :
        $query->set('orderby', 'meta_value');
        $query->set('meta_key', 'email');
    endif;
    if ('phone' === $query->get('orderby')) :
        $query->set('orderby', 'meta_value');
        $query->set('meta_key', 'phone');
    endif;
    if ('crm_service_id' === $query->get('orderby')) :
        $query->set('orderby', 'meta_value');
        $query->set('meta_key', 'crm_service_id');
    endif;
    if ('contact_title' === $query->get('orderby')) :
        $query->set('orderby', 'meta_value');
        $query->set('meta_key', 'contact_title');
    endif;
    if ('ftag' === $query->get('orderby')) :
        $query->set('orderby', 'meta_value');
        $query->set('meta_key', 'ftag');
    endif;
}


add_action("wp_ajax_add_contact", "add_contact");
add_action("wp_ajax_nopriv_add_contact", "add_contact");

function add_contact()
{
    ob_start();
    if (!wp_verify_nonce($_REQUEST['nonce'], "add_contact_nonce")) {
        exit("Some wrong !");
    }
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        //Convert  Param
        $result['type'] = 0;
        $result['msg'] = '';
        $name = wp_strip_all_tags($_REQUEST["name"]);
        $email = wp_strip_all_tags($_REQUEST["email"]);
        $phone = wp_strip_all_tags($_REQUEST["phone"]);
        $phone = preg_replace('/^[ \t]*[\r\n]+/m', '', $phone);
        $description = wp_strip_all_tags($_REQUEST["description"]);
        $service_crm_id = wp_strip_all_tags($_REQUEST["service_id"]);
        $title = wp_strip_all_tags($_REQUEST["title"]);
        $term_id = wp_strip_all_tags($_REQUEST["term_id"]);
        $fcookie = wp_strip_all_tags($_REQUEST["fcookie"]);
        $ftag = wp_strip_all_tags($_REQUEST["ftag"]);
        $args = array(
            'post_title' => $name . ' | ' . $phone,
            'post_type' => 'contact'
        );
        $post_id = wp_insert_post($args);
        if ($post_id) :
            $result['post_id'] = $post_id;
            //Register Term Post
            if ($term_id) : $term_id = $term_id * 1;
                wp_set_object_terms(
                    $post_id,
                    array($term_id),
                    'contact-category'
                );
            endif;
            //Update Post Meta
            if ($name) update_field('name', sanitize_text_field($name), $post_id);
            if ($phone) update_field('phone', sanitize_text_field($phone), $post_id);
            if ($email) update_field('email', sanitize_text_field($email), $post_id);
            if ($description) update_field('description', sanitize_text_field($description), $post_id);
            if ($ftag) update_field('ftag', sanitize_text_field($ftag), $post_id);
            if (API_FLAG == TRUE) :
                $servicecrm = get_crm_services(true, $service_crm_id);
                if ($servicecrm) :
                    $data = array(
                        "firstname" => sanitize_text_field($name),
                        "mobile" => sanitize_text_field($phone),
                        "service_label" => $servicecrm['service_label'],
                        "service_register_date" => date("Y-m-d"),
                        "source" => "WEBSITE SHYNH PREMIUM",
                        "description" => $description
                    );
                    $result['crm_service_registration'] = save_service_registration($data);
                    update_field('crm_service_id', sanitize_text_field($service_crm_id), $post_id);
                    update_field('contact_title', sanitize_text_field($title), $post_id);
                endif;
            endif;
            $result['msg'] = 'Cám ơn bạn đăng ký, <br>chúng tôi sẽ liên hệ hỗ trợ bạn ngay!';
            $result['status'] = 1;
            do_action('kpopup_after_susscess', $fcookie);
        else :
            $result['msg'] = __('Có lỗi xảy ra trong quá trình xử lý, bạn hảy thử lại nhé', 'shynh');
            $result['status'] = 2;
        endif;
        $result = json_encode($result);
        echo $result;
    } else {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }

    die();
    ob_end_flush();
}

setcookie('main__popup', '', time() - 3600, '/');
add_action('kpopup_after_susscess', 'set_cookie_mainpopup', 10,);
function set_cookie_mainpopup($param)
{
    if (!isset($_COOKIE[$param])) :
        setcookie($param, true, (time() + 259200), '/');
    endif;
}

function acf_load_crmvalues_field_choices($field)
{
    $global_services = get_crm_services();
    $field['choices'] = array();
    if ($global_services) :
        foreach ($global_services as $service) :
            $field['choices'][$service->service_id] = $service->service_name;
        endforeach;
    endif;
    return $field;
}
add_filter('acf/load_field/name=general_crm_fields', 'acf_load_crmvalues_field_choices');


// ADD THANKS POPUP
add_action('wp_footer', 'add_footer_popup_func');
function add_footer_popup_func()
{
    $popup_title = get_bloginfo('name');
    ob_start();
?>
    <div id="common-popup" class="kpopup">
        <span class="kpopup__bg"></span>
        <div class="container">
            <div class="kpopup__round contact__round">
                <span class="kpopup__buttonclose lazy" data-bg="<?php bloginfo('template_directory') ?>/images/icon-close.png"></span>
                <div class="contact__thanks">
                    <div class="kpopup__title"><?php echo $popup_title; ?></div>
                    <div class="kpopup__content"></div>
                </div>
            </div>
        </div>
    </div>
<?php
    echo ob_get_clean();
}


//Add Popup Common
add_action('wp_footer', 'main_popup_func');
function main_popup_func()
{
    $popup_title = get_bloginfo('name');
    ob_start();
?>
    <div id="main__popup" data-action="common-popup" data-cookie="main__popup" class="kpopup main__popup" data-autoload="6000">
        <span class="kpopup__bg"></span>
        <div class="container">
            <div class="kpopup__round contact__round">
                <span class="kpopup__buttonclose lazy" data-bg="<?php bloginfo('template_directory') ?>/images/icon-close.png"></span>
                <div class="contact__thanks">
                    <div class="kpopup__content">
                        <form action="" method="post" class="contactForm" id="contact__popup" name="contact__popup">
                            <div class="form__input">
                                <input type="text" name="contactForm__name" id="contactForm__name" class="contactForm__name contactForm__input" placeholder="<?php _e('Vui lòng họ tên', SHYNH) ?>" />
                            </div>
                            <div class="form__input">
                                <input type="text" name="contactForm__phone" id="contactForm__phone" class="contactForm__phone contactForm__input" placeholder="<?php _e('Vui lòng nhập số điện thoại', SHYNH) ?>" />
                            </div>
                            <input type="submit" name="contactForm__submit" id="contactForm__submit" class="button contactForm__submit" value="" />
                            <input type="hidden" name="nonce" class="nonce" value="<?php echo wp_create_nonce('add_contact_nonce') ?>" />
                            <input type="hidden" name="contactForm__category" class="contactForm__category" value=39" />
                            <input type="hidden" name="contactForm__service" class="contactForm__service" value="17" />
                            <input type="hidden" name="contactForm__title" class="contactForm__title" value="Dịch Vụ Soi Da 0 Đồng" />
                            <input type="hidden" name="popup__id" class="popup__id" value="main-popup" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
    echo ob_get_clean();
}
