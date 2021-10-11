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
    $columns['phone'] = __('Số Điện Thoại', 'shynh');
    $columns['crm_service_id'] = __('Service Id', 'shynh');
    $columns['service_name'] = __('Service Name', 'shynh');
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
    if ('service_name' === $column) {
        echo ucwords(get_post_meta($post_id, 'service_name', true));
    }
}

add_filter('manage_edit-contact_sortable_columns', 'contact_sortable_columns');
function contact_sortable_columns($columns)
{
    $columns['name'] = 'name';
    $columns['phone'] = 'phone';
    $columns['crm_service_id'] = 'crm_service_id';
    $columns['service_name'] = 'service_name';
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
    if ('phone' === $query->get('orderby')) :
        $query->set('orderby', 'meta_value');
        $query->set('meta_key', 'phone');
    endif;
    if ('crm_service_id' === $query->get('orderby')) :
        $query->set('orderby', 'meta_value');
        $query->set('meta_key', 'crm_service_id');
    endif;
    if ('service_name' === $query->get('orderby')) :
        $query->set('orderby', 'meta_value');
        $query->set('meta_key', 'service_name');
    endif;
}


add_action("wp_ajax_add_contact_promotion", "add_contact_promotion");
add_action("wp_ajax_nopriv_add_contact_promotion", "add_contact_promotion");

function add_contact_promotion()
{
    ob_start();
    if (!wp_verify_nonce($_REQUEST['nonce'], "add_contact_promotion_nonce")) {
        exit("Some wrong !");
    }
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        $result['type'] = 'false';
        $name = $_REQUEST["name"];
        $phone = trim($_REQUEST["phone"]);
        $phone = preg_replace('/^[ \t]*[\r\n]+/m', '', $phone);
        $service_crm_id = trim($_REQUEST["service_id"]);
        $service_crm_title = trim($_REQUEST["service_title"]);
        $args = array(
            'post_title' => $name . ' | ' . $phone,
            'post_type' => 'contact'
        );
        $post_id = wp_insert_post($args);
        if ($post_id) :
            wp_set_object_terms(
                $post_id,
                array(50),
                'contact-category'
            );
            $result['post_id'] = $post_id;
            update_field('name', sanitize_text_field($name), $post_id);
            update_field('phone', sanitize_text_field($phone), $post_id);
            if (API_FLAG == TRUE) :
                $servicecrm = get_crm_services(true, $service_crm_id);

                $data = array(
                    "firstname" => sanitize_text_field($name),
                    "mobile" => sanitize_text_field($phone),
                    "service_label" => $servicecrm['service_label'],
                    "service_register_date" => date("Y-m-d"),
                    "source" => "WEBSITE shynh"
                );
                $result['crm_service_registration'] = save_service_registration($data);
                update_field('crm_service_id', sanitize_text_field($service_crm_id), $post_id);
                update_field('service_name', sanitize_text_field($service_crm_title), $post_id);
            endif;
            $result['type'] = 'success';
            if (!isset($_COOKIE['submited_promotion_20_10'])) :
                setcookie('submited_promotion_20_10', true, (time() + 259200), '/');
            endif;
        endif;
        $result = json_encode($result);
        echo $result;
    } else {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }

    die();
    ob_end_flush();
}

function acf_load_crmvalues_field_choices( $field ) {
    $global_services = get_crm_services();
    $field['value'] = 0;
    $field['choices'] = array();
    if($global_services):
        foreach($global_services as $service):
            $field['choices'][$service->service_id] = $service->service_name;
        endforeach;
    endif;
    return $field;
}
// add_filter('acf/load_field/name=popup_crm_filed', 'acf_load_crmvalues_field_choices');
// add_filter('acf/load_field/name=general_crm_fields', 'acf_load_crmvalues_field_choices');
add_filter('acf/load_field/name=aaaaaa', 'acf_load_crmvalues_field_choices');